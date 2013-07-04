
CKEDITOR.editorConfig = function( config )
{
	config.language = 'zh-cn';
	config.resize_enabled = false;
	config.height = 500;
	config.extraPlugins = 'syntaxhighlight';
    	config.toolbar_Full.push(['Code']);
	config.smiley_path = 'http://www.qttc.net/images/ico/';
	config.smiley_images = ['icon_smile.gif','icon_mrgreen.gif','icon_razz.gif','icon_lol.gif','icon_redface.gif','icon_biggrin.gif',
		'icon_sad.gif','icon_surprised.gif','icon_wink.gif','icon_neutral.gif','icon_cool.gif','icon_arrow.gif','icon_evil.gif',
		'icon_cry.gif','icon_eek.gif','icon_confused.gif','icon_exclaim.gif','icon_rolleyes.gif','icon_question.gif','icon_mad.gif','icon_idea.gif','icon_twisted.gif'];	
	config.filebrowserImageUploadUrl = 'http://lee.qttc.net/plug/ckeditor/upload.php?type=img';	
};
