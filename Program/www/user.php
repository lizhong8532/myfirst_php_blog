<?php
require_once('../include/public.php');
$md5 = trim($_GET['md5']); 
if(!$md5){header('Location:http://www.qttc.net/error.html');}
$data = $db->select_comments_url_user($md5);
$list = $db->select_comments_md5($md5);
$title = $data['c_user'].' - 围观者 - 琼台博客';
$keywords = '围观者,用户,留言者';
$k=count($list);
require_once('header.php');
?>
<div id="centent">
	<div class="main user">			
		<div style="border-bottom:2px solid #ccc;">
			<img style="float:left;" alt="<?php echo $data['c_user']; ?>" title="<?php echo $data['c_user']; ?>" src="http://www.gravatar.com/avatar/<?php echo $md5; ?>.jpg?s=60$d=&r=G" />
			<div style="float:left;margin-top:20px;">
				<h2 style="margin-top:0px"><?php echo $data['c_user']; if($md5=='508c2929a1cbb62992951fb028f516af') echo '<span style="color:red;font-size:15px;">（博主）</span>'; ?></h2>
				<?php if($data['c_url']) echo '<p>查看TA的小站 <a href="http://www.qttc.net/go/'.$data['c_url'].'" title="查看【'.$data['c_user'].'】的站点" target="_blank">www.qttc.net/go/'.$data['c_url'].'</a></p>' ?>
				<p style="margin-top:5px;">共<?php echo $k; ?>条评论</p>
			</div>
			<div class="clearit"></div>
		</div>
		
		<ul>
		<?php 
			for($i=0;$i<$k;$i++){
				$str .= '<li><span>#'.($i+1).'</span>【'.reTime($list[$i]['c_date']).'】'.$list[$i]['c_content'].' >>'.cTitle($list[$i]['b_id'],$list[$i]['b_title'],$list[$i]['b_date']).'</li>';
			}
			echo $str;
		?>
		</ul>

		<div style="text-align:center;margin-top:30px;" id="baidu_ad_2">Load...</div>
	</div>
	<div class="right"><?php include_once('right.php'); ?></div>
	<div class="clearit"></div>
</div>
<?php include_once('footer_start.php'); ?>
<div id="baidu_ad_tmp_2" style="display:none;">
	<script type="text/javascript">var cpro_id = "u923457";</script>
	<script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
</div>

<script type="text/javascript">
	// 结尾
	var $obj = $('#baidu_ad_tmp_2');
	$('#baidu_ad_2').html($obj.html());
	$obj.remove();
</script>
<?php include_once('footer_end.php'); ?>

