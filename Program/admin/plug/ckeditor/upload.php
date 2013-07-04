<?php 
$y = date('Y');
$path = '/data0/htdocs/www.qttc.net/www/upload/'.$y;
if(!is_dir($path)){
	mkdir($path,0777);
}
$config=array(); 
$config['type']=array("img"); 
$config['img']=array("jpg","bmp","gif","png"); 
$config['img_size']=500; 
$config['message']="Upload successful"; 
$config['name']=time().rand(1000,9999);
$config['img_dir'] = "/upload";
$config['site_url']="http://www.qttc.net/upload/".$y.'/'; 
uploadfile(); 
function uploadfile() { 
	global $config,$y; 
	if(empty($_GET['CKEditorFuncNum'])) 
		mkhtml(1,"","错误的功能调用请求"); 
	$fn=$_GET['CKEditorFuncNum']; 
	if(!in_array($_GET['type'],$config['type'])) 
		mkhtml(1,"","错误的文件调用请求"); 
	$type=$_GET['type']; 
	if(is_uploaded_file($_FILES['upload']['tmp_name'])) { 
		$filearr=pathinfo($_FILES['upload']['name']); 
		$filetype=strtolower($filearr["extension"]); 
		if(!in_array($filetype,$config[$type])) 
			mkhtml($fn,"","错误的文件类型！"); 
		if($_FILES['upload']['size']>$config[$type."_size"]*1024) 
			mkhtml($fn,"","上传的文件不能超过".$config[$type."_size"]."KB！"); 
		$file_abso = $config['name'].".".$filetype;
		$file_host='/data0/htdocs/www.qttc.net/www/upload/'.$y.'/'.$config['name'].".".$filetype; 
		if(move_uploaded_file($_FILES['upload']['tmp_name'],$file_host)){ 
			mkhtml($fn,$config['site_url'].$file_abso,$config['message']); 
		}else{ 
			mkhtml(	$_FILES['upload']['tmp_name']);
		} 
	} 
} 
//输出js调用 
function mkhtml($fn,$fileurl,$message) 
{ 
	$str='<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.$fileurl.'\', \''.$message.'\');</script>'; 
	exit($str); 
} 
