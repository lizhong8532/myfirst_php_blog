<?php
require_once('../include/public.php');
$page = $_GET['page'] ? $_GET['page'] : 1;
$search = $_GET['search'] ? trimTag($_GET['search']) : 'PHP';
$keywords = $search.',琼台博客';
$title = 'search:'.$search.' - 琼台博客';
$list = $db->select_blog_title_list($search,$page);
//if(!$list){header('Location:http://www.qttc.net/error.html');}
$total = count($list);
$off = $page*10;
if($total+($off-10)>$off){ array_pop($list);}
require_once('header.php');
?>				
<div id="centent">
	<div class="main">
		<div style="margin-bottom:10px;"><h1><?php echo 'Search : <span style="color:red;">'.$search.'</span>'; ?></h1></div>
		<div class="list">
			<?php echo loop($list); ?>
		</div>

		<?php if(!$total){ echo '<h1>抱歉，没有找到关于['.$search.']的博文!';} ?>
		<div class="page">
			<?php echo up_down_search($total+$off); ?>
		</div>
	</div>
	<div class="right"><?php include_once('right.php'); ?></div>
	<div class="clearit"></div>
</div>
<?php require_once('footer_start.php'); ?>
<?php require_once('footer_end.php'); ?>
