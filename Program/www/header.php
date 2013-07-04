<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="keywords" content="<?php echo $keywords; ?>" />
		<meta name="description" content="<?php echo $des; ?>" />
		<title><?php echo $title; ?></title>
		<link href="http://www.qttc.net/css/style.css?version=20130423" rel="stylesheet" type="text/css" />
		<link href="http://www.qttc.net/plug/syntax/css/code.css?version=20130410" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="header-bg">
			<div id="header">
				<div class="tool">
					<a href="http://www.qttc.net/rss.xml" target="_blank" class="dingyue" title="订阅RSS"></a>
					<a href="https://twitter.com/lee17080794" target="_blank" class="twitter" title="我的推特"></a>
				</div>
				<a href="http://www.qttc.net" title="返回首页" class="logo"></a>
				<div class="qianming"><?php echo $qm ?></div>	
				<ul>
					<li <?php if($t==1) echo 'class="light"' ?>><a href="http://www.qttc.net" title="首页">HOME</a></li>
					<li <?php if($t==2) echo 'class="light"' ?>><a href="http://www.qttc.net/about.html" title="关于">ABOUT</a></li>
					<li <?php if($t==3) echo 'class="light"' ?>><a href="http://www.qttc.net/audience.html" title="围观者">AUDIENCE</a></li>
					<li <?php if($t==4) echo 'class="light"' ?>><a href="http://www.qttc.net/top.html" title="排行榜">TOP</a></li>
				</ul>
				<div class="header_bg"></div>
			</div>
		</div>
