<?php
require_once('../include/admin.php');
$data = $db->select_blog($_GET['b_id']);

$cate_list = $db->selects('category');

?>
<p>post id <input type="text" name="id" value="<?php echo $data['b_id']; ?>" disabled /></p>
<p>post title <input type="text" name="title" style="width:500px;" value="<?php echo $data['b_title']; ?>" /></p>
<p>post category 
        <select name="category">
        <?php foreach($cate_list as $v): ?>
                <option value="<?php echo $v['cg_id'] ?>" <?php if($data['cg_id']==$v['cg_id']) echo 'selected'; ?> ><?php echo $v['cg_name'] ?></option>
        <?php endforeach ?>
        </select>	
	post tag <input type="text" name="tag" value="<?php echo $data['b_tag']; ?>" />
</p>
<p>post intro</p>
<p><textarea name="intro"><?php echo $data['b_intro']; ?></textarea></p>
<p><textarea name="content"><?php echo $data['b_content']; ?></textarea></p>
<p><input type="hidden" name="old_tag" value="<?php echo $data['b_tag']; ?>" /></p>
<p></p>
<p><input type="button" value="update" onclick="update(this)" /></p>
<script type="text/javascript" src="http://lee.qttc.net/js/jquery.js"></script>
<script type="text/javascript" src="http://lee.qttc.net/plug/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
var cke = CKEDITOR.replace('content');
function update(obj){
	obj.disabled = true;
	var title = encodeURIComponent($.trim($(":input[name=title]").val()));
	var category = encodeURIComponent($("select[name='category']").val());
	var tag   = encodeURIComponent($.trim($(":input[name=tag]").val()));
	var old_tag   = encodeURIComponent($.trim($(":input[name=old_tag]").val()));
	var intro   = encodeURIComponent($.trim($("textarea[name=intro]").val()));
	//var content = encodeURIComponent(cke.document.getBody().getHtml());
	var content = encodeURIComponent(cke.getData());
	var id = encodeURIComponent($.trim($(":input[name=id]").val()));
	$.post("api.php?action=updatePost",{'title':title,'category':category,'tag':tag,'old_tag':old_tag,'content':content,'id':id,'intro':intro},function(data){
		if(data.error===0){
			alert('update successful!');
			$(":input[name=old_tag]").val(tag);
		}else{
			alert('update failure!');		
		}
		obj.disabled = false;
	}, "json");
}

</script>
