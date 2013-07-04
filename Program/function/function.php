<?php
function login(){
	if(!$_SESSION['login']){
		header('Location:http://www.qttc.net');
	}
}
function returnLogin(){
	if($_SESSION['login']){
		return 1;
	}
	return 0;
}

// cid 转 名字
function cgId_to_bgName($cg_id){
	global $db;

	$result = $db->select(
		'category',
		array(
			'cg_id'=>$cg_id	
		)
	);

	return $result['cg_name'];

}

function date_to_dateName($date){
	return substr($date,0,4).'年'.month_format(substr($date,4)).'月';
}

function month_format($m){
	switch($m){
		case 1:
			return '一';	
			break;
		case 2:
			return '二';
			break;
		case 3:
			return '三';
			break;
		case 4:
			return '四';
			break;
		case 5:
			return '五';
			break;
		case 6:
			return '六';
			break;
		case 7:
			return '七';
			break;
		case 8:
			return '八';
			break;
		case 9:
			return '九';
			break;
		case 10:
			return '十';
			break;
		case 11:
			return '十一';
			break;
		case 12:
			return '十二';
			break;
	}
}
function oLimit($page){
	if($page<=1){
		return 11;	
	}else{
		return (($page-1)*10).','.'11';	
	}
}
function Limit($max,$page){
	if($page<=1){
		return $max;	
	}else{
		return ($page-1)*$max.','.$max;	
	}
}
function cg_id($cg_id){
	if($cg_id){
		return ' WHERE cg_id=:cg_id';	
	}
	return null;
}
function dt_ym($date){
	if($date){
		return ' WHERE DATE_FORMAT(b_date,\'%Y%m\')=:ym';	
	}
	return null;
}
function loop($list){
	$str = '';
	for($i=0,$k=count($list);$i<$k;$i++){

		$url = 'http://www.qttc.net/'.substr($list[$i]['b_date'],0,4).substr($list[$i]['b_date'],5,2).$list[$i]['b_id'].'.html';

		$str.= '<li id="'.$list[$i]['b_id'].'">';	
			$str.= '<div class="date">';
				$str .= '<div class="up">'.substr($list[$i]['b_date'],0,7).'</div>';
				$str .= '<div class="down">'.isDay($list[$i]['b_date']).'</div>';
			$str .= '</div>';

			$str.= '<div class="title">';
				$str.= '<a href="'.$url.'" title="'.$list[$i]['b_title'].'" target="_blank">'.$list[$i]['b_title'].'</a>';
			$str.= '</div>';

			$str.= '<div class="info">';
				$str .= '<span class="type"><i></i> [ <a href="http://www.qttc.net/category/'.$list[$i]['cg_id'].'">'.cgId_to_bgName($list[$i]['cg_id']).'</a> ] </span>';
				$str .= '<span class="comments"><i></i> [ <a href="'.$url.'#comment">'.$list[$i]['b_comments'].'</a> ]</span>';
			$str .= '</div>';

			$str.= '<div class="intro">'.$list[$i]['b_intro'].'[...]</div>';

			$str.= '<div class="tag">'.tag_to_a($list[$i]['b_tag']).'</div>';
		$str.= '</li>';
	}

	return $str;
}

