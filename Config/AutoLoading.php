<?php

class AutoLoading
{
    public static function load($className)
    {
        $file = '../php/'.$className.'.php';
        if (is_file($file)) {
            require $file;
        } else {
            $path = str_replace('\\', DIRECTORY_SEPARATOR, $className);
            $file = '../Modular/'.$path.'.php';
            if (is_file($file)) {
                require_once $file;
            } else {
                $mjson = new Myjson();
                $mjson->add('code', -88);
                $mjson->add('msg', '错误');
                $mjson->add('file', $file);
                $mjson->techo();
            }
        }
    }
}
