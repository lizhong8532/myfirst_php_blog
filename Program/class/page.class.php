<?php

class page{
	//总条数
	protected $total;
	//总页数
	public $pageNum;
	//每页条数大小
	protected $num;
	//当前页
	public $page;
	//获取上一页的数字
	public $prevPage;
	//获取下一页的数字
	public $nextPage;
	//获取每一页开始条数
	protected $startPage;
	//获取每一页结束条数
	protected $endPage;

	// 构造函数 需要用户传入三个值
	// 1. URL 地址
	// 2. 总条数
	// 3. 页大小 默认值为5条每页
	public function __construct($total,$num=5){
		$this->total	= $total;
		$this->num	= $num;	
		$this->pageNum	= $this->getPageNum();
		$this->page	= $this->getPage();
		$this->prevPage	= $this->getPrevPage();
		$this->nextPage = $this->getNextPage();
		$this->startPage= $this->getStartPage();
		$this->endPage	= $this->getEndPage();
	}
	
	// 获取每一页结束的信息条数
	protected function getEndPage(){
		return min($this->getSql()+$this->num,$this->total);	
	}

	// 获取每一页开始的信息条数
	protected function getStartPage(){
		return $this->getSql()+1;	
	} 

	// 获取偏移量
	public function getSql(){
		return ($this->page-1)*$this->num;		
	}

	// 获取下一页的页数
	protected function getNextPage(){
		if($this->page==$this->pageNum)
			return false;
		return $this->page+1;	
	}

	// 获取上一页的页数
	protected function getPrevPage(){
		if($this->num==1)
			return false;	
		return $this->page-1;	
	}

	// 获取当前页
	protected function getPage(){
		if($_GET["page"])
			$page = $_GET['page'];
		else
			$page = 1;
		return min($page,$this->pageNum);
	}

	// 获取总页数函数
	protected function getPageNum(){
		if($this->total<$this->num)
			return 1;
		return ceil($this->total/$this->num);
	}

	// 输出各个功能显示
	public function getInfo(){
		echo $this->pageNum;	
	}

}