function tag_to_a($tag){
	$arr = explode(',',$tag);
	$str = '';
	for($i=0,$k=count($arr);$i<$k;$i++){
		$str .= '<a href="http://www.qttc.net/tag/'.$arr[$i].'">'.$arr[$i].'</a>';	
	}
	return $str;
}
function spliceSubstr($str,$type){
	if($type==1){
		if(mb_strlen($str,'utf-8')>35){
			return mb_substr($str,0,35,'utf-8').'...';
		}
		return $str;
	}else if($type==3){
		if(mb_strlen($str,'utf-8')>16){
			return mb_substr($str,0,15,'utf-8').'...';
		}
		return $str;			
	}else{
		return mb_substr(strip_tags($str),0,70,'utf-8').'[...]';
	}
}
function topSub($title){
	if(mb_strlen($title,'utf-8')>19){
		return mb_substr($title,0,17,'utf-8').'...';
	}
	return $title;
}
function page($total,$type,$page){
	global $cg_id,$date;
	$pageTotal=ceil($total/10);
	if($type==2){
		$url = 'category/'.$cg_id.'/page';
	}elseif($type==3){	
		$url = 'date/'.$date.'/page';
	}else{
		$url = 'page';	
	}
	$str = '';
	for($i=1;$i<=$pageTotal;$i++){
		if($i==$page){
			$str .= '<a href="javascript:void(0);" class="light">'.$i.'</a>';	
		}else{
			$str .= '<a href="http://www.qttc.net/'.$url.'/'.$i.'">'.$i.'</a>';	
		}
	}
	return $str;
}
function categoryHtml($list){
	for($i=0,$k=count($list);$i<$k;$i++){
		$str .= '<li><span class="fix"></span><a href="http://www.qttc.net/category/'.$list[$i]['cg_id'].'">'.$list[$i]['cg_name'].' ('.$list[$i]['cg_count'].') </a></li>';	
	}
	return $str;
}
function dateHtml($list){
	for($i=0,$k=count($list);$i<$k;$i++){
		$str .= '<li><span class="fix"></span><a href="http://www.qttc.net/date/'.$list[$i]['ym'].'">'.substr($list[$i]['ym'],0,4).'年'.substr($list[$i]['ym'],-2).'月 ('.$list[$i]['total'].') </a></li>';
	}	
	return $str;
}
function post_hot($list){
	$str = '';	
	for($i=0,$k=count($list);$i<$k;$i++){
		$str .= '<li><a href="http://www.qttc.net/'.$list[$i]['b_id'].'.html" title="'.$list[$i]['b_title'].'" target="_blank">'.spliceSubstr($list[$i]['b_title'],3).' ('.$list[$i]['b_views'].') </a></li>';	
	}
	return $str;
}
function comment_hot($list){
	$str = '';
	for($i=0,$k=count($list);$i<$k;$i++){
		$str .= '<li>';	
		$str .= '<span>'.$list[$i]['c_content'].'</span>';
		$str .= '<span>【 '.substr($list[$i]['c_date'],0,16).' 】</span></li>';
	}
	return $str;
}
function reTime($date){
	$ux = time()-strtotime($date);
	if($ux<60)
		return $ux.' seconds ago';	
	if($ux<3600)
		return floor($ux/60).' minutes ago';	
	if($ux<86400)
		return floor($ux/3600).' hours ago';
	if($ux<2592000)
		return floor($ux/86400).' days ago';
	if($ux<31104000)
		return floor($ux/2592000).' months ago';
	return floor($ux/31104000).' years ago';
}
function utf8Substr($str,$len){
   	return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,0}'.
                       '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
                       '$1',$str);
}

function slength($str){   
 	$len=strlen($str);   
 	$i=0; $j=0;  
 	while($i<$len){   
      		if(preg_match("/^[".chr(0xa1)."-".chr(0xf9)."]+$/",$str[$i])){   
         		$i+=2;   
        	}else{   
         		$i+=1;   
		}   
    		$j++;
 	}   
	 return $j;   
}  

function csubstr($str, $length, $start=0, $charset="utf-8", $suffix=true){ 
	if(function_exists("mb_substr")){ 
		if(mb_strlen($str, $charset) <= $length) return $str; 
		$slice = mb_substr($str, $start, $length, $charset); 
	}else{ 
		$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/"; 
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/"; 
		$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/"; 
		$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/"; 
		preg_match_all($re[$charset], $str, $match); 
		if(count($match[0]) <= $length) return $str; 
			$slice = join("",array_slice($match[0], $start, $length)); 
	} 
	if($suffix) return $slice."..."; 
	return $slice; 
}

