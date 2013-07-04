<?php
require_once('../include/admin.php');
?>
<p>
<input type="text" name="page" value="" />
<button onclick="create();">Create One</button>
</p>
<p>
<button onclick="createAll();">Create All</button>
</p>
<script type="text/javascript" src="http://www.qttc.net/js/jquery.js"></script>
<script type="text/javascript">
	function create(){
		var $page = $(':input[name=page]').val();
		$.post("api.php?action=createpage",{'page':$page},function(data){
			if(data.error===0){
				alert('html successful!');
			}else{
				alert('html failure!');		
			}
		}, "json");
	}
	function createAll(){
		$.get("api.php?action=createpageall",function(data){
			if(data.error===0){
				alert('html successful!');
			}else{
				alert('html failure!');		
			}
		}, "json");
	}
</script>
