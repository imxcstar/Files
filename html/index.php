<?php

require_once '../Config/Config.php';

$z = strtolower(rGet('z'));

if (isset($z[0]) && !strpos($z, '\\') && !strpos($z, '/')) {
    $z::r($di);
} else {
    echohtml('./index.html');
}
