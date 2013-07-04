<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0">
<channel about="http://www.qttc.net/">
	<title>琼台博客</title>
	<description>个人WEB技术博客</description>
	<link>http://www.qttc.net</link>
	<language>zh-cn</language>
	<copyright>琼台博客</copyright>
<?php
require_once('../include/public.php');
$list = $db->get_rss();
for($i=0,$k=count($list);$i<$k;$i++){
	echo '<item>';
	echo '<title>'.$list[$i]['b_title'].'</title>';
	echo '<link>http://www.qttc.net/'.date('Ym',strtotime($list[$i]['b_date'])).$list[$i]['b_id'].'.html</link>';
	echo '<pubDate>'.date('r',strtotime($list[$i]['b_date'])).'</pubDate>';
	echo '<guid>http://www.qttc.net/'.$list[$i]['b_id'].'.html</guid>';	
	echo '<category>'.cgId_to_bgName($list[$i]['cg_id']).'</category>';
	echo '<description>'.$list[$i]['b_intro'].'</description>';
	echo '</item>';
}
?>
</channel>
</rss>