function api_get($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	$response  = curl_exec($ch);
	curl_close($ch);
	return $response;	
}
function get_title($title,$cg_name){
	if($title)
		return $title.' - 琼台博客';
	if($cg_name)
		return $cg_name.' - 琼台博客';	
	return '琼台博客 - 个人WEB技术研发博客';
}
function get_keywords($keywords){
	if($keywords)
		return $keywords.',琼台博客';
	return '琼台博客,PHP博客,WEB技术';
}
function cTitle($b_id,$title,$b_date){
	if($b_id==9999991){
		return  '<a href="http://www.qttc.net/about.html" target="_blank">关于老屋</a>';	
	}
	if($b_id==9999992){
		return '<a href="http://www.qttc.net/audience.html" target="_blank">围观者</a>';		
	}
	if($b_id==9999993){
		return '<a href="http://www.qttc.net/top.html" target="_blank">排行榜</a>';		
	}
	return '<a href="http://www.qttc.net/'.substr($b_date,0,4).substr($b_date,5,2).$b_id.'.html" target="_blank">'.$title.'</a>';
}
function cTitle2($b_id,$date){
	if($b_id==9999991){
		return 'about';
	}
	if($b_id==9999992){
		return 'audience';	
	}
	if($b_id==9999993){
		return 'top';	
	}
	return $date.$b_id;
}
function prev_next_post($arr){
	if($arr['b_id']){
		return '<a href="http://www.qttc.net/'.substr($arr['b_date'],0,4).substr($arr['b_date'],5,2).$arr['b_id'].'.html">'.$arr['b_title'].'</a>';	
	}
	return '木有了';
}

function encode($str,$encode='utf-8'){
	$str = base64_encode($str);
	$str = "=?".$encode."?B?".$str."?=";
	return $str;
}
 
function sendMail($to,$title,$str){
	$subject = encode($title);
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n"; 
	$headers .= "From: ".encode('琼台博客')." <mail@lizhong.me>\r\n";
	$status = @mail($to, $subject, $str, $headers); 
	return $status; 
}
function audience($list){
	$str = '';
	for($i=0,$k=count($list);$i<$k;$i++){
		$str .= '<li><a href="http://www.qttc.net/user/'.$list[$i]['c_md5'].'" target="_blank"><img data-original="http://www.gravatar.com/avatar/'.$list[$i]['c_md5'].'.jpg?s=60$d=&r=G" src="http://www.qttc.net/images/loading.gif" /></a>';	
		$str .= '<div><a href="http://www.qttc.net/user/'.$list[$i]['c_md5'].'" target="_blank">'.$list[$i]['c_user'].'</a>('.$list[$i]['num'].')</div></li>';
	}
	return $str;
}


function w_tag($list){
	$fp = fopen('/data0/htdocs/www.qttc.net/www/hottag.txt','w');
	for($i=0,$k=count($list);$i<$k;$i++){
		$str .= '<a style="font-size:'.rand(15,25).'px;color:#'.getColor().';" href="http://www.qttc.net/tag/'.$list[$i]['t_name'].'">'.$list[$i]['t_name'].'</a>';	
	}
	fwrite($fp,$str);
	fclose($fp);
}

