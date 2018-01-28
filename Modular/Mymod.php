<?php

function rGet($zz)
{
    return trim(htmlentities($_GET[$zz]));
}

function rPost($zz)
{
    return trim(htmlentities($_POST[$zz]));
}

function rRec($zz)
{
    return trim(htmlentities($zz));
}

function ckey($s)
{
    return md5(uniqid(mt_rand().md5($s), true));
}

function create_guid($namespace = '')
{
    static $guid = '';
    $uid = uniqid('', true);
    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    //$data .= $_SERVER['LOCAL_ADDR'];
    //$data .= $_SERVER['LOCAL_PORT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
    $hash = strtoupper(hash('ripemd128', $uid.$guid.md5($data)));
    $guid =
    substr($hash, 0, 8).
    '-'.
    substr($hash, 8, 4).
    '-'.
    substr($hash, 12, 4).
    '-'.
    substr($hash, 16, 4).
    '-'.
    substr($hash, 20, 12);

    return  $guid;
}

function generate_code($length = 4)
{
    return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
}

function filter_tnull($z, $n)
{
    $datas = $z;
    foreach ($datas as &$i) {
        unset($i[$n]);
    }
    unset($i);

    return $datas;
}

function filter_nullt($z)
{
    $datas = $z;
    foreach ($datas as &$i) {
        $i = array_filter($i, function ($z) {
            if (null == $z) {
                return false;
            }

            return true;
        });
    }
    unset($i);

    return $datas;
}

function filter_repeat($z, $n)
{
    $datas_name = array();
    $datas = array();
    foreach ($z as $d) {
        if (!in_array($d[$n], $datas_name)) {
            array_push($datas, $d);
            array_push($datas_name, $d[$n]);
        }
    }

    return $datas;
}

function filter_null($z)
{
    $datas = $z;
    foreach ($datas as &$i) {
        $i = array_filter($i, function (&$z) {
            if (null == $z) {
                $z = '';
            }

            return true;
        });
    }
    unset($i);

    return $datas;
}

function isimage($name)
{
    $type = strtolower(substr($name, -4));
    if ('.jpg' != $type && '.png' != $type && '.gif' != $type) {
        return false;
    }

    return true;
}

function isvedio($name)
{
    $type = strtolower(substr($name, -4));
    if ('.mp4' != $type && '.flv' != $type && '.avi' != $type && '.3gp' != $type) {
        return false;
    }

    return true;
}

function tgl(&$z, &$z2, $key)
{
    $z[$key] = $z2[$key];
    unset($z);
    unset($z2[$key]);
    unset($z2);
}

function secToTime($times)
{
    $result = '00:00:00';
    if ($times > 0) {
        $hour = floor($times / 3600);
        $minute = floor(($times - 3600 * $hour) / 60);
        $second = floor((($times - 3600 * $hour) - 60 * $minute) % 60);
        $result = $hour.':'.$minute.':'.$second;
    }

    return $result;
}

function echohtml($path, $ref = false)
{
    header('Content-Type: text/html;charset=utf-8');
    echo file_get_contents($path);
}

function random($len)
{
    $srcstr = '1a2s3d4f5g6hj8k9qwertyupzxcvbnm';
    mt_srand();
    $strs = '';
    for ($i = 0; $i < $len; ++$i) {
        $strs .= $srcstr[mt_rand(0, 30)];
    }

    return $strs;
}

function search_all_files($dir, $search_str, &$search_files, $ypath)
{
    $temp_search_file_name = explode('//', $dir);
    $temp_search_file_name = $temp_search_file_name[count($temp_search_file_name) - 1];
    if (is_dir($dir)) {
        $arr = scandir($dir);
        foreach ($arr as $v) {
            $temp_search_file = array();
            if ('.' != $v && '..' != $v) {
                if (is_dir($dir.'//'.$v)) {
                    if (false !== strpos($v, $search_str)) {
                        $temp_search_file['name'] = $v.'/';
                        $temp_search_file['size'] = '-';
                        $temp_search_file['type'] = 0;
                        $temp_search_file['path'] = '/'.substr($dir, strlen($ypath)).'/';
                        $temp_search_file['name'] = str_replace('\\', '/', $temp_search_file['name']);
                        $temp_search_file['path'] = str_replace('\\', '/', $temp_search_file['path']);
                        if ('' == $temp_search_file['path']) {
                            $temp_search_file['path'] = '/';
                        }
                        repxg($temp_search_file['name']);
                        repxg($temp_search_file['path']);
                        array_push($search_files, $temp_search_file);
                    }
                    search_all_files($dir.'//'.$v, $search_str, $search_files, $ypath);
                } else {
                    if (false !== strpos($v, $search_str)) {
                        array_push($search_files, GetFileStat($dir.'//'.$v, $v, $ypath));
                    }
                }
            }
        }
    } else {
        if (false !== strpos($temp_search_file_name, $search_str)) {
            array_push($search_files, GetFileStat($dir, $temp_search_file_name, $ypath));
        }
    }
}

function GetFileStat($path, $name, $ypath)
{
    $temp_search_file = array();
    $temp_search_file['name'] = $name;
    $t_size = stat($path)['size'];
    if ($t_size >= 1073741824) {
        $t_size = (round($t_size / 1073741824 * 100) / 100).' G';
    } elseif ($t_size >= 1048576) {
        $t_size = (round($t_size / 1048576 * 100) / 100).' M';
    } elseif ($t_size >= 1024) {
        $t_size = (round($t_size / 1024 * 100) / 100).' K';
    } else {
        $t_size = $t_size.' b';
    }
    $temp_search_file['size'] = $t_size;
    $temp_search_file['type'] = 1;
    $temp_search_file['path'] = '/'.substr($path, strlen($ypath));
    $temp_search_file['path'] = substr($temp_search_file['path'], 0, strlen($temp_search_file['path']) - strlen($name));
    $temp_search_file['name'] = str_replace('\\', '/', $temp_search_file['name']);
    $temp_search_file['path'] = str_replace('\\', '/', $temp_search_file['path']);
    if ('' == $temp_search_file['path']) {
        $temp_search_file['path'] = '/';
    }
    repxg($temp_search_file['name']);
    repxg($temp_search_file['path']);

    return $temp_search_file;
}

function repxg(&$str)
{
    while (false !== strpos($str, '//')) {
        $str = str_replace('//', '/', $str);
    }
}
