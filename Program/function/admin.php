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
function cgId_to_bgName($cg_id){
	switch($cg_id){
		case 1:
			return 'PHP';	
			break;
		case 2:
			return 'html/css';	
			break;
		case 3:
			return 'JavaScript';	
			break;
		case 4:
			return 'MySQL/SQL';	
			break;
		case 5:
			return 'WebServer';	
			break;
		case 6:
			return 'Linux/CentOS';	
			break;
		case 99:
			return 'Other';	
			break;
		default:
			return 'error!';
	}
}
function Limit($max,$page){
	if($page<=1){
		return $max;	
	}else{
		return ($page-1)*$max.' '.$max;	
	}
}