function getColor(){
	$arr = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
	for($i=0;$i<6;$i++){
		$color .= $arr[rand(0,15)];	
	}
	return $color;
}
function trimTag($tag) {
      	if(empty($tag)){return false;}
	return preg_replace('/(\.|\*|#|,|\'|`|~|@|\/|=| |!|\$|\^|&|\(|\)|\+|\\\)/','',$tag);
}
function up_down_tag($total){
	global $page,$tag,$off;
	if(($total-10)>$off){
		$str .= '<a href="http://www.qttc.net/tag/'.$tag.'/page/'.($page+1).'"><<</a>';	
	}

	if($page>1){
		$str .= '<a href="http://www.qttc.net/tag/'.$tag.'/page/'.($page-1).'">>></a>';
	}
	return $str;
}
function up_down_search($total){
	global $page,$search,$off;
	if(($total-10)>$off){
		$str .= '<a href="http://www.qttc.net/search/'.$search.'/page/'.($page+1).'"><<</a>';	
	}

	if($page>1){
		$str .= '<a href="http://www.qttc.net/search/'.$search.'/page/'.($page-1).'">>></a>';
	}
	return $str;
}
function createRandID($m){
	$arr = array();
	while(count($arr)<=10){
		$a=rand(6,$m);
		if(!in_array($a,$arr)){
			$arr[] = $a;	
		}
	}
	return implode($arr,',');
}
function xgbw($list){
	$str = '';
	for($i=0,$k=count($list);$i<$k;$i++){
		$str .= '<li><span class="fix"></span><a href="http://www.qttc.net/'.substr($list[$i]['b_date'],0,4).substr($list[$i]['b_date'],5,2).$list[$i]['b_id'].'.html" target="_blank">'.$list[$i]['b_title'].'</a></li>';
	}
	return $str;
}
function view_hot($list){
	$str = '';	
	for($i=0,$k=count($list);$i<$k;$i++){
		$str .= '<li><span class="fix"></span><a href="http://www.qttc.net/'.substr($list[$i]['b_date'],0,4).substr($list[$i]['b_date'],5,2).$list[$i]['b_id'].'.html" target="_blank">'.$list[$i]['b_title'].' ('.$list[$i]['b_views'].')</a></li>';	
	}
	return $str;
}
function isDay($date){
	if(date('Ymd',@strtotime($date))==date('Ymd')){
		return '今';	
	}
	return substr($date,8,2);
}
function tuijian($b_id,$b_tj){
	if($b_tj){
		return '<button onclick="tuijian('.$b_id.',0);">取消推荐</button>';
	}else{
		return '<button onclick="tuijian('.$b_id.',1);">推荐</button>';	
	}
}
function ping_tj($list){
	$str = '';	
	for($i=0,$k=count($list);$i<$k;$i++){
		$str .= '<li><span class="fix"></span><a href="http://www.qttc.net/'.substr($list[$i]['b_date'],0,4).substr($list[$i]['b_date'],5,2).$list[$i]['b_id'].'.html" title="'.$list[$i]['b_title'].'" target="_blank">'.spliceSubstr($list[$i]['b_title'],3).'</a></li>';	
	}
	return $str;
}

