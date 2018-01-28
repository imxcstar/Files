<?php

class get_files
{
    public static function r($di)
    {
        $mjson = new Myjson();

        $path = '/';

        $getdata = json_decode(file_get_contents('php://input'));
        if (isset($getdata)) {
            foreach ($getdata as $key => $val) {
                $$key = rRec($val);
            }
        }

        //path

        $ypath = '/'.$path.'/';
        $ypath = str_replace('/../', '/', str_replace('\\', '/', $ypath));
        $path = FILES_PATH.$ypath;
        $path = str_replace('/../', '/', str_replace('\\', '/', $path));
        $filelist = scandir($path);
        $files = array();
        foreach ($filelist as $file) {
            if ('.' != $file && '..' != $file) {
                $t_file = array();
                $t_path = $path.'//'.$file;
                repxg($t_path);
                $t_stat = stat($t_path);
                $t_file['time'] = date('d-M-Y h:i', $t_stat['mtime']);
                if (is_file($t_path)) {
                    $t_file['name'] = $file;
                    $t_size = $t_stat['size'];
                    if ($t_size >= 1073741824) {
                        $t_size = (round($t_size / 1073741824 * 100) / 100).' G';
                    } elseif ($t_size >= 1048576) {
                        $t_size = (round($t_size / 1048576 * 100) / 100).' M';
                    } elseif ($t_size >= 1024) {
                        $t_size = (round($t_size / 1024 * 100) / 100).' K';
                    } else {
                        $t_size = $t_size.' b';
                    }
                    $t_file['size'] = $t_size;
                    $t_file['type'] = 1;
                } else {
                    $t_file['name'] = $file.'/';
                    $t_file['size'] = '-';
                    $t_file['type'] = 0;
                }
                array_push($files, $t_file);
            }
        }
        if ('/' == $ypath) {
            $ypath = array('/');
        } else {
            $ypath = explode('/', $ypath);
        }
        if ('' == $ypath[0]) {
            $ypath[0] = '/';
        }
        $i = 0;
        $x_ypath = array();
        foreach ($ypath as $t_ypath) {
            if ('' != $t_ypath) {
                array_push($x_ypath, $t_ypath);
            }
            ++$i;
        }
        $mjson->add('code', 0);
        $mjson->add('msg', '获取成功！');
        $mjson->add('count', count($files));
        $mjson->add('paths', $x_ypath);
        $mjson->add('path', implode('/', $x_ypath).'/');
        $mjson->add('data', $files);
        $mjson->techo();
    }
}
