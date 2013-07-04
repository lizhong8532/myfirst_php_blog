
<div class="comment">
	<p></p>
	<p><input type="text" name="user" tabindex="1" value="<?php echo $_COOKIE['c_user']; ?>" /><span>乳名？小名？昵称？网名？均可</span></p>
	<p><input type="email" name="email" tabindex="2" value="<?php echo $_COOKIE['c_email']; ?>" /><span>email，放心，我不会给你乱投广告的</span></p>
	<p><input type="text" name="url" tabindex="3" value="<?php echo $_COOKIE['c_url']; ?>" /><span>想获得回访就把你的站点URL写上（没有留空）</span></p>
	<p>
		<a href="javascript:void(0);" title="smile"><img src="images/ico/icon_smile.gif" /></a>
		<a href="javascript:void(0);" title="mrgreen"><img src="images/ico/icon_mrgreen.gif" /></a>
		<a href="javascript:void(0);" title="razz"><img src="images/ico/icon_razz.gif" /></a>
		<a href="javascript:void(0);" title="lol"><img src="images/ico/icon_lol.gif" /></a>
		<a href="javascript:void(0);" title="redface"><img src="images/ico/icon_redface.gif" /></a>
		<a href="javascript:void(0);" title="biggrin"><img src="images/ico/icon_biggrin.gif" /></a>
		<a href="javascript:void(0);" title="sad"><img src="images/ico/icon_sad.gif" /></a>
		<a href="javascript:void(0);" title="surprised"><img src="images/ico/icon_surprised.gif" /></a>
		<a href="javascript:void(0);" title="wink"><img src="images/ico/icon_wink.gif" /></a>
		<a href="javascript:void(0);" title="neutral"><img src="images/ico/icon_neutral.gif" /></a>
		<a href="javascript:void(0);" title="cool"><img src="images/ico/icon_cool.gif" /></a>
		<a href="javascript:void(0);" title="arrow"><img src="images/ico/icon_arrow.gif" /></a>
		<a href="javascript:void(0);" title="evil"><img src="images/ico/icon_evil.gif" /></a>
		<a href="javascript:void(0);" title="cry"><img src="images/ico/icon_cry.gif" /></a>
		<a href="javascript:void(0);" title="eek"><img src="images/ico/icon_eek.gif" /></a>
		<a href="javascript:void(0);" title="confused"><img src="images/ico/icon_confused.gif" /></a>
		<a href="javascript:void(0);" title="exclaim"><img src="images/ico/icon_exclaim.gif" /></a>
		<a href="javascript:void(0);" title="rolleyes"><img src="images/ico/icon_rolleyes.gif" /></a>
		<a href="javascript:void(0);" title="question"><img src="images/ico/icon_question.gif" /></a>
		<a href="javascript:void(0);" title="mad"><img src="images/ico/icon_mad.gif" /></a>
		<a href="javascript:void(0);" title="idea"><img src="images/ico/icon_idea.gif" /></a>
		<a href="javascript:void(0);" title="twisted"><img src="images/ico/icon_twisted.gif" /></a>
	</p>
	<p style="position:relative;"><textarea onkeyup="checkTT(this);" onFocus="checkTT(this);" name="comment" tabindex="4"></textarea><span style="z-index:10;font-family: Constantia;font-size:50px;position:absolute;font-weight:bold;top:50px;left:380px;opacity:0.5;">200</span></p>
	<p class="notice">
		<span>[NOTICE]</span>木要投放广告<br />
		<span>[NOTICE]</span>木要骂人，说不该说的话<br />
		<span>[NOTICE]</span>自由言论，但要遵纪守法
	</p>
	<p><input type="button" name="submit" onclick="subComment(this);" value="submit" /></p>
	<p><input type="hidden" name="b_id" value="<?php echo $b_id ?>" /></p>
	<p><input type="hidden" name="b_date" value="<?php echo $b_date; ?>" /></p>
	<p><input type="hidden" name="c_parent" value="0" /></p>
</div>

<div class="comment_list" id="comment">

	<?php $list = $db->select_comment_p($b_id); ?>

	<?php
		if(empty($post)){
			$post['b_comments'] = count($list);
		}
	?>

	<h3>Comments <span style="color:red;"><?php echo $post['b_comments'] ?></span></h3>

	<ul>
	
	<?php for($i=0,$k=count($list);$i<$k;$i++): ?>
		<?php $zlist = $db->select_comment_z($list[$i]['c_id']) ?>

		<li id="<?php echo $list[$i]['c_id'] ?>">	

			<a name="<?php echo $list[$i]['c_id'] ?>"></a>

			<div class="img">
				<a href="http://www.qttc.net/user/<?php echo $list[$i]['c_md5'] ?>" target="_blank"><img data-original="http://www.gravatar.com/avatar/<?php echo $list[$i]['c_md5'] ?>.jpg?s=60$d=&r=G" src="http://www.qttc.net/images/loading.gif" /></a>
			</div>

			<div class="reply_right">

				<div><a href="http://www.qttc.net/user/<?php echo $list[$i]['c_md5'] ?>" target="_blank"><?php echo $list[$i]['c_user'] ?></a></div>

				<div><?php echo $list[$i]['c_content'] ?></div>

				<div class="triangles"></div>
				<div class="reply_info">
					<span><?php echo substr($list[$i]['c_date'],0,16) ?></span>
					<span><a href="javascript:void(0);" onclick="reply_comment(<?php echo $list[$i]['c_id'] ?>,'<?php echo $i+1 ?>楼');">[ 跟帖 ]</a></span>
				</div>
				
				<?php for($j=0,$z=count($zlist);$j<$z;$j++): ?>

					<div class="reply_box">
						<a href="http://www.qttc.net/user/<?php echo $zlist[$j]['c_md5'] ?>" target="_blank"><img data-original="http://www.gravatar.com/avatar/<?php echo $zlist[$j]['c_md5'] ?>.jpg?s=60$d=&r=G" src="http://www.qttc.net/images/loading.gif" /></a>

						<div class="reply_box_right">
							<div><a href="http://www.qttc.net/user/<?php echo $zlist[$j]['c_md5'] ?>" target="_blank"><?php echo $zlist[$j]['c_user'] ?></a></div>		
							<div><?php echo $zlist[$j]['c_content'] ?></div>
							<div class="reply_info">
								<span><?php echo substr($zlist[$j]['c_date'],0,16) ?></span>
								<span><a href="javascript:void(0);" onclick="reply_comment(<?php echo $list[$i]['c_id'] ?>,'<?php echo $i+1 ?>楼');">[ 跟帖 ]</a></span>
							</div>
						</div>
						<div class="clearit"></div>
					</div>	

				<?php endfor ?>

			</div>

			<div class="clearit"></div>
			<span><?php echo $i+1 ?> #</span>
		</li>	

	<?php endfor ?>

	</ul>

	<?php if(empty($list)): ?>
		<div style="height:50px;text-align:center;width:100%;color:#999;">Hi，你想第一个做沙发么？ </div>
	<?php endif ?>

</div>
