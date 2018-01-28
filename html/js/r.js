var files_list = null;
var hislog = {};
var search_path = null;

var get_file_list = function (data, success_callback = null, error_callback = null) {
    ajax_post(
        '/?z=get_files',
        data,
        function (data) {
            if (data.code === 0) {
                if (files_list != null) {
                    files_list.files_list = data.data
                    files_list.paths = data.paths
                    files_list.path = data.path
                    search_path = null
                    $('#search').val('Files');
                }
            } else {
                console.log(data.msg);
            }
            if (success_callback != null) {
                success_callback(data);
            }
        },
        function (data) {
            console.log(JSON.stringify(data));
            if (error_callback != null) {
                error_callback(data);
            }
        }
    );
}

var init_file_list = function () {
    var h = decodeURIComponent(window.location.pathname);
    var s = GetQueryString('s');
    if (h == null) {
        h = '';
    }
    if (s != null) {
        search_file(s, h);
    } else {
        get_file_list(
            JSON.stringify({
                'path': h
            }),
            function (data) {
                if (files_list != null) {
                    files_list.files_list = data.data
                    files_list.paths = data.paths
                    files_list.path = data.path
                } else {
                    files_list = new Vue({
                        el: '#files_data',
                        data: {
                            files_list: data.data,
                            paths: data.paths,
                            path: data.path,
                        }
                    });
                }
            }
        );
    }
}

function q(path, qtf = '') {
    var zcpath = qtf;
    if (zcpath == '') {
        zcpath = files_list.path.substring(1);
    }
    history.pushState(hislog, '', zencodeURIComponent('http://' + window.location.host.replace('/', '') + zcpath + path));
    get_file_list(
        JSON.stringify({
            'path': zcpath + path
        })
    );
}

function f(path, qtf = '') {
    var hjpath = path;
    var zcpath = qtf;
    if (zcpath == '') {
        zcpath = files_list.path.substring(1);
    }
    var tpath = hjpath.split('.');
    var format = tpath[tpath.length - 1].toLowerCase();
    var ypath = zcpath;
    var hpath = ypath + hjpath;
    switch (format) {
        case 'png':
        case 'jpg':
        case 'gif':
        case 'bmp':
        case 'jpeg':
        case 'ico':
        case 'cur':
            var temp_images = [];
            var qi = 0;
            var zi = 0;
            for (var i = 0; i < files_list.files_list.length; i++) {
                if (files_list.files_list[i].type == 1) {
                    tpath = files_list.files_list[i].name.split('.');
                    switch (tpath[tpath.length - 1].toLowerCase()) {
                        case 'png':
                        case 'jpg':
                        case 'gif':
                        case 'bmp':
                        case 'jpeg':
                        case 'ico':
                        case 'cur':
                            var temp_images2 = {
                                "alt": files_list.files_list[i].name,
                                "src": zencodeURIComponent(ypath + files_list.files_list[i].name),
                                "thumb": zencodeURIComponent(ypath + files_list.files_list[i].name)
                            };
                            if (files_list.files_list[i].name == hjpath) {
                                qi = zi;
                            }
                            zi++;
                            temp_images.push(temp_images2);
                            break;
                        default:
                    }
                }
            }
            show_image(qi, temp_images);
            break;
        case 'flv':
        case 'mp4':
        case 'mkv':
        case 'swf':
        case 'avi':
        case 'mov':
        case 'wmv':
        case 'f4v':
        case 'm3u8':
            show_vedio(zencodeURIComponent(hpath));
            break;
        case 'pdf':
            show_pdf(zencodeURIComponent(hpath), hjpath);
            break;
        case 'txt':
        case 'html':
        case 'js':
        case 'css':
            show_txt(zencodeURIComponent(hpath));
            break;
        default:
            window.open(zencodeURIComponent(hpath));
    }
}

