<?php
$arr = array(
	'80主义',
	'原创WEB技术博客',
	'疯狂代码',
	'一直在围观，却从未参与',
	'严重鄙视 IE6、IE7、IE8，小小斜视IE9'
);
echo $arr[rand(0,count($arr)-1)];
