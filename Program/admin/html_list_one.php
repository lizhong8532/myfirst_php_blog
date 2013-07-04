<?php
require_once('../include/admin.php');
?>
<input type="text" name="id" value="" />
<button onclick="create();">Create</button>
<script type="text/javascript" src="http://www.qttc.net/js/jquery.js"></script>
<script type="text/javascript">
	function create(){
		var $b_id = $(':input[name=id]').val();
		$.post("api.php?action=createlistone",{'b_id':$b_id},function(data){
			if(data.error===0){
				alert('html successful!');
			}else{
				alert('html failure!');		
			}
		}, "json");
	}
</script>
