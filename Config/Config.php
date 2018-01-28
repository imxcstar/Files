<?php

require_once '../Config/ConstantDefinition.php';
require_once '../Config/AutoLoading.php';
require_once '../Modular/Di.php';
require_once '../Modular/Mymod.php';
require_once '../Modular/Myjson.php';

header('Content-Type: application/json;charset=utf-8');
ini_set('date.timezone', 'Asia/Shanghai');

spl_autoload_register('AutoLoading::load');

$di = null;
