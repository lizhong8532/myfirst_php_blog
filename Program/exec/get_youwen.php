<?php

function curl_get($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$response  = curl_exec($ch);
	curl_close($ch);
	return $response;
}


function qianxingzhe($html){

	$html = htmlspecialchars_decode($html);
	preg_match_all("/\<h1\s*class\=.*?\>\<a\s*href\=\"(http\:\/\/www\.qianxingzhem\.com\/post-\d{4}\.html)\"\>(.*?)\<\/a\>\<\/h1\>/i",$html,$parray);
	preg_match_all("/datetime\=\"(\d{4}-\d{2}-\d{2})\"/i",$html,$tarray);

	$html = '';

	$end = count($parray[1]) <= 10 ? count($parray[1]) : 10;

	for($i=0;$i<$end;$i++){
		$html .= '<li><a href="'.$parray[1][$i].'" target="_blank">'.$parray[2][$i].'</a><span>潜行者M '.$tarray[1][$i].'</span></li>';
	}

	return $html;	
}


// 请求资源数组
$list = array(
	'http://www.qianxingzhem.com' => 'qianxingzhe'
);


$str = '';

foreach($list as $k=>$v){
	$html = curl_get($k);
	eval('$str .= '.$v.'("'.htmlspecialchars($html).'");');
}

$fp = fopen('/data0/htdocs/www.qttc.net/www/youwen.txt','w');
fwrite($fp,$str);
fclose($fp);
