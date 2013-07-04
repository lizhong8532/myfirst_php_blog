<?php
require_once('db.class.php');
class sql extends db {
	public function __construct(){}
	public function insert_blog($b_title,$b_content,$cg_id,$b_intro,$b_tag=null){
		$sql = 'INSERT INTO blog(b_date,b_intro,b_content,b_title,cg_id,b_tag,b_tj) VALUE(NOW(),:b_intro,:b_content,:b_title,:cg_id,:b_tag,\'0\')';
		$result =  $this->execute($sql,array(':b_intro'=>$b_intro,':b_content'=>$b_content,':b_title'=>$b_title,':cg_id'=>$cg_id,':b_tag'=>$b_tag));	
		if($result){
			$this->category_add($cg_id);$ym = date('Ym');if($this->select_stt($ym)){$this->stt_add($ym);}else{$this->insert_stt($ym);}
			if($b_tag){$arr = explode(',',$b_tag);for($i=0,$k=count($arr);$i<$k;$i++){if($this->select_blogtag($arr[$i])){$this->add_blogtag($arr[$i]);}else{$this->insert_blogtag($arr[$i]);}}w_tag($this->select_blogtag_list());}
		}
		return $result;
	}
	public function select_blog_list($max=10,$page=1,$cg_id=null,$date=null){
		$sql = 'SELECT b_id,b_intro,b_date,cg_id,b_tag,b_views,b_comments,b_title FROM blog '.cg_id($cg_id).dt_ym($date).' ORDER BY b_id DESC LIMIT '.Limit($max,$page);	
		if($cg_id){return $this->fetchAll($sql,array(':cg_id'=>$cg_id));}elseif($date){return $this->fetchAll($sql,array(':ym'=>$date));}else{return $this->fetchAll($sql);}
	}
	public function select_blog_hot(){return $this->fetchAll('SELECT b_id,b_title,b_date,b_views FROM blog ORDER BY b_views DESC LIMIT 20');}
	public function select_blog($b_id){return $this->fetch('SELECT * FROM blog WHERE b_id=:b_id',array(':b_id'=>$b_id));}
	public function update_blog($b_id,$b_title,$b_intro,$b_content,$cg_id=6,$old_tag,$b_tag=null){
		$sql = 'UPDATE blog SET b_title=:b_title,b_intro=:b_intro,b_content=:b_content,b_tag=:b_tag,cg_id=:cg_id WHERE b_id=:b_id';
		$a = $this->execute($sql,array('b_id'=>$b_id,':b_intro'=>$b_intro,':b_content'=>$b_content,':b_title'=>$b_title,':cg_id'=>$cg_id,':b_tag'=>$b_tag));
		if($b_tag && $a){$arr = explode(',',$b_tag);for($i=0,$k=count($arr);$i<$k;$i++){if($this->select_blogtag($arr[$i])){$this->add_blogtag($arr[$i]);}else{$this->insert_blogtag($arr[$i]);}}}
		if($old_tag && $a){ $arr = explode(',',$old_tag);for($i=0,$k=count($arr);$i<$k;$i++){$this->red_blogtag($arr[$i]);} }
		w_tag($this->select_blogtag_list());
		return $a;
	}
	public function delete_blog($b_id,$cg_id){
		$result =  $this->execute('DELETE FROM blog WHERE b_id=:b_id AND cg_id=:cg_id',array(':b_id'=>$b_id,':cg_id'=>$cg_id));
		if($result){$this->category_del($cg_id);$this->stt_red(date('Ym'));$this->execute('UPDATE comments SET b_id=1 WHERE b_id=:b_id',array(':b_id'=>$b_id));}
		return $result;
	}
	public function select_category_list(){return $this->fetchAll('SELECT * FROM category');}
	public function insert_comment($c_user,$c_email,$c_content,$b_id,$c_url,$c_parent,$c_md5,$c_ip){
		$sUrl = urlShort($c_url);
		if(!$this->get_url($sUrl)){$this->put_url($sUrl,$c_url);}
		$sql = 'INSERT INTO comments(c_user,c_email,c_content,b_id,c_url,c_parent,c_date,c_md5,c_ip) VALUE(:c_user,:c_email,:c_content,:b_id,:c_url,:c_parent,NOW(),:c_md5,INET_ATON(:c_ip))';
		$result = $this->execute($sql,array(':c_user'=>$c_user,':c_email'=>$c_email,':c_content'=>$c_content,':b_id'=>$b_id,':c_url'=>$sUrl,':c_parent'=>$c_parent,':c_md5'=>$c_md5,':c_ip'=>$c_ip));
		if($result){$this->post_comments_add($b_id);}
		return $result;
	}
	public function delete_comment($c_id,$b_id){
		$result = $this->execute('DELETE FROM comments WHERE c_id=:c_id AND b_id=:b_id',array(':c_id'=>$c_id,':b_id'=>$b_id));
		if($result){$this->post_comments_del($b_id);}
		return $result;
	}
	public function select_comment_last(){return $this->fetchAll('SELECT c_user,c_content,c_date,c_md5 FROM comments WHERE c_email!=:c_email ORDER BY c_id DESC LIMIT 20',array(':c_email'=>'mail@lizhong.me'));}
	public function select_comment_list($b_id){return $this->fetchAll('SELECT * FROM comments WHERE b_id=:b_id ORDER BY c_id DESC',array(':b_id'=>$b_id));}
	public function select_comment_p($b_id){return $this->fetchAll('SELECT * FROM comments WHERE b_id=:b_id AND c_parent=0 ORDER BY c_id DESC',array(':b_id'=>$b_id));}
	public function select_comment_z($c_id){return $this->fetchAll('SELECT * FROM comments WHERE c_parent=:c_id ORDER BY c_id ASC',array(':c_id'=>$c_id));}
	public function post_views_add($b_id){return $this->execute('UPDATE blog SET b_views=b_views+'.rand(4,10).' WHERE b_id=:b_id',array(':b_id'=>$b_id));}
	public function select_comment_list_all(){return $this->fetchAll('SELECT a.*,INET_NTOA(a.c_ip) as ip,b.b_title,b.b_date FROM comments a LEFT JOIN blog b ON a.b_id=b.b_id ORDER BY c_id DESC');}
	public function select_post_list_all(){return $this->fetchAll('SELECT b_id,b_title,b_date,b_comments,b_views,cg_id,b_tag,b_zc,b_tj FROM blog ORDER BY b_id DESC');}
	public function category_add($cg_id){return $this->execute('UPDATE category SET cg_count=cg_count+1 WHERE cg_id=:cg_id',array(':cg_id'=>$cg_id));}
	public function category_del($cg_id){return $this->execute('UPDATE category SET cg_count=cg_count-1 WHERE cg_id=:cg_id',array(':cg_id'=>$cg_id));}
	public function post_comments_add($b_id){return $this->execute('UPDATE blog SET b_comments=b_comments+1 WHERE b_id=:b_id',array(':b_id'=>$b_id));}
	public function post_comments_del($b_id){return $this->execute('UPDATE blog SET b_comments=b_comments-1 WHERE b_id=:b_id',array(':b_id'=>$b_id));}
	public function post_prev($b_id){return $this->fetch('SELECT b_id,b_title,b_date FROM blog WHERE b_id>:b_id ORDER BY b_date ASC LIMIT 1',array(':b_id'=>$b_id));}
	public function post_next($b_id){return $this->fetch('SELECT b_id,b_title,b_date FROM blog WHERE b_id<:b_id ORDER BY b_date DESC LIMIT 1',array(':b_id'=>$b_id));}
	public function select_comments_one($c_id){return $this->fetch('SELECT c_user,c_email,c_content FROM comments WHERE c_id=:c_id',array(':c_id'=>$c_id));}
	public function select_stt($ym){return $this->fetch('SELECT * FROM stt WHERE ym=:ym',array(':ym'=>$ym));}
	public function insert_stt($ym){return $this->execute('INSERT INTO stt(ym,total) VALUE(:ym,1)',array(':ym'=>$ym));}
	public function stt_add($ym){return $this->execute('UPDATE stt SET total=total+1 WHERE ym=:ym',array(':ym'=>$ym));}
	public function stt_red($ym){return $this->execute('UPDATE stt SET total=total-1 WHERE ym=:ym',array(':ym'=>$ym));}
	public function select_stt_list(){return $this->fetchAll('SELECT * FROM stt ORDER BY ym DESC');}
	public function getAudience(){return $this->fetchAll('SELECT c_user,c_md5,COUNT(*) as num FROM  comments WHERE c_email!=\'mail@lizhong.me\' GROUP BY c_email ORDER BY num DESC');}
	public function select_blogtag($tag){return $this->fetch('SELECT * FROM blogtag WHERE t_name=:t_name',array(':t_name'=>$tag));}
	public function add_blogtag($tag){return $this->execute('UPDATE blogtag SET t_count=t_count+1,t_dt=NOW() WHERE t_name=:t_name',array(':t_name'=>$tag));}
	public function red_blogtag($tag){return $this->execute('UPDATE blogtag SET t_count=t_count-1 WHERE t_name=:t_name',array(':t_name'=>$tag));}
	public function insert_blogtag($tag){return $this->execute('INSERT INTO blogtag VALUE(:t_name,1,NOW())',array(':t_name'=>$tag));}
	public function select_blogtag_list(){return $this->fetchAll('SELECT t_name FROM blogtag WHERE t_count>=1 ORDER BY t_dt DESC,t_count DESC LIMIT 30');}
	public function select_blog_tag_list($tag,$page){return $this->fetchAll('SELECT b_id,b_intro,b_date,cg_id,b_tag,b_views,b_comments,b_title FROM blog WHERE b_tag LIKE :b_tag ORDER BY b_id DESC LIMIT '.oLimit($page),array(':b_tag'=>'%'.$tag.'%'));}
	public function select_blog_title_list($search,$page){return $this->fetchAll('SELECT b_id,b_intro,b_date,cg_id,b_tag,b_views,b_comments,b_title FROM blog WHERE b_title LIKE :b_title ORDER BY b_id DESC LIMIT '.oLimit($page),array(':b_title'=>'%'.$search.'%'));}
	public function blog_top(){return $this->fetchAll('SELECT b_id,b_title,b_date,b_comments FROM blog ORDER BY b_comments DESC LIMIT 10');}
	public function stt_top(){return $this->fetchAll('SELECT * FROM stt ORDER BY total DESC LIMIT 10');}
	public function blogtag_top(){return $this->fetchAll('SELECT t_name,t_count FROM blogtag ORDER BY t_count DESC LIMIT 10');}
	public function category_top(){return $this->fetchAll('SELECT * FROM category ORDER BY cg_count DESC LIMIT 10');}
	public function select_blog_rand(){return $this->fetchAll('SELECT b_id,b_date,b_title,b_views FROM blog ORDER BY RAND() DESC LIMIT 10');}
	public function get_rss(){return $this->fetchAll('SELECT b_id,b_date,b_title,b_intro,cg_id FROM blog ORDER BY b_id DESC LIMIT 10');}
	public function xgbw($cg_id){return $this->fetchAll('SELECT b_id,b_title,b_date FROM blog WHERE b_id!=:b_id AND cg_id=:cg_id ORDER BY RAND() DESC LIMIT 10',array(':cg_id'=>$cg_id));}
	public function zc($b_id){return $this->execute('UPDATE blog SET b_zc=b_zc+1 WHERE b_id=:b_id',array(':b_id'=>$b_id));}
	public function blog_tj($b_id,$b_tj){return $this->execute('UPDATE blog SET b_tj=:b_tj WHERE b_id=:b_id',array(':b_tj'=>$b_tj,':b_id'=>$b_id));	}
	public function select_blog_tj(){return $this->fetchAll('SELECT b_id,b_date,b_intro,b_title FROM blog WHERE b_tj=\'1\'');}
	public function select_blog_zc(){return $this->fetchAll('SELECT b_id,b_date,b_title,b_zc FROM blog ORDER BY b_zc DESC LIMIT 15');}
	public function select_comments_md5($md5){return $this->fetchAll('SELECT a.c_id,a.c_content,a.c_date,a.b_id,b_date,b.b_title FROM comments a LEFT JOIN blog b ON a.b_id=b.b_id WHERE c_md5=:c_md5 ORDER BY a.c_id DESC',array(':c_md5'=>$md5));}
	public function select_comments_url_user($md5){return $this->fetch('SELECT c_user,c_url FROM comments WHERE c_md5=:c_md5',array(':c_md5'=>$md5));}
	public function get_url($sUrl){return $this->fetch('SELECT url FROM url WHERE s=:s',array(':s'=>$sUrl));}
	public function put_url($s,$url){return $this->execute('INSERT INTO url VALUE(:s,:url)',array(':s'=>$s,':url'=>$url));}
	public function to_s_url($c_id,$s){echo $s.'  '.$c_id.'<br />';return $this->execute('UPDATE comments SET c_url=:c_url WHERE c_id=:c_id',array(':c_url'=>$s,':c_id'=>$c_id));}
	public function total(){return $this->fetch('SELECT count(*) as total FROM blog');}
	public function cg_total($cg_id){return $this->fetch('SELECT cg_count as total FROM category WHERE cg_id=:cg_id',array(':cg_id'=>$cg_id));}
	public function dt_total($ym){return $this->fetch('SELECT total FROM stt WHERE ym=:ym',array(':ym'=>$ym));}
	public function select_blog_maxid(){return $this->fetch('SELECT MAX(b_id) as b_id FROM blog');}
	public function select_comment_b_id_total($b_id){return $this->fetch('SELECT count(*) as b_comments FROM comments WHERE b_id=:b_id',array(':b_id'=>$b_id));}
	public function select_blog_com_vie($b_id){return $this->fetchAll('SELECT b_id,b_comments,b_views FROM blog WHERE b_id IN('.$b_id.') ORDER BY b_id DESC');}
	public function getIPnewDate($ip){return $this->fetch('SELECT c_date FROM comments WHERE c_ip=INET_ATON(:c_ip) ORDER BY c_id DESC LIMIT 1',array(':c_ip'=>$ip));}

	/** 合作 **/
	public function open_getBlogList($limit,$only_recommend){
		$where = $only_recommend ? 'WHERE b_tj="1"' : '';
		$sql = 'SELECT b_id,b_title,b_intro,b_date,b_comments,b_views,b_tj FROM blog '.$where.' ORDER BY b_id DESC LIMIT '.$limit;
		return $this->fetchAll($sql);	
	}
}
