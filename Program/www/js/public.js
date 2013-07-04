function subComment(obj){
	butStatus(obj,1);
	var $user = $.trim($(".comment :input[name=user]").val());
	var $email = $.trim($(".comment :input[name=email]").val());
	var $b_date = $(".comment :input[name=b_date]").val();
	var $url = $.trim($(".comment :input[name=url]").val());
	var $comment = $.trim($(".comment textarea").val());
	var $b_id = $(".comment :input[name=b_id]").val();
	var $c_parent = $(".comment :input[name=c_parent]").val();
	if($user=='' || $email=='' || $comment==''){alert('要填写东东后才能提交，木要随便乱点哦！');return butStatus(obj,2);}
	if(getStrLeng($user)>30){alert('昵称过长了哦');return butStatus(obj,2);}
	if(getStrLeng($email)>50){alert('邮箱过长了哦');return butStatus(obj,2);}
	if(!c_email($email)){alert('邮箱格式错误了哦');return butStatus(obj,2);}
	if(getStrLeng($url)>30){alert('URL过长了哦');return butStatus(obj,2);}
	if(!c_url($url)){alert('URL格式错误了哦!!');return butStatus(obj,2);}
	if(getStrLeng($comment)>600){alert('内容字数过多了哦');return butStatus(obj,2);}
	$.post("http://www.qttc.net/api.php?action=subComment",{'b_id':$b_id,'user':encodeURIComponent($user),'email':encodeURIComponent($email),'url':encodeURIComponent($url),'b_date':$b_date,'comment':encodeURIComponent($comment),'c_parent':$c_parent},function(data){
		if(data.error===0){
			$(".comment :input[name=comment]").val('');cancel_reply();$comment = regFace($comment);
			if($c_parent==0){	
				var str = '<li><a href="http://www.qttc.net/user/'+data.c_md5+'" target="_blank"><img src="http://www.gravatar.com/avatar/'+data.c_md5+'.jpg?s=60$d=&r=G" /></a><div class="reply_right"><div><a href="http://www.qttc.net/user/'+data.c_md5+'" target="_blank">'+$user+'</a></div><div>'+$comment+'</div><div class="triangles"></div><div class="reply_info"><span>1 seconds ago</span></div></div><div class="clearit"></div></li>';
				$('.comment_list ul').append(str);
			}else{
				var str = '[{"c_user":"'+$user+'","c_email":"'+$email+'","c_parent":"'+$c_parent+'","c_date":"'+data.date+'","c_content":"'+$comment+'","c_md5":"'+data.c_md5+'","c_id":"","c_url":"'+$url+'"}]';
				reply_append(str);var t = window.location.href.split('#');window.location.href = t[0]+'#'+$c_parent;
			}
			alert('评论成功！');checkTT($(".comment textarea").get(0));var $c_obj = $('.comment_list>h3>span');var iz = Number($c_obj.html());iz++;$c_obj.html(iz);
		}else{alert(data.msg);}
		butStatus(obj,2);
	}, "json");
}
function regFace(str){return str.replace(/\[(smile|mrgreen|razz|lol|redface|biggrin|sad|surprised|wink|neutral|cool|arrow|evil|cry|eek|confused|exclaim|rolleyes|question|mad|idea|twisted)\]/g,function(m,i){return '<img src=\'http://www.qttc.net/images/ico/icon_'+i+'.gif\' />';});}
function butStatus(obj,type){$obj = $(obj);if(type==1){$obj.css('color','#666').attr('disabled',true).val('sendding...');return true;}if(type==2){$obj.css('color','#270').attr('disabled',false).val('submit');return false;}}
function reply_append(data){var list = eval(data);for(var i=0,k=list.length;i<k;i++){var str = '<div class="reply_box"><a href="http://www.qttc.net/user/'+list[i].c_md5+'" target="_blank"><img src="http://www.gravatar.com/avatar/'+list[i].c_md5+'.jpg?s=60$d=&r=G" /></a><div class="reply_box_right"><div><a href="http://www.qttc.net/user/'+list[i].c_md5+'" target="_blank">'+list[i].c_user+'</a></div><div>'+list[i].c_content+'</div><div class="reply_info"><span>'+list[i]['c_date'].substr(0,16)+'</span></div></div><div class="clearit"></div></div>';$('.comment_list #'+list[i].c_parent+' .reply_right').append(str);}}
function reply_comment(c_parent,r_user){$('.comment p:eq(0)').html('跟帖 @ '+r_user+'，<a onclick="cancel_reply();" href="javascript:void(0);">Click here to cancel | 点击这里取消</a>');$(".comment :input[name='c_parent']").val(c_parent); window.location.href='#comment'; $(".comment :input[name='user']")[0].focus();}
function cancel_reply(){$('.comment p:eq(0)').html('');$(".comment :input[name='c_parent']").val(0);}

