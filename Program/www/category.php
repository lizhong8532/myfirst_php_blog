<?php
require_once('../include/public.php');
$keywords = '琼台博客,PHP博客,WEB技术';
$page = $_GET['page'] ? $_GET['page'] : 1;
$cg_id = $_GET['cg_id'] ? $_GET['cg_id'] : 99;
$cg_name = cgId_to_bgName($cg_id);
$total = $db->cg_total($cg_id);
$title = $cg_name.' - 琼台博客';
$list = $db->select_blog_list(10,$page,$cg_id,null);
if(!$list){header('Location:http://www.qttc.net/error.html');}
require_once('header.php');
?>				
<div id="centent">
	<div class="main">
		<div style="margin-bottom:10px;">
			<h1><?php echo 'Category : <span style="color:red;">'.$cg_name.'</span>'; ?></h1>
		</div>
		<div class="list">
			<?php echo loop($list); ?>
		</div>
		<div class="page">
			<?php echo page($total['total'],2,$page); ?>
		</div>
	</div>
	<div class="right"><?php echo w_right(); ?></div>
	<div class="clearit"></div>
</div>
<?php require_once('footer_start.php'); ?>
<?php require_once('footer_end.php'); ?>

