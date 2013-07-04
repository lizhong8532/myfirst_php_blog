<?php
require_once('../include/admin.php');
?>
<button onclick="create();">Create</button>
<script type="text/javascript" src="http://www.qttc.net/js/jquery.js"></script>
<script type="text/javascript">
	function create(){
		$.get("api.php?action=createcommentnew",function(data){
			if(data.error===0){
				alert('html successful!');
			}else{
				alert('html failure!');		
			}
		}, "json");
	}
</script>