var show_txt = function (path) {
    layer.open({
        type: 2,
        title: false,
        area: ['60%', '80%'],
        shade: 0.8,
        closeBtn: 0,
        shadeClose: true,
        content: path
    });
}

var show_pdf = function (path, name) {
    layer.open({
        type: 1,
        title: name,
        closeBtn: 0,
        shade: 0.8,
        area: ['60%', '80%'],
        maxmin: true,
        shadeClose: true,
        content: '<!DOCTYPE html><html style=\"background-color:#262626;height:100%;width:100%;overflow:hidden;margin:0\"><head></head><body style=\"background-color:#262626;height:100%;width:100%;overflow:hidden;margin:0\"><embed width=\"100%\" height=\"100%\" src=\"' + path + '\" type=\"application/pdf\" style=\"margin:0;padding:0;overflow:hidden;display:block\"></body></html>'
    });
}

var show_vedio = function (path) {
    layer.open({
        type: 1,
        title: false,
        closeBtn: 0,
        shade: 0.8,
        area: ['60%', '80%'],
        shadeClose: true,
        content: '<!DOCTYPE html><html><head><script type=\"text/javascript\" src=\"/%3E/ckplayer/ckplayer.js\"></script></head><body style=\"margin:0;padding:0;border:0\" scroll=\"no\"><div class=\"video\" style=\"width:100%;height:100%\"></div><script type=\"text/javascript\">function zencodeURIComponent(e){return encodeURIComponent(e).replaceAll(\"%2F\",\"/\").replaceAll(\"%2f\",\"/\").replaceAll(\"%3A\",\":\").replaceAll(\"%3a\",\":\")}String.prototype.replaceAll=function(e,l){return this.replace(new RegExp(e,\"gm\"),l)};var videoObject={container:\".video\",variable:\"player\",autoplay:!0,mobileCkControls:!0,video:zencodeURIComponent(\"' + path + '\")},player=new ckplayer(videoObject);</script></body></html>'
    });
}

var show_image = function (start, images) {
    layer.photos({
        photos: {
            "title": 'Images',
            "start": start,
            "data": images
        },
        anim: 5,
        move: false,
        shade: 0.8,
    });
}

function m(path) {
    history.pushState(hislog, '', zencodeURIComponent('http://' + window.location.host.replace('/', '') + path.substring(1)));
    get_file_list(
        JSON.stringify({
            'path': path
        })
    );
}

window.addEventListener('popstate', function (event) {
    init_file_list();
});

$('#search').focus(function () {
    $(this).val('');
});

$('#search').blur(function () {
    $(this).val('Files');
});

var search_file = function (str = '', path = '') {
    var zstr = str;
    var zpath = path;
    if (zstr == '') {
        zstr = $('#search').val();
    }
    if (zpath == '') {
        zpath = files_list.path;
    }
    if (zstr.length <= 0) {
        $('#search').blur();
        //因为这里的window.location.pathname在设置url的时候已经被编码，所以不用重复编码了
        history.pushState(hislog, '', 'http://' + window.location.host.replace('/', '') + window.location.pathname);
        init_file_list();
        return;
    }
    if (search_path == null) {
        search_path = zpath;
    }
    history.pushState(hislog, '', '?s=' + zencodeURIComponent(zstr));
    $('#search').val(zstr);
    ajax_post(
        '/?z=search_files',
        JSON.stringify({
            'search_str': zstr,
            'search_path': search_path
        }),
        function (data) {
            if (data.code === 0) {
                if (files_list != null) {
                    files_list.files_list = data.data
                    files_list.paths = data.paths
                    files_list.path = data.path
                } else {
                    files_list = new Vue({
                        el: '#files_data',
                        data: {
                            files_list: data.data,
                            paths: data.paths,
                            path: data.path,
                        }
                    });
                }
            } else {
                console.log(data.msg);
            }
        }
    );
}

$('#search').keyup(function () {
    search_file();
});

init_file_list();