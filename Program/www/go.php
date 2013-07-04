<?php
require_once('../include/public.php');

$url = $_GET['url'] =='' ? 'www.qttc.net' : trim($_GET['url']);

if($url=='yun'){
	header('Location:http://www.aliyun.com/cps/promotion_check?promotion_code=uUddqfuxAdDu8NSMV7vzyAg5Yt4OgcczFlfA5S6zk0wEfvC%2FXWmbrqGdDPEqO4i3OHBQX6NsffZ8y4Syjoqjpykzcwad0Ppjebx6oYP%2FpVGSCiROESioyBwD%2FXWs7Lk5v9B5JBZl6qlhE505HVnLd5dLIAZ4%2Bi2hXmoRUASWZRG7APMJQ1qWIg%3D%3D');	
	exit();
}

if($url=='vps'){
	header('Location:http://www.linode.com/?r=3b6cc5008a0ec6bb5d9cad3fe2f79b305cc1e528');
	exit();
}

if($url=='aliyun'){
	header('Location:http://www.aliyun.com/cps/rebate?from_uid=1RP9GK6JFNZ/3UlI655btYiZP4F5NSQh');
	exit();
}

if(strlen($url)==5 || strlen($url)==6){
	$arr = $db->get_url($url);
}else{
	$arr = array();	
}

if($arr['url']){
	header('Location:http://'.$arr['url']);
}else{
	header('Location:http://'.$url);
}
