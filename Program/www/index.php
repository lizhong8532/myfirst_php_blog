<?php
require_once('../include/public.php');
$cg_id = false;
$page = $_GET['page'] ? $_GET['page'] : 1;
$t = 1;
$des = 'Hi，大家好，这是一个个人WEB技术博客，从事WEB研发4年，主攻PHP、JavaScript、Python方向。是Web技术领域的屌丝男，博客记录平日工作中遇到的技术问题与解决方式，分享WEB技术点点滴滴。';
$keywords = '琼台,博客,PHP,Web,Nginx,JavaScript,CSS3,HTML5,Python,jQuery,Memcache,MySQL,MSSQL,NoSQL,Mangodb,LBS,Linux,CentOS,web.py,django';
$title = '琼台博客 - 苦逼的程序猿';

$list_html = loop($db->select_blog_list(10,$page,null,null));
if(empty($list_html)){header('Location:http://www.qttc.net/error.html');}

$total = $db->total();

include('header.php');
?>				
<div id="centent">
	<div class="main">
		<div class="list">
			<?php echo loop($db->select_blog_list(10,$page,null,null)) ?>
		</div>
		<div class="page">
			<?php echo page($total['total'],1,$page) ?>
		</div>	
	</div>
	<div class="right"><?php include_once('right.php'); ?></div>
	<div class="clearit"></div>
</div>

<?php include('footer_start.php') ?>
<?php include('footer_end.php') ?>


