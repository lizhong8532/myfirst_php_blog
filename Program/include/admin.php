<?php
session_start();
require_once('/data0/htdocs/www.qttc.net/class/sql.class.php');
require_once('/data0/htdocs/www.qttc.net/function/function.php');
define('PASSWORD',md5('guofei8532++'));

login();

// 开启mc缓存
define('MC_CACHE',true);

// MC端口
define('MC_PORT',12000);

// MC HOST
define('MC_HOST','127.0.0.1');

// MC 缓存时间
define('MC_TIME',60*10);

$mem = new Memcache;
$mem->connect(MC_HOST,MC_PORT);

$db = new sql();
