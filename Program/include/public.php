<?php
// session开启
session_start();

// 全局路径
define('WEB_DIR','/data0/htdocs/www.qttc.net');

// 开启mc缓存
define('MC_CACHE',true);

// MC端口
define('MC_PORT',12000);

// MC HOST
define('MC_HOST','127.0.0.1');

// MC 缓存时间
define('MC_TIME',60*10);

// 签名定义
define('QIANMING',serialize(array(
	'这是一个程序猿的个人Web技术博客'
)));

$mem = new Memcache;
$mem->connect(MC_HOST,MC_PORT);

require_once(WEB_DIR.'/function/function.php');		// 包含方法文件

// 判断是否走缓存
if(MC_CACHE){
	$cache = cache();
	if($cache['cache_sussc']){
		exit($cache['html']);
	}
}

require_once(WEB_DIR.'/class/sql.class.php');		// 包含数据库操作类
$db = new sql();

// 签名随机
$qm_arr = unserialize(QIANMING);
$qm = $qm_arr[rand(0,count($qm_arr)-1)];


