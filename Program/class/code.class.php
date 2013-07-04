<?php
/**
 * 验证码
 * 李忠
 */
class Code{

	// 1. 定义各个成员 有宽、高、画布、字数、类型、画类型
	
	private $width; //宽度
	private $height; //高度
	private $num;  //验证码字数
	private $imgType; //生成图片类型
	private $Type; //字串类型 1,2,3 三个选项  1 纯数字  2 纯小写字母 3 大小写数字混合
	private $hb; //画布
	public $codestr; // 验证码字串

	public function __construct($height=20,$num=4,$imgType="jpeg",$Type=1){
		$this->width = $num*20;
		$this->height = $height;
		$this->num = $num;
		$this->imgType = $imgType;	
		$this->Type = $Type;	
		$this->codestr = $this->codestr();
		$this->zuhe();
	}

	// 2. 定义随机获取字符串函数
	private function codestr(){
		switch($this->Type){
		
			case 1:		// 类型为1  获取1-9随机数
				$str = implode("",array_rand(range(0,9),$this->num));
				break;
			case 2:		// 类型为2  获取a-z随机小写字母
				$str = implode("",array_rand(array_flip(range(a,z)),$this->num));
				break;
			case 3:		// 类型为3  获取数字,小写字母,大写字母 混合
				for($i=0;$i<$this->num;$i++){
					$m = rand(0,2);
					switch($m){
						case 0:
							$o = rand(48,57);
							break;
						case 1:
							$o = rand(65,90);
							break;
						case 2:
							$o = rand(97,122);
							break;	
					}
					$str .= sprintf("%c",$o);
				}
				break;			
		}

		
		return $str;	
	}


	// 3. 初始化画布图像资源
	private function Hb(){
		$this->hb = imagecreatetruecolor($this->width,$this->height);	
	}

	// 4. 生成背景颜色
	private function Bg(){
		return imagecolorallocate($this->hb,rand(130,250),rand(130,250),rand(130,250)); 	
	}

	// 5. 生成字体颜色
	private function Font(){
		return imagecolorallocate($this->hb,rand(0,100),rand(0,100),rand(0,100));	
	}

	// 6. 填充背景颜色
	private function BgColor(){
		imagefilledrectangle($this->hb,0,0,$this->width,$this->height,$this->Bg());	
	}

	// 7. 干扰点
	private function ganrao(){
		$sum=floor(($this->width)*($this->height)/3);
		for($i=0;$i<$sum;$i++){
			imagesetpixel($this->hb,rand(0,$this->width),rand(0,$this->height),$this->Bg());	
		}
	}

	// 8. 随机直线 弧线
	private function huxian(){
		for($i=0;$i<$this->num;$i++){
			imageArc($this->hb,rand(0,$this->width),rand(0,$this->height),rand(0,$this->width),rand(0,$this->height),rand(0,360),rand(0,360),$this->Bg());		
		}	
	}

	// 9. 写字
	private function xiezi(){
		for($i=0;$i<$this->num;$i++){
			$x=ceil($this->width/$this->num)*$i;	
			$y=rand(1,$this->height-15);
			imagechar($this->hb,5,$x+4,$y,$this->codestr[$i],$this->Font());
		}	
	}

	// 10. 输出
	private function OutImg(){
		$shuchu="image".$this->imgType;	
		$header="Content-type:image/".$this->imgType;
		if(function_exists($shuchu)){
			header($header);
			$shuchu($this->hb);	
		}else{
			exit("GD库没有此类图像");	
		}
	}

	// 11. 拼装
	private function zuhe(){
		$this->Hb();
		$this->BgColor();
		$this->ganrao();
		$this->huxian();
		$this->xiezi();
		$this->OutImg();	
	}	

	public function getCodeStr(){
		return $this->codestr;		
	}
}