function ping_tj2($list){
	$str = '';	
	for($i=0,$k=count($list);$i<$k;$i++){
		if($i>0)
			$str .= '<div style="margin-top:15px;">';
		else
			$str .= '<div style="margin-top:10px;">';

		$str .= '<p><a href="http://www.qttc.net/'.substr($list[$i]['b_date'],0,4).substr($list[$i]['b_date'],5,2).$list[$i]['b_id'].'.html" title="'.$list[$i]['b_title'].'" target="_blank">'.spliceSubstr($list[$i]['b_title'],3).'</a></p><p><a style="color:#666;text-decoration:none;line-height:16px;" href="http://www.qttc.net/'.$list[$i]['b_id'].'.html" target="_blank">'.spliceSubstr($list[$i]['b_intro'],1).'</a></p><p><a style="font-family:\'Arial\';font-size:10px;color:#270;text-decoration:none;" href="http://www.qttc.net/'.$list[$i]['b_id'].'.html" target="_blank">www.qttc.net/'.$list[$i]['b_id'].'.html</a></p></div>';	
	}
	return $str;
}
function ping_zc($list){
	$str = '';	
	for($i=0,$k=count($list);$i<$k;$i++){
		$str .= '<li><a href="http://www.qttc.net/'.substr($list[$i]['b_date'],0,4).substr($list[$i]['b_date'],5,2).$list[$i]['b_id'].'.html" title="'.$list[$i]['b_title'].'" target="_blank">'.spliceSubstr($list[$i]['b_title'],3).'('.$list[$i]['b_zc'].')</a></li>';	
	}
	return $str;
}
function urlShort($url){
    $url= crc32($url);
    $result= sprintf("%u", $url);
    $sUrl= '';
    while($result>0){
        $s= $result%62;
        if($s>35){
            $s= chr($s+61);
        } elseif($s>9 && $s<=35){
            $s= chr($s+ 55);
        }
        $sUrl.= $s;
        $result= floor($result/62);
    }
    return $sUrl;
}
function c_email($email){
	$reg='/^([a-zA-Z0-9]{1,40})(([\_\-\.])?([a-zA-Z0-9]{1,40}))*@([a-zA-Z0-9]{1,20})(([\-\_])?([a-zA-Z0-9]{1,20}))*(\.[a-z]{2,4}){1,2}$/';
	if(preg_match($reg,$email))
		return true;	
	return false;
}
function c_url($url){
	if($url=='') 
		return true;
	$reg='/^(http:\/\/)?(www\.)?([a-zA-Z0-9]{1,20})(([\_\-])?([a-zA-Z0-9]{1,20}))*(\.[a-z]{2,4}){1,2}([\/])?$/';
	if(preg_match($reg,$url))
		return true;	
	return false;
}
function GetIP(){ 
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
		$ip = getenv("HTTP_CLIENT_IP"); 
	else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
		$ip = getenv("HTTP_X_FORWARDED_FOR"); 
	else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
		$ip = getenv("REMOTE_ADDR"); 
	else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
		$ip = $_SERVER['REMOTE_ADDR']; 
	else
		$ip = 0; 
	return $ip; 
}
function CheckIP($ip){
	global $db;
	//if($ip=='123.124.163.254') return false;
	if($ip===0) return true;
	/*
	$data = $db->getIPnewDate($ip);
	if($data && time()-strtotime($data['c_date'])<40){
		return false;	
	}
	*/
	return true;
}

function cache(){
	$allow_file= array(
		'api.php',	
		'go.php',
		'error.php',
		'header.php',
		'footer_start.php',
		'footer_end.php',
		'right.php',
		'rss.php'
	);

	$file = substr($_SERVER["PHP_SELF"],1);

	if(in_array($file,$allow_file)){
		return array();	
	}

	global $mem;	
	$url = 'http://'.$_SERVER["SERVER_NAME"];
	$url .= $_SERVER["REQUEST_URI"][strlen($_SERVER["REQUEST_URI"])-1]=='/' ? substr($_SERVER["REQUEST_URI"],0,-1) : $_SERVER["REQUEST_URI"];

	$key = md5($url);
	$result = $mem->get($key);

	if(empty($result)){
		$mem->set($key,array('cache_sussc'=>false),0,MC_TIME);
		$html = file_get_contents($url);
		$mem->delete($key);
		$mem->set($key,array('cache_sussc'=>true,'html'=>$html),0,MC_TIME);
	}

	return $result;		
}

function cache_onec($url){
	if(!MC_CACHE){
		return false;	
	}

	global $mem;

	if(!$mem){
		$mem = new Memcache;
		$mem->connect(MC_HOST,MC_PORT);
	}

	$url = $url[strlen($url)-1]=='/' ? substr($url,0,-1) : $url;

	$key = md5($url);
	$mem->delete($key);

	$mem->set($key,array('cache_sussc'=>false),0,MC_TIME);
	$html = file_get_contents($url);
	$mem->delete($key);
	$mem->set($key,array('cache_sussc'=>true,'html'=>$html),0,MC_TIME);

	return false;
}

function cache_blog_once($b_id){
	if(!MC_CACHE){
		return false;	
	}

	global $db;
	$post = $db->select_blog($b_id);
	
	$url = 'http://www.qttc.net/'.date('Ym',strtotime($post['b_date'])).$post['b_id'].'.html';

	return cache_onec($url);
}
