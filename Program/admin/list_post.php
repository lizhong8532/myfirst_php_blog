<?php
require_once('../include/admin.php');
$list = $db->select_post_list_all();
?>
<style type="text/css">table,td{border:1px solid #ccc;}</style>
<table>
	<tr>
		<td>b_id</td>
		<td>b_title</td>
		<td>cg_id</td>
		<td>b_views</td>
		<td>b_comments</td>
		<td>b_date</td>
		<td>b_tag</td>
		<td>b_zc</td>
		<td>b_tj</td>
		<td>action</td>
	</tr>
<?php
for($i=0,$k=count($list);$i<$k;$i++){
	echo '<tr>';	
	echo '<td>'.$list[$i]['b_id'].'</td>';
	echo '<td>'.$list[$i]['b_title'].'</td>';
	echo '<td>'.cgId_to_bgName($list[$i]['cg_id']).'</td>';
	echo '<td>'.$list[$i]['b_views'].'</td>';
	echo '<td>'.$list[$i]['b_comments'].'</td>';
	echo '<td>'.$list[$i]['b_date'].'</td>';
	echo '<td>'.$list[$i]['b_tag'].'</td>';
	echo '<td>'.$list[$i]['b_zc'].'</td>';
	echo '<td>'.tuijian($list[$i]['b_id'],$list[$i]['b_tj']).'</td>';
	echo '<td><a href="update_post.php?b_id='.$list[$i]['b_id'].'">Edit<a></td>';
	echo '</tr>';
}	
?>
</table>
<script type="text/javascript" src="http://www.qttc.net/js/jquery.js"></script>
<script type="text/javascript">
function tuijian(b_id,type){
	$.post("api.php?action=tuijian",{'b_id':b_id,'type':type},function(data){
		if(data.error===0){
			alert('操作成功！');	
			location.href="list_post.php?s="+ Date.parse(new Date());
		}else{
			alert('操作失败！');
		}	
	},'json');
	
}
</script>
