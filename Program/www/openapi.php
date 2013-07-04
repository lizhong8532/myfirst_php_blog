<?php
require_once('../include/public.php');
$title = '琼台博客开放平台 - 琼台博客';
$keywords = '关于博客,WEB技术';
require_once('header.php');
?>

<style type="text/css">
.openapi { line-height:200%; margin-bottom:30px; }
.openapi_about { border:1px solid #EEE; background:#F5F5F5; padding:10px; }
.openapi_about_title { font-size:20px; margin:0px 0 10px; font-weight:bold; color:red; }
.openapi_about_body { line-height:150%;  }
.openapi_about_body p { margin:5px 0; }
.openapi h3 { margin:20px 0;  color:red; border-bottom:1px dashed red;}
.open_title { font-weight:bold; margin:10px 0;}
.open_url, .open_param, .open_result { border:1px solid #CCC; background:#F5F5F5; color:#270; padding:10px; word-wrap:break-word;word-break:break-all;}

</style>

<div id="centent">
	<div class="main">			
		<div class="openapi">
			
			<div class="openapi_about">
				<div class="openapi_about_title">关于开放平台</div>	
				<div class="openapi_about_body">
					<p>为了让博客平台更加多样化，提高互动性，打破传统博客独角的方式本站发起个人博客开放API平台让好的文章有更多地展示平台！</p>			
					<p>通过本站开放平台API您可以读取到本站最新发布的文章。</p>
				</div>
			</div>
			<h3>接口说明</h3>
			<div class="shuoming">
				<div class="open_title">1、获取最新文章列表</div>
				<div class="open_body">
					<div class="open_title">说明</div>
					<div>接口地址</div>
					<div class="open_url">http://www.qttc.net/api.php?action=open_getBlogList</div>
					<div>参数</div>
					<div class="open_param">
						only_recommend : (可选) 是否只取推荐文章，1 是、 0 否 ，默认 0<br />
						limit : (可选) 读取条数，最大上限 10 ，默认1条<br />
						callback : (可选) 回调函数，为支持jsonp跨域请求参数
					</div>
					<div>返回json格式</div>
					<div class="open_result">
						error : 0 成功处理，非0 出错<br />
						msg : 提示信息<br />
						data : 数据<br />
						[{<br /> 
						&nbsp;&nbsp;b_id : 文章ID<br />
						&nbsp;&nbsp;b_title : 文章标题<br />
						&nbsp;&nbsp;b_intro : 简介<br />
						&nbsp;&nbsp;b_date : 发布日期 (Y-m-d H:i:s 格式)<br />
						&nbsp;&nbsp;b_comments :  评论数量<br />
						&nbsp;&nbsp;b_views :  查看次数（不是实时更新）<br />
						&nbsp;&nbsp;b_tj :  是否推荐文章 1 是 0 否<br />
						&nbsp;&nbsp;b_url :  文章URL<br />
						}]
					</div>
					<div class="open_title">示例</div>
					<div>调用URL</div>
					<div class="open_url">http://www.qttc.net/api.php?action=open_getBlogList&only_recommend=1&limit=1&callback=jsonp_callback</div>
					<div>返回</div>
					<div class="open_result">	
{"error":0,"data":[{"b_id":"312","b_title":"\u5237iPhone\u7684\u60e8\u75db\u7ecf\u5386\uff01","b_intro":"\u6b32\u54ed\u65e0\u6cea\uff0c\u6211\u82b1\u4e86\u8fd1\u516b\u4e2a\u5c0f\u65f6\u6ca1\u641e\u597d\uff0c\u6dd8\u5b9d\u5237\u673a\u670d\u52a1\u5341\u4e94\u5206\u949f\u641e\u5b9a\u3002","b_date":"2013-04-19 16:28:47","b_comments":"0","b_views":"83","b_tj":"0","b_url":"http:\/\/www.qttc.net\/201304312.html"}]}
					</div>
				</div>

				<div class="open_title">2、获取文章详细内容</div>
				<div class="open_body">
					<div class="open_title">说明</div>
					<div>接口地址</div>
					<div class="open_url">http://www.qttc.net/api.php?action=open_getBlogDetailed</div>
					<div>参数</div>
					<div class="open_param">
						b_id : (必须) 文章ID<br />
						callback : (可选) 回调函数，为支持jsonp跨域请求参数
					</div>
					<div>返回json格式</div>
					<div class="open_result">
						error : 0 成功处理，非0 出错<br />
						msg : 提示信息<br />
						data : 数据<br />
						{<br /> 
						&nbsp;&nbsp;b_title : 文章标题<br />
						&nbsp;&nbsp;b_intro : 文章简介<br />
						&nbsp;&nbsp;b_date : 发布日期 (Y-m-d H:i:s 格式)<br />
						&nbsp;&nbsp;b_comments :  评论数量<br />
						&nbsp;&nbsp;b_views :  查看次数（不是实时更新）<br />
						}
					</div>
					<div class="open_title">示例</div>
					<div>调用URL</div>
					<div class="open_url">http://www.qttc.net/api.php?action=open_getBlogDetailed&b_id=2</div>
					<div>返回</div>
					<div class="open_result">
					<?php 
					echo htmlspecialchars('{"error":0,"data":{"b_title":"CSS3\u5706\u89d2\u8fd9\u4e48\u7b80\u5355","b_intro":"\u5728CSS3\u4ee5\u524d\uff0c\u8981\u5b9e\u73b0\u5706\u89d2\u5927\u591a\u4f7f\u7528\u56fe\u7247\uff0c\u800c\u5728CSS3\u91cc\u5b9e\u73b0\u5706\u89d2\u53ea\u8981\u4e00\u53e5\u8bdd\u5373\u53ef\u5b9e\u73b0","b_content":"<p>\n\t\u5728CSS3\u4ee5\u524d\uff0c\u8981\u5b9e\u73b0\u5706\u89d2\u5927\u591a\u4f7f\u7528\u56fe\u7247\uff0c\u800c\u5728CSS3\u91cc\u5b9e\u73b0\u5706\u89d2\u53ea\u8981\u4e00\u53e5\u8bdd\u5373\u53ef\u5b9e\u73b0\uff0c\u867d\u7136\u90e8\u5206\u6d4f\u89c8\u5668\u4e0d\u652f\u6301CSS3\uff0c\u4f46\u672a\u6765\u4e00\u5b9a\u4f1a\u5411CSS3\u9760\u62e2\u7684\u3002<\/p>\n<pre class=\"brush:css;\">\n&lt;style type=&quot;text\/css&quot;&gt;\ndiv {\n\twidth:200px; \n\theight:50px;\n\tbackground:red; \n\tborder-radius:10px;\n}\n&lt;\/style&gt;\n&lt;div&gt;&lt;\/div&gt;<\/pre>\n<p>\n\t\u6548\u679c<\/p>\n<p>\n\t<img alt=\"CSS3\u5706\u89d2\" src=\"http:\/\/www.qttc.net\/upload\/2012\/13428819052267.png\" \/><\/p>\n<p>\n\t\u4ee5\u4e0a\u4ee3\u7801\u91cc\u7684border-radius\u5c31\u662f\u5b9e\u73b0\u5706\u89d2\u8bed\u53e5\uff0c\u503c\u8d8a\u5927\u5706\u89d2\u8d8a\u5927\uff0c\u652f\u6301\u591a\u503c\u65b9\u5f0f\uff0c\u5982\u56db\u4e2a\u503c\u5206\u522b\u662f\u4e0a\u53f3\u4e0b\u5de6\u3002<\/p>\n","b_date":"2011-12-28 18:50:01","b_comments":"0","b_views":"393"}}');
					?>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="right"><?php include_once('right.php'); ?></div>
	<div class="clearit"></div>
</div>
<?php include_once('footer_start.php'); ?>
<?php include_once('footer_end.php'); ?>
