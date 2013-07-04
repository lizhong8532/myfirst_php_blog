<?php
require_once('../include/public.php');
$t = 4;
$title = '排行榜 - 琼台博客';
$keywords = '排行榜,WEB技术,琼台博客';
$b_id=9999993;
$b_date='other';
require_once('header.php');
?>
<div id="centent">
	<div class="main">			
		<div class="top">
			<div class="box t1">
				<h3>Comments</h3>
				<ul>
					<?php 
					$list = $db->blog_top(); 
					$str = '';
					for($i=0,$k=count($list);$i<$k;$i++){
						$str .= '<li>';
						if($i<3){$str .= '<span class="up">'.($i+1).'</span>';}else{$str .= '<span>'.($i+1).'</span>';}
						$str .= '<a href="http://www.qttc.net/'.date('Ym',strtotime($list[$i]['b_date'])).$list[$i]['b_id'].'.html" title="'.$list[$i]['b_title'].'" target="_blank">';
						$str .= topSub($list[$i]['b_title']).'('.$list[$i]['b_comments'].')</a></li>';
					}
					echo $str;
					?>
				<ul>
			</div>
			<div class="box t2">
				<h3>Tags</h3>
				<ul>
					<?php
					$list = $db->blogtag_top();
					$str = '';
					for($i=0,$k=count($list);$i<$k;$i++){
						$str .= '<li>';	
						if($i<3){$str .= '<span class="up">'.($i+1).'</span>';}else{$str .= '<span>'.($i+1).'</span>';}
						$str .= '<a href="http://www.qttc.net/tag/'.$list[$i]['t_name'].'">'.$list[$i]['t_name'].'('.$list[$i]['t_count'].')</a></li>';
					}
					echo $str;
					?>				
				</ul>
			</div><div class="clearit"></div>
			<div class="box t3">
				<h3>Categorys</h3>
				<ul>
					<?php
					$list = $db->category_top();
					$str = '';
					for($i=0,$k=count($list);$i<$k;$i++){
						$str .= '<li>';	
						if($i<3){$str .= '<span class="up">'.($i+1).'</span>';}else{$str .= '<span>'.($i+1).'</span>';}
						$str .= '<a href="http://www.qttc.net/category/'.$list[$i]['cg_id'].'">'.$list[$i]['cg_name'].'('.$list[$i]['cg_count'].')</a></li>';
					}
					echo $str;
					?>
				</ul>
			</div>
			<div class="box t4">
				<h3>Months</h3>
				<ul>
					<?php
					$list = $db->stt_top();
					$str = '';
					for($i=0,$k=count($list);$i<$k;$i++){
						$str .= '<li>';	
						if($i<3){$str .= '<span class="up">'.($i+1).'</span>';}else{$str .= '<span>'.($i+1).'</span>';}
						$str .= '<a href="http://www.qttc.net/date/'.$list[$i]['ym'].'">'.date_to_dateName($list[$i]['ym']).'('.$list[$i]['total'].')</a></li>';
					}
					echo $str;
					?>
				<ul>
			</div>
			<div class="clearit"></div>
		</div>
		<?php include_once('comment.php'); ?>
	</div>
	<div class="right"><?php include_once('right.php'); ?></div>
	<div class="clearit"></div>
</div>
<?php include_once('footer_start.php'); ?>
<?php include_once('footer_end.php'); ?>
