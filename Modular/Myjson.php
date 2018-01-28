<?php

class Myjson
{
    private $zjson;

    /*添加json参数
        $key   键名
        $val   内容
    */
    public function add($key, $val)
    {
        $this->zjson[$key] = $val;
    }

    /*echo输出json
    */
    public function techo()
    {
        $this->zjson['version'] = '3.0.0';
        echo json_encode($this->zjson);
    }

    /*清空json
    */
    public function tclear()
    {
        unset($this->zjson);
    }

    /*json转字符串
    */
    public function tstring()
    {
        return json_encode($this->zjson);
    }
}
