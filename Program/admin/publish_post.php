<?php
require_once('../include/admin.php');

$cate_list = $db->selects('category');

?>
<p>post title <input type="text" name="title" style="width:500px;" /></p>
<p>post category 
	<select name="category">
	<?php foreach($cate_list as $v): ?>
		<option value="<?php echo $v['cg_id'] ?>"><?php echo $v['cg_name'] ?></option>
	<?php endforeach ?>
	</select>
	post tag <input type="text" name="tag" />
</p>
<p>post intro</p>
<p><textarea name="intro"></textarea></p>
<p><textarea name="content"></textarea></p>
<p></p>
<p><input type="button" value="publish" onclick="publish(this)" /></p>
<script type="text/javascript" src="http://lee.qttc.net/js/jquery.js"></script>
<script type="text/javascript" src="http://lee.qttc.net/plug/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
var cke = CKEDITOR.replace('content');
function publish(obj){
	obj.disabled = true;
	var title = encodeURIComponent($.trim($(":input[name=title]").val()));
	var category = encodeURIComponent($.trim($("select[name='category']").val()));
	var tag   = encodeURIComponent($.trim($(":input[name=tag]").val()));
	var intro = encodeURIComponent($.trim($("textarea[name=intro]").val()));
	//var content = encodeURIComponent(cke.document.getBody().getHtml());
	var content = encodeURIComponent(cke.getData());
	$.post("api.php?action=publish",{'title':title,'category':category,'tag':tag,'content':content,'intro':intro},function(data){
		if(data.error===0){
			alert('publish successful!');
			window.location.href="list_post.php";
		}else{
			alert('publish failure!');		
			obj.disabled = false;
		}
	}, "json");
}

</script>
