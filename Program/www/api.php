<?php
require_once('../include/public.php');
switch($_GET['action']){
	case 'weibo':
		$url = 'http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=400&fansRow=1&ptype=1&speed=0&skin=2&isTitle=0&noborder=1&isWeibo=1&isFans=0&uid=2621037111&verifier=98954fb1&dpc=1';
		$data = api_get($url);
		preg_match('/<p class="weiboShow_mainFeed_listContent_txt">(.*?)<\/p>/i',$data,$content);
		preg_match('/<span class="weiboShow_mainFeed_listContent_actionTime"><a href="(.*?)" target="_blank">(.*?)<\/a><\/span>/i',$data,$time);
		echo json_encode(array('content'=>$content[1],'time'=>$time[2]));
		break;
	case 'subComment':
		$b_id = $_POST['b_id'];
		$b_date = $_POST['b_date'];
		$user = trimTag(htmlspecialchars(urldecode(trim($_POST['user']))));
		$email = htmlspecialchars(urldecode(trim($_POST['email'])));
		$url  =  htmlspecialchars(trim(str_replace('http://','',strtolower(urldecode(trim($_POST['url'])))),'/'));
		$comment =  htmlspecialchars(urldecode(trim($_POST['comment'])));
		$allow = '/\[(smile|mrgreen|razz|lol|redface|biggrin|sad|surprised|wink|neutral|cool|arrow|evil|cry|eek|confused|exclaim|rolleyes|question|mad|idea|twisted)\]/';
		$comment = preg_replace($allow,'<img src=\'http://www.qttc.net/images/ico/icon_$1.gif\' />',$comment);
		$parent = $_POST['c_parent'];
		$c_md5  = md5($email);
		$ip = GetIP();
		if($user=='' || $email=='' || $comment=='' ){
			$array['error'] = 2;
			$array['msg'] = '要填写东东后才能提交，木要随便乱点哦！';
		}else if(strlen($user)>30){
			$array['error'] = 2;
			$array['msg'] = '名称长度过长！';		
		}else if(strlen($email)>50){
			$array['error'] = 2;
			$array['msg'] = '邮箱长度过长！';
		}else if(strlen($url)>30){
			$array['error'] = 2;
			$array['msg'] = '网址长度过长！';
		}else if(strlen($comment)>600){
			$array['error'] = 2;
			$array['msg'] = '内容长度过长！';	
		}else if(!c_email($email)){
			$array['error'] = 2;
			$array['msg'] = '邮箱格式错误！';	
		}else if(!c_url($url)){
			$array['error'] = 2;
			$array['msg'] = '网址格式错误！';	
		}else if(!CheckIP($ip)){
			$array['error'] = 2;
			$array['msg'] = '您说话速度貌似很快哦！喘口气再继续。';			
		}else{
			$result = $db->insert_comment($user,$email,$comment,$b_id,$url,$parent,$c_md5,$ip);
			if($result){
				$array['error'] = 0;			
				$array['c_md5']  = $c_md5;
				$array['date'] = date('Y-m-d H:i:s');
				if($email!='mail@lizhong.me'){
					sendMail('mail@lizhong.me','['.$user.']给您留言位于('.$b_id.')','<div style="border:1px solid #ccc;padding:10px;">'.$comment.'</div>请<a href="http://www.qttc.net/'.cTitle2($b_id,$b_date).'.html" target="_blank">点击这里</a>查看完整内容</p>');
					//w_new_comment();
				}	
				if($parent){
					$data=$db->select_comments_one($parent);
					if($data['c_email'] != 'mail@lizhong.me' || $data['c_email'] != $email){
						$str = '<p>'.$data['c_user'].'，您好！</p><p>您在<a href="http://www.qttc.net" target="_blank">琼台博客</a>中';
						$str .= '的留言有新的回复信息</p>';
						$str .= '<p style="margin:30px;">您的留言内容：</p>';
						$str .= '<p style="background:#ffffbf;border:1px solid #999;margin:30px;width:500px;padding:20px;">'.$data['c_content'].'</p>';
						$str .= '<p style="margin:30px;">[';
						$str .= $email=='mail@lizhong.me' ? '博主' : $user;
						$str .= ']在您的留言中回复：</p>';
						$str .= '<p style="background:#ffffbf;border:1px solid #999;margin:30px;width:500px;padding:20px;">'.$comment.'</p>';
						$str .= '<p style="margin-top:30px;">请<a href="http://www.qttc.net/'.cTitle2($b_id,$b_date).'.html" target="_blank">点击这里</a>查看完整内容</p>';
						$str .= '<p style="color:red;margin-top:30px;">琼台博客</p>';
						sendMail($data['c_email'],'您在[琼台博客]的留言有了新回复',$str);
					}
				}

				$cache_url = 'http://www.qttc.net/'.cTitle2($b_id,$b_date).'.html';
				cache_onec($cache_url);

			}else{
				$array['error'] = 2;
				$array['msg'] = '系统繁忙哦！';	
			}
			setcookie('c_user', $user, time()+864000); 
			setcookie('c_email', $email, time()+864000); 
			setcookie('c_url', $url, time()+864000); 
		}
		echo json_encode($array);
		break;
	case 'getComment':
		$b_id = $_GET['b_id'];
		$list = $db->select_comment_list($b_id);
		echo json_encode($list);
		break;
	case 'zhichi':
		$b_id = $_POST['b_id'];
		if(is_numeric($b_id) && $db->zc($b_id)){
			cache_blog_once($b_id);
		}
		break;
	case 'addViews':
		if(is_numeric($_POST['b_id'])){
			$db->post_views_add($_POST['b_id']);
		}
		break;
	case 'xgbw':
		$data = xgbw($db->xgbw($_GET['cg_id']));
		if($data){
			echo json_encode(array('error'=>0,'data'=>$data));
		}else{
			echo json_encode(array('error'=>1));	
		}
		break;
	case 'rand':
		$data = view_hot($db->select_blog_rand());
		if($data){
			echo json_encode(array('error'=>0,'data'=>$data));
		}else{
			echo json_encode(array('error'=>1));	
		}
		break;
	case 'getlist':
		$b_id = trim($_GET['b_id']);
		if(preg_match('/^([0-9]{1,10})(\,[0-9]{1,10}){0,9}$/',$b_id)){
			$list = $db->select_blog_com_vie($b_id);
		}	
		echo json_encode($list);
		break;

	/** 合作API **/
	case 'open_getBlogList':
		// 返回
		$return = array();

		// 获取长度单位
		$limit = $_GET['limit'] <= 10 ? $_GET['limit'] : 10;
		$limit = $limit>=1 ? $limit : 1;

		// 获取 回掉参数
		$callback = trim($_GET['callback']);

		// 获取是否推荐
		$only_recommend = $_GET['only_recommend'];

		$result = $db->open_getBlogList($limit,$only_recommend);
		
		// 写地址
		foreach($result as &$v){
			$v['b_url'] = 'http://www.qttc.net/'.date('Ym',strtotime($v['b_date'])).$v['b_id'].'.html';	
		}


		$return = json_encode(array(
			'error'=>0,	
			'data' => $result
		));

		echo $callback ? $callback.'('.$return.')' : $return;
		break;
	
	case 'open_getBlogDetailed':

		// 获取 回掉参数
		$callback = trim($_GET['callback']);	

		// 博文ID
		$b_id = intval(trim($_GET['b_id']));
		if($b_id>=1){

			$result = $db->select(
				'blog',	
				array(
					'b_id'=>$b_id	
				),
				'b_title,b_intro,b_content,b_date,b_comments,b_views'
			);	

			if($result){
				$return = array(
					'error'=>0,	
					'data' => $result
				);

			}else{
				$return =  array(
					'error'=>2,	
					'msg' => '数据不存在'
				);	
			}

		}else{
			$return =  array(
				'error'=>1,	
				'msg' => '参数错误'
			);	
		}

		echo $callback ? $callback.'('.json_encode($return).')' : json_encode($return);

		break;

	default:
		echo json_encode(array('error'=>-1));
}
