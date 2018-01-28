function ajax_post(url, data, success_callback = null, error_callback = null) {
    $.ajax({
        type: 'POST',
        url: url + '&_=' + (new Date()).getTime(),
        dataType: 'json',
        data: data,
        success: function (data) {
            if (success_callback != null) {
                success_callback(data);
            }
        },
        error: function (data) {
            if (error_callback != null) {
                error_callback(data);
            }
        },
        xhr: function () {
            $.AMUI.progress.start();
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function (e) {
                    if (parseInt(e.loaded / e.total * 100) == 100) {
                        $.AMUI.progress.done();
                    }
                }, false);
            }
            return xhr;
        },
    });
}

function ajax_get(url, success_callback = null, error_callback = null) {
    $.ajax({
        type: 'GET',
        url: url + '&_=' + (new Date()).getTime(),
        dataType: 'json',
        success: function (data) {
            if (success_callback != null) {
                success_callback(data);
            }
        },
        error: function (data) {
            if (error_callback != null) {
                error_callback(data);
            }
        },
        xhr: function () {
            $.AMUI.progress.start();
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function (e) {
                    if (parseInt(e.loaded / e.total * 100) == 100) {
                        $.AMUI.progress.done();
                    }
                }, false);
            }
            return xhr;
        },
    });
}

function init_loadjs(url, q_callback = null, h_callback = null) {
    if (q_callback != null) {
        q_callback();
    }
    $.getScript(url);
    if (h_callback != null) {
        h_callback();
    }
}

function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURI(r[2]); return null;
}

String.prototype.replaceAll = function (s1, s2) {
    return this.replace(new RegExp(s1, "gm"), s2);
}

function zencodeURIComponent(str) {
    return encodeURIComponent(str).replaceAll('%2F', '/').replaceAll('%2f', '/').replaceAll('%3A', ':').replaceAll('%3a', ':');
}