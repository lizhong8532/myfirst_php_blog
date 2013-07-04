<?php
require_once('../include/admin.php');
$list = $db->select_comment_list_all();
?>
<style type="text/css">table,td{border:1px solid #ccc;}</style>
<table>
	<tr>
		<td>c_id</td>
		<td>c_user</td>
		<td>c_date</td>
		<td>c_content</td>
		<td>c_url</td>
		<td>c_email</td>
		<td>c_ip</td>
		<td>b_title</td>
		<td>action</td>
	</tr>
<?php
for($i=0,$k=count($list);$i<$k;$i++){
	echo '<tr>';	
	echo '<td>'.$list[$i]['c_id'].'</td>';
	echo '<td>'.$list[$i]['c_user'].'</td>';
	echo '<td>'.$list[$i]['c_date'].'</td>';
	echo '<td>'.$list[$i]['c_content'].'</td>';
	echo '<td>'.$list[$i]['c_url'].'</td>';
	echo '<td>'.$list[$i]['c_email'].'</td>';
	echo '<td>'.$list[$i]['ip'].'</td>';
	echo '<td>'.cTitle($list[$i]['b_id'],$list[$i]['b_title'],$list[$i]['b_date']).'</td>';
	echo '<td><a onclick="del('.$list[$i]['c_id'].','.$list[$i]['b_id'].')" href="javascript:void(0);">Del</a></td>';
	echo '</tr>';
}	
?>
</table>
<script type="text/javascript" src="http://www.qttc.net/js/jquery.js"></script>
<script type="text/javascript">
function del(c_id,b_id){
	$.post("api.php?action=deleteComment",{'c_id':c_id,'b_id':b_id},function(data){
		if(data.error===0){
			alert('delete successful!');
			window.location.reload();
		}else{
			alert('delete failure!');		
		}
	}, "json");
}
</script>
