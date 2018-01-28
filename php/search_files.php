<?php

class search_files
{
    public static function r($di)
    {
        $mjson = new Myjson();

        $search_str = '';
        $search_files = array();

        $getdata = json_decode(file_get_contents('php://input'));
        if (isset($getdata)) {
            foreach ($getdata as $key => $val) {
                $$key = rRec($val);
            }
        }

        //search_str search_path

        $search_path = '/'.$search_path.'/';
        $search_path = str_replace('/../', '/', str_replace('\\', '/', $search_path));
        $ypath = FILES_PATH.$search_path;
        $ypath = str_replace('/../', '/', str_replace('\\', '/', $ypath));

        repxg($ypath);
        repxg($search_path);

        search_all_files($ypath, $search_str, $search_files, FILES_PATH);

        $mjson->add('code', 0);
        $mjson->add('msg', '搜索成功！');
        $mjson->add('count', count($search_files));
        $mjson->add('paths', array('/', 'Files-Search-'.$search_str));
        $mjson->add('path', '/Files-Search/');
        $mjson->add('data', $search_files);
        $mjson->techo();
    }
}
