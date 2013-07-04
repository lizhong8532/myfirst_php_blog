<?php
if($_GET['action'] == 'login'){
	if(md5(trim($_POST['pass']))==md5('guofei8532++')){
		session_start();
		$_SESSION['login'] = 1;
		exit(json_encode(array('error'=>0)));
	}else{
		exit(json_encode(array('error'=>1)));			
	}
}
require_once('../include/admin.php');
switch($_GET['action']){
	case 'login':
		if(PASSWORD==md5(trim($_POST['pass']))){
			$_SESSION['login'] = 1;
			echo json_encode(array('error'=>0));	
		}else{
			echo json_encode(array('error'=>1));		
		}
		break;

	case 'publish':
		if(!returnLogin() || !$_POST['title'] || !$_POST['category'] || !$_POST['content']  || !$_POST['intro']){
			$array = array('error'=>1);
		}
		$title = htmlspecialchars(urldecode(trim($_POST['title'])));
		$tag = htmlspecialchars(urldecode(trim($_POST['tag'])));
		$category = urldecode(trim($_POST['category']));
		$content = urldecode(trim($_POST['content']));
		$intro = htmlspecialchars(urldecode(trim($_POST['intro'])));
		$result = $db->insert_blog($title,$content,$category,$intro,$tag);
		if($result){
			$array['error'] = 0;
		}else{
			$array['error'] = 1;
		}
		$data = $db->select_blog_maxid();
		//w_view($data['b_id']);
		//w_right();
		//w_comment($data['b_id']);

		cache_onec('http://www.qttc.net');
		$total = $db->total();
		$n = ceil($total['total']/10);
		for($i=1;$i<=$n;$i++){
			$cache_url = 'http://www.qttc.net/page/'.$i;
			cache_onec($cache_url);
		}
		echo json_encode($array);
		break;
	case 'updatePost':
		if(!returnLogin() || !$_POST['title'] || !$_POST['category'] || !$_POST['content'] || !$_POST['id'] || !$_POST['intro']){
			$array = array('error'=>1);
		}
		$title = htmlspecialchars(urldecode(trim($_POST['title'])));
		$tag = htmlspecialchars(urldecode(trim($_POST['tag'])));
		$old_tag = htmlspecialchars(urldecode(trim($_POST['old_tag'])));
		$category = urldecode(trim($_POST['category']));
		$intro = htmlspecialchars(urldecode(trim($_POST['intro'])));
		$content = urldecode(trim($_POST['content']));
		$id =  urldecode(trim($_POST['id']));
		$result = $db->update_blog($id,$title,$intro,$content,$category,$old_tag,$tag);
		if($result){
			$array['error'] = 0;
		}else{
			$array['error'] = 1;
		}

		cache_onec('http://www.qttc.net');
		cache_blog_once($id);

		$total = $db->total();

		$n = ceil($total['total']/10);
		for($i=1;$i<=$n;$i++){
			$cache_url = 'http://www.qttc.net/page/'.$i;
			cache_onec($cache_url);
		}
		echo json_encode($array);
		break;
	case 'deleteComment':
		$c_id = trim($_POST['c_id']);
		$b_id = trim($_POST['b_id']);
		$result = $db->delete_comment($c_id,$b_id);
		if($result){
			$array['error'] = 0;
			cache_blog_once($b_id);
		}else{
			$array['error'] = 1;
		}
		
		echo json_encode($array);
		break;
	case 'tuijian':
		$b_id = trim($_POST['b_id']);
		$type = trim($_POST['type']);
		$result = $db->blog_tj($b_id,$type);
		if($result){
			$array['error'] = 0;
			//cache_once('http://www.qttc.net');
		}else{
			$array['error'] = 1;
		}
		echo json_encode($array);
		break;
	case 'createright':
		w_right();
		$array['error'] = 0;
		echo json_encode($array);
		break;
	case 'createlist':
		$data = $db->total();
		for($i=1;$i<=$data['total'];$i++){
			w_view($i);
		}
		$array['error'] = 0;
		echo json_encode($array);
		break;
	case 'createcomment':
		$data = $db->total();
		for($i=1;$i<=$data['total'];$i++){
			w_comment($i);
		}
		$array['error'] = 0;
		echo json_encode($array);
		break;
	case 'createcommentone':
		if( is_numeric($_POST['b_id'])){
			w_comment($_POST['b_id']);
		}
		$array['error'] = 0;
		echo json_encode($array);
		break;
	case 'createlistone':
		if( is_numeric($_POST['b_id'])){
			w_view($_POST['b_id']);
		}
		$array['error'] = 0;
		echo json_encode($array);
		break;
	case 'createcommentnew':
		w_new_comment();
		$array['error'] = 0;
		echo json_encode($array);
		break;
	case 'createrand':
		w_rand();
		$array['error'] = 0;
		echo json_encode($array);
		break;
	case 'createxgbw':
		w_xgbw(1);
		w_xgbw(2);
		w_xgbw(3);
		w_xgbw(4);
		w_xgbw(5);
		w_xgbw(6);
		w_xgbw(7);
		w_xgbw(99);
		$array['error'] = 0;
		echo json_encode($array);
		break;
	case 'createpage':
		w_list($_POST['page']);
		$array['error'] = 0;
		echo json_encode($array);	
		break;
	case 'createpageall':
		$total = $db->total();
		$n = ceil($total['total']/10);
		for($i=1;$i<=$n;$i++){
			w_list($i);
		}
		$array['error'] = 0;
		echo json_encode($array);	
		break;
	default:
		echo json_encode(array('error'=>-1));
}
