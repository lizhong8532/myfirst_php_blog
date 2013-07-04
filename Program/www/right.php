<div class="search">
	<input type="text" value="<?php echo $search ?>" />	
	<span></span>	
</div>

<div class="list">
	<a href="http://www.qttc.net/go/vps" target="_blank" style="display:block;height:73px;width:100%;background:url(images/ad.gif) 0 0 no-repeat;"></a>
</div>

<div class="list">
	<a href="http://www.qttc.net/go/aliyun" target="_blank" style="display:block;height:73px;width:100%;background:url(images/ad.gif) 0 -73px no-repeat;"></a>
</div>

<div class="list">

	<div class="title"><span class="fix2"></span>本站推荐</div>	
	<ul class="bozhu">
		<?php echo ping_tj($db->select_blog_tj()); ?>
	</ul>
</div>

<div class="list cate_date_list" style="height:370px;">	
	<div class="title"><span class="fix2"></span>分类日期</div>
	<ul class="cate">
		<?php echo categoryHtml($db->select_category_list()); ?>
	</ul>
	<ul class="date">
		<?php echo dateHtml($db->select_stt_list()); ?>
	</ul>
</div>

<div class="list youwen">	
	<div class="title"><span class="fix2"></span>友文推荐</div>
	<ul>
		<?php include('youwen.txt') ?>
	</ul>
</div>

<div class="list" id="baidu_ad_1">
	Load...
</div>
