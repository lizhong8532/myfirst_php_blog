<?php
require_once('../include/public.php');
$keywords = '琼台博客,PHP博客,WEB技术';
$page = $_GET['page'] ? $_GET['page'] : 1;
$date = $_GET['date'] ? $_GET['date'] : date('Ym');
$date_name = date_to_dateName($date);
$total = $db->dt_total($date);
$title = $date_name.' - 琼台博客';
$list = $db->select_blog_list(10,$page,null,$date);
if(!$list){header('Location:http://www.qttc.net/error.html');}
require_once('header.php');
?>				
<div id="centent">
	<div class="main">
		<div style="margin-bottom:10px;">
			<h1><?php echo 'Date : <span style="color:red;">'.$date_name.'</span>'; ?></h1>
		</div>
		<div class="list">
			<?php echo loop($list); ?>
		</div>
		<div class="page">
			<?php echo page($total['total'],3,$page); ?>
		</div>
	</div>
	<div class="right"><?php include_once('right.php'); ?></div>
	<div class="clearit"></div>
</div>
<?php require_once('footer_start.php'); ?>
<?php require_once('footer_end.php'); ?>

