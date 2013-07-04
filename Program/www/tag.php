<?php
require_once('../include/public.php');
$page = $_GET['page'] ? $_GET['page'] : 1;
$tag = $_GET['tag'] ? trimTag($_GET['tag']) : 'PHP';
$keywords = $tag.',琼台博客';
$title = $tag.' - 琼台博客';
$list = $db->select_blog_tag_list($tag,$page);
if(!$list){header('Location:http://www.qttc.net/error.html');}
$total = count($list);
$off = $page*10;
if($total+($off-10)>$off){ array_pop($list);}
require_once('header.php');
?>				
<div id="centent">
	<div class="main">
		<div style="margin-bottom:10px;">
			<h1><?php echo 'Tag : <span style="color:red;">'.$tag.'</span>'; ?></h1></div>
			<div class="list">
				<?php echo loop($list); ?>
			</div>
		<div class="page">
			<?php echo up_down_tag($total+$off); ?>
		</div>
	</div>
	<div class="right"><?php include_once('right.php'); ?></div>
	<div class="clearit"></div>
</div>
<?php require_once('footer_start.php'); ?>
<?php require_once('footer_end.php'); ?>
