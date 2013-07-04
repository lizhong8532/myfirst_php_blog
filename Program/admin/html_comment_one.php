<?php
require_once('../include/admin.php');
?>
<p>about 9999991<p>
<p>aud 9999992<p>
<p>top 9999993<p>
<input type="text" name="id" value="" />
<button onclick="create();">Create</button>
<script type="text/javascript" src="http://www.qttc.net/js/jquery.js"></script>
<script type="text/javascript">
	function create(){
		var $b_id = $(':input[name=id]').val();
		$.post("api.php?action=createcommentone",{'b_id':$b_id},function(data){
			if(data.error===0){
				alert('html successful!');
			}else{
				alert('html failure!');		
			}
		}, "json");
	}
</script>