function GetCookieVal(offset){var endstr = document.cookie.indexOf (";", offset);if (endstr == -1){endstr = document.cookie.length;}return unescape(document.cookie.substring(offset, endstr));}
function SetCookie(name, value){ var expdate = new Date();  expdate.setTime(expdate.getTime() + 24*60*60*1000);document.cookie = name + "=" + escape (GetCookie(name)+','+value) + "; expires="+ expdate.toGMTString();}
function GetCookie(name){var arg = name + "=",alen = arg.length,clen = document.cookie.length,i = 0;while (i < clen){var j = i + alen;if (document.cookie.substring(i, j) == arg){return GetCookieVal (j);}i = document.cookie.indexOf(" ", i) + 1;if (i == 0){break;}}return 0;}

function zhichi(bid,num){var str = GetCookie('bid'),pos = (','+str+',').lastIndexOf(','+bid+',');if(pos!=-1){alert('抱歉！您在一天时间内不能多次点击【支持一下】这篇博文！');}else{$.post('http://www.qttc.net/api.php?action=zhichi',{'b_id':bid});SetCookie('bid',bid);$('.blog .zhichi>a').html('支持一下（'+(++num)+'）');}}


function addExpression(expression) {var comment = $('.comment textarea').get(0);if (document.selection) {comment.focus();slt = document.selection.createRange();slt.text = expression;comment.focus();}else if (comment.selectionStart || comment.selectionStart == '0') {var startPos = comment.selectionStart;var endPos = comment.selectionEnd;var cursorPos = endPos;comment.value = comment.value.substring(0, startPos) + expression + comment.value.substring(endPos,comment.value.length);cursorPos += expression.length;comment.focus();comment.selectionStart = cursorPos;comment.selectionEnd = cursorPos;}else {comment.value += expression;comment.focus();}}
function checkTT(obj){var $zishu = $('.comment textarea').next();var n = 200 - Math.ceil(getStrLeng(obj.value)/3);$zishu.html(n);if(n>=0){$zishu.css('color','#333');}else{$zishu.css('color','red');}}
function c_email(email){var reg = /^([a-zA-Z0-9]{1,40})(([\_\-\.])?([a-zA-Z0-9]{1,40}))*@([a-zA-Z0-9]{1,20})(([\-\_])?([a-zA-Z0-9]{1,20}))*(\.[a-z]{2,4}){1,2}$/;if(reg.test(email)){return true;}else{return false;}}
function c_url(url){if(url=='') return true; var reg = /^(http:\/\/)?(www\.)?([a-zA-Z0-9]{1,20})(([\_\-])?([a-zA-Z0-9]{1,20}))*(\.[a-z]{2,4}){1,2}([\/])?$/;if(reg.test(url)){return true;}else{return false;}}
function getStrLeng(str){var realLength = 0, len = str.length, charCode = -1;for(var i = 0; i < len; i++){charCode = str.charCodeAt(i);if (charCode >= 0 && charCode <= 128) realLength+=1;else realLength += 3;} return realLength;}
function xgbw(cg_id){$('div.liebiao>ul.xgbw').prev().hide();$.get('http://www.qttc.net/api.php?action=xgbw&cg_id='+cg_id,function(data){if(data.error===0){$('div.liebiao>ul.xgbw').html(data.data);}$('div.liebiao>ul.xgbw').prev().show();},"json");}

