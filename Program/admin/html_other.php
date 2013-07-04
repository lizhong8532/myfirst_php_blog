<?php
require_once('../include/admin.php');
?>
<p><button onclick="create('createright');">Create Right</button></p>
<p><button onclick="create('createrand');">Create rand</button></p>
<p><button onclick="create('createxgbw');">Create xgbw</button></p>
<script type="text/javascript" src="http://www.qttc.net/js/jquery.js"></script>
<script type="text/javascript">
	function create(n){
		$.get("api.php?action="+n,function(data){
			if(data.error===0){
				alert('html successful!');
			}else{
				alert('html failure!');		
			}
		}, "json");
	}
</script>
