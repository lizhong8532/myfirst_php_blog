<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title></title>
		<style type="text/css">input{border:none;color:#fff;}</style>
		<script type="text/javascript" src="http://lee.qttc.net/js/jquery.js"></script>
<script type="text/javascript">function submit(keyCode,value){if(keyCode==13 && value.length>5){ $.post("api.php?action=login",{'pass':value},function (data){if(data.error===0){window.location.href='index.php';}else{alert('error');}}, "json");}}	</script>	
	</head>
	<body>
		<input type="password" onkeydown="submit(event.keyCode,this.value);" />	
	</body>
</html>
