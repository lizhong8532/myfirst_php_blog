<?php
/*
 * 文件上传类
 * 作者：李忠
 * 日期：2011年6月25日
 *
 * ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
 * 本类支持FORM表单里NAME值为所有下标
 * 操作 
 *
 * 如果是多个文件上传
 * 不需要固下标 可随意指定任意下标
 *
 * 文件命名采用时间值加上三个随机尾数加
 * 原文件后缀名
 *
 * 路径默认为当前网页路径
 *
 * ------------------------------------
 */

class upfile{
	private $topath;	//目标路径
	private $newname;	//新的文件名
	private $maxsize;	//最大尺寸

	public function __construct($maxsize=100000){
		$this->maxsize = $maxsize;	// 初始化最大尺寸限制
	}

	//文件上传主操作函数
	//需要提供目标路径以及需要上传下标
	//如不提供则默认是当前路径
	public function upload($topath="../../upload",$isRename=true,$fname='no.jpg'){
		// 初始化默认路径
		$this->topath=rtrim($topath,"/")."/";
		// 检测目标路径是否存在
		// 如果不存则自动创建
		if(!$this->checkPath()){
			echo "【 {$v['name']} 】 ".$this->getError(-2);
			continue;
		}
		// 无论是否多文件 都执行此操作
		foreach($_FILES as $k=>$v){
			if(is_array($v['name'])){	// 数组执行以下操作
				// 循环出数组
				for($i=0;$i<count($v['name']);$i++){
					// 如果为空则跳过此次循环 
					if($v['name'][$i]==NULL)	
						continue;

					// 首先检测文件是否有错误号
					// 如果有错误号 则退出本次循环
					if($v['error'][$i]!=0){
						echo "【 {$v['name'][$i]} 】 ".$this->getError($v['error'][$i]);	
						continue;
					}

					// 检查大小是否超过
					if($v['size'][$i]>$this->maxsize){
						//return "【 {$v['name'][$i]} 】 ".$this->getError(-1);
						return $v['size'].'&&'.$this->maxsize;
						continue;	
					}

					// 获取文件名
					if($isRename){
						$this->getNewName($v['name'][$i]);
					}else{
						$this->newname = $fname;	
					}

					// 移动文件
					if(!$this->moveFile($v['tmp_name'][$i])){
						echo "【 {$v['name'][$i]} 】 ".$this->getError(-4);	
						continue;	
					}
					
					echo "【 {$v['name'][$i]} 】 文件移动成功！";
				}
			
			}else{	// 单个文件执行以下操作

				//如果为空则跳过本次循环
				if($v==NULL)
					continue;
	
				// 首先检测文件是否有错误号
				// 如果有错误号 则退出本次循环
				if($v['error']!=0){
					return "【 {$v['name']} 】 ".$this->getError($v['error']);	
					continue;
				}

				// 检查大小是否超过
				if($v['size']>$this->maxsize){
					return "【 {$v['name']} 】 ".$this->getError(-1);
					continue;	
				}
				
				// 判断文件是否是图片
				if($v['type']!="image/jpg" && $v['type']!="image/jpeg"){
					return "【 {$v['name']} 】 ".$this->getError(8);
					continue;	
				}
				
				// 产生新的文件名
				if($isRename){
					$this->getNewName($v['name'][$i]);
				}else{
					$this->newname = $fname;	
				}

				// 移动文件
				if(!$this->moveFile($v['tmp_name'])){
					return "【 {$v['name']} 】 ".$this->getError(-4);	
					continue;	
				}

				return "【 {$v['name']} 】 文件移动成功！";
			}	
		}	
	}

	// 移动文件动作
	private function moveFile($tmpname){
		$newPath=$this->topath.$this->newname;
		if(!move_uploaded_file($tmpname,$newPath))
			return false;
		return true;
	}

	// 产生新的文件名
	private function getNewName($name){
		$this->newname = date("YmdHis").rand(100,999).".".array_pop(explode(".",$name));		
	}

	// 检测路径是否存在 不存在则自动创建
	private function checkPath(){
		if(!file_exists($this->topath)){
			if(!mkdir($this->topath,0777,true))
				return false;
			if(!is_writable($this->topath))
				return false;
		}		
		return true;	
	}

	// 判断错误号
	private function getError($error){
		switch($error){
			case -4:
				$string="移动文件失败";
				break;
			case -3:
				$string="不能生成新的文件名";
				break;
			case -2:
				$string="创建目标目录失败";
				break;
			case -1:
				$string="您上传的文件超过了本站限制大小";
				break;
			case 1:
				$string='上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。';
				break;
			case 2:
				$string='上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。';
				break;
			case 3:
				$string='文件只有部分被上传。 ';
				break;
			case 4:
				$string='没有文件被上传。 ';
				break;
			case 6:
				$string='找不到临时文件夹。PHP 4.3.10 和 PHP 5.0.3 引进。';
				break;
			case 7:
				$string='文件写入失败。PHP 5.1.0 引进。 ';
				break;	
			case 8:
				$string='图片类型不正确';
				break;	
			default:
				$string="未知错误";	
		}	
		return $string;
	}
}
