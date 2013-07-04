<?php
require_once('../include/public.php');
$path = $_GET['b_id'];
$b_id = substr($path,6);
$b_date = substr($path,0,6);

$post = $db->select_blog($b_id);

if(empty($post)){ header('Location:http://www.qttc.net/error.html'); exit();}

$des = strip_tags($post['b_intro']);
$keywords = $post['b_tag'].',琼台博客';
$title = $post['b_title'].' - 琼台博客';

include('header.php');
?>
<div id="centent">
	<div class="main">
		<div class="blog">
			<div class="title">
				<h2 class="wordwrap"><?php echo $post['b_title'] ?></h2>
				<div class="info">
					<span class="type"><i></i><?php echo cgId_to_bgName($post['cg_id']) ?></span>
					<span class="time"><i></i><?php echo substr($post['b_date'],0,10) ?></span>
					<span class="tags"><i></i><?php echo $post['b_tag'] ?></span>
				</div>
			</div>
			<div class="detailed wordwrap"><?php echo $post['b_content'] ?></div>
				
			<div class="zhichi">
				<a onclick="zhichi(<?php echo $post['b_id']?>,<?php echo $post['b_zc'] ?>);" href="javascript:void(0);">支持一下<?php echo $post['b_zc']==0 ? '' : '（<span>'.$post['b_zc'].'</span>）' ?></a>	
			</div>	

			<div style="color:#000;font-size:14px;font-family:\'microsoft yahei\';">
				<p>文字链接：《<a style="" href="http://www.qttc.net/<?php echo $path ?>.html"><?php echo $post['b_title'] ?></a>》</p>
				<p>文章地址：<a style="" href="http://www.qttc.net/<?php echo $path ?>.html">http://www.qttc.net/<?php echo $path ?>.html</a></p>
				<p>除非标注，<a href="http://www.qttc.net">琼台博客</a>所有博文均为原创，转载请加文字链接注明来源</p>
				<p style="margin-top:3px;" id="baidu_ad_2">
					load...
				</p>
			</div>

			<div class="fenxiang">
				<div class="bshare-custom icon-medium">
				<a title="分享到新浪微博" class="bshare-sinaminiblog" href="javascript:void(0);"></a>
				<a title="分享到QQ空间" class="bshare-qzone" href="javascript:void(0);"></a>
				<a title="分享到人人网" class="bshare-renren" href="javascript:void(0);"></a>
				<a title="分享到腾讯微博" class="bshare-qqmb" href="javascript:void(0);"></a>
				<a title="分享到豆瓣" class="bshare-douban" href="javascript:void(0);"></a>
				<a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a>
				<span class="BSHARE_COUNT bshare-share-count">0</span>
				</div>
			</div>

			<div class="liebiao list">
				<h3><span></span>相关博文</h3><a onclick="xgbw(<?php echo $post['cg_id'] ?>);" href="javascript:void(0);">换一组</a>
				<ul class="xgbw"><?php echo xgbw($db->xgbw($post['cg_id'])) ?></ul>
			</div>
			<div class="liebiao list">
				<h3><span></span>随机文章</h3><a onclick="rand();" href="javascript:void(0);">换一组</a>
				<ul class="rand"><?php echo view_hot($db->select_blog_rand()) ?></ul>
			</div>
				
		</div>

		<?php include_once('comment.php'); ?>

	</div>
	<div class="right"><?php include_once('right.php'); ?></div>
	<div class="clearit"></div>
</div>

<?php include_once('footer_start.php'); ?>

<script type="text/javascript" src="http://www.qttc.net/plug/syntax/js/code.js"></script>
<script type="text/javascript">
SyntaxHighlighter.all();
$.post('http://www.qttc.net/api.php?action=addViews',{'b_id':<?php echo $b_id; ?>});
</script>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&uuid=&pophcol=2&lang=zh"></script>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>

<div id="baidu_ad_tmp_2" style="display:none;">
	<script type="text/javascript">var cpro_id = "u923720";</script>
	<script src="http://cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>
</div>

<script type="text/javascript">
	// 右侧广告
	var $obj = $('#baidu_ad_tmp_2');
	$('#baidu_ad_2').html($obj.html());
	$obj.remove();
</script>

<?php include_once('footer_end.php'); ?>