// 获取随机文章
function rand(){
	$('div.liebiao>ul.rand').prev().hide();
	$.get('http://www.qttc.net/api.php?action=rand',function(data){if(data.error===0){$('div.liebiao>ul.rand').html(data.data);}$('div.liebiao>ul.rand').prev().show();},"json");
}

// 搜索对象
var sousuo = {
	obj:null,

	default_color:'',

	default_value:'搜索，原来这么简单',

	// 键盘事件绑定
	bind_key:function(){
		var _this = this;	
		_this.obj.find('>:input').keydown(function(e){
			var evt =  e || window.event;		
			evt.keyCode == 13 && _this.sub();
		}).focus(function(){
			$.trim($(this).val())==_this.default_value && $(this).css('color',_this.default_color).val('');	
		}).blur(function(){
			$.trim($(this).val())=='' &&  _this.def(); 
		});
	},	

	// 还原
	def:function(){
		var _this = this;
		_this.obj.find('>:input').val(_this.default_value).css('color','#ccc');		    
	},

	// 提交按钮绑定
	bind_btn:function(){
		var _this = this;
		_this.obj.find('>span').click(function(){_this.sub();});
	},	

	// 提交搜索
	sub:function(){
	 	var _this = this;  
		var value = $.trim(_this.obj.find('>input').val());
		value != '' &&  (window.location.href='http://www.qttc.net/search/'+value);
	},

	init:function(str){
	   	// 提交键监听 
		this.obj = $(str);
		this.default_color = this.obj.css('color');

		$.trim(this.obj.find('>:input').val())=='' &&  this.def();

		this.bind_btn(str);
		this.bind_key(str);
	}
};


// 文章区图片点击事件
(function($) {
    $.fn.img_dialog = function(){ 

	var speed = 200;
    	var _this = null; 
	var btn_flag = false;
	var bg = ''; 
	bg += '<div class="img_dialog_bg" style="width:100%;background:#000;opacity:0.7;filter:alpha(opacity=70);position:absolute;left:0;top:0;z-index:2147483600;display:none;"></div>';
	bg += '<div class="img_dialog" style="display:none;position:fixed;border:5px solid #FFF;left:50%;z-index:2147483601;top:50%;"></div>';
	$('body').append(bg);

	var dialog = $('.img_dialog');
	var dialog_bg = $('.img_dialog_bg');

    	$(this).each(function(){

		_this = $(this);

		_this.click(function(){
			if($(this).attr('src').substr(-11) =='loading.gif'){
				return false;
			}

			$(this).css('cursor','pointer').attr('title','点击关灯显示');

			
			dialog_bg.css('height',$(document).height()+'px').show();
		
			// 获取图片宽高
			var img = new Image();
			img.src = $(this).attr('src');
		
			var margin_left = '-'+parseInt(img.width/2)+'px';
			var margin_top = '-'+parseInt(img.height/2)+'px';

			dialog.css({'margin-left':margin_left,'margin-top':margin_top}).html(img).fadeIn(speed);
			img = null;
		});

		dialog_bg.click(function(){
			if(btn_flag){
				return false;
			}
			btn_flag = true;
			dialog.fadeOut(speed,function(){
				dialog_bg.fadeOut(parseInt(speed/2),function(){btn_flag=false;});
			       	$(this).html('');
			});
		});
	});
    }
  
})(jQuery);

// 评论图标事件绑定
$('.comment p a').click(function(){addExpression('['+$(this).attr('title')+']');});

// 搜索初始
sousuo.init('.search');

// 文章图片关灯展示
$('.blog img').img_dialog();

// 懒加载
$('img').lazyload({effect:"fadeIn"});

