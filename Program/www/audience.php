<?php
require_once('../include/public.php');
$t = 3;
$title = '围观者 - 琼台博客';
$keywords = '围观者,琼台博客';
$b_id = 9999992;
$b_date = 'other';
$list = $db->getAudience();
require_once('header.php');
?>
<div id="centent">
	<div class="main">			
		<div class="audience">
			<?php echo audience($list); ?>
			<div class="clearit"></div>

		</div>

		<div style="text-align:center;margin-top:30px;" id="baidu_ad_2">Load...</div>
		<?php include_once('comment.php'); ?>
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
