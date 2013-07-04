<?php
class db {
	public static $cennct = null;
	private function __construct(){return false;}
	private function conn(){
		$pdo = new PDO('mysql:host=localhost;dbname=qttc','root','008532');
		$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);		
		$pdo->query('set names utf8');						
		return $pdo;									
	}
	public static function getdb(){
		if(self::$cennct  == null )
			self::$cennct  = self::conn();	
        	return true;
	}
	protected function fetch($sql,$param=array()){
		$this->getdb();
		$tmp = self::$cennct->prepare($sql);
		$tmp->execute($param);
		return $tmp->fetch(PDO::FETCH_ASSOC);
	}
	protected function fetchAll($sql,$param=array()){
		$this->getdb();
		$tmp = self::$cennct->prepare($sql);
		$tmp->execute($param);
		return $tmp->fetchAll(PDO::FETCH_ASSOC);			
	}

	protected function execute($sql,$param=array()){
		$this->getdb();	
		$tmp = self::$cennct->prepare($sql);
		return $tmp->execute($param);
	}

	// 组合语句
	private function com_sql($table=null,$where=null,$field=null){
		if(!$table){ return false; }	

		if($field){
			$sql = 'SELECT '.$field.' FROM '.$table;
		}else{
			$sql = 'SELECT * FROM '.$table;
		}

		$param = array();
		$tmpArr = array();
		if($where && is_array($where)){
			foreach($where as $k=>$v){
				$tmpArr[] = $k.'=:'.$k;
				$param[':'.$k] = $v;
			}	
			if(is_array($tmpArr)){
				$sql .= ' WHERE '.implode(' AND ',$tmpArr);
			}
		}
		
		return array('sql'=>$sql,'param'=>$param);		
	}
	
	// 公查单条
	// $table 表名
	// $where 条件
	// $field 字段 空为*
	// 返回全部查询结果
	public function select($table=null,$where=null,$field=null){
		$tmp = $this->com_sql($table,$where,$field);
		return $this->fetch($tmp['sql'],$tmp['param']);
		
	}

	// 公查多条
	// $table 表名
	// $where 条件
	// $field 字段 空为*
	// 返回全部查询结果
	public function selects($table=null,$where=null,$field=null){
		$tmp = $this->com_sql($table,$where,$field);
		return $this->fetchAll($tmp['sql'],$tmp['param']);
		
	}

	// 公插
	// $table  = 表名
	// $values = 参数 
	// 返回执行结果
	public function insert($table=null,$values=null){
		if(!$table || !$values || !is_array($values)){ return false; }

		$sql = 'INSERT INTO '.$table;	

		$tmpArr = array();
		$keyArr = array();
		$param  = array();
		foreach($values as $k=>$v){
			$tmpArr[] = ':'.$k;	
			$keyArr[] = $k;
			$param[':'.$k] = $v;
		}

		$sql .= '('.implode(',',$keyArr).') VALUES('.implode(',',$tmpArr).')';

		$result = $this->execute($sql,$param);
	
		return $result;
	}

	// 公改
	// $table = 表名
	// $values = 参数
	// $where  = 条件
	// 返回执行结果
	public function update($table=null,$values=null,$where=null){
		if(!$table || !$values || !is_array($values) || !$where || !is_array($where)){ return false; }		

		$sql = 'UPDATE '.$table.' SET ';

		$tmpArr = array();
		$param = array();
		foreach($values as $k=>$v){
			$tmpArr[] = $k.'=:'.$k;	
			$param[':'.$k] = $v;
		}		
		
		$sql .= implode(',',$tmpArr);

		$tmpArr = array();
		foreach($where as $k=>$v){
			$tmpArr[] = $k.'=:'.$k;
			$param[':'.$k] = $v;
		}
		
		$sql .= ' WHERE '.implode(' AND ',$tmpArr);

		$result = $this->execute($sql,$param);
	
		return $result;
		
	}

	// 公删
	// $table = 表名
	// $where = 条件
	// 返回执行结果
	public function delete($table=null,$where=null){
		if(!$table || !$where || !is_array($where)){ return false; }	

		$sql = 'DELETE FROM '.$table;
	
		$tmpArr = array();
		foreach($where as $k=>$v){
			$tmpArr[] = $k.'=:'.$k;
			$param[':'.$k] = $v;
		}

		$sql .= ' WHERE '.implode(' AND ',$tmpArr);

		$result = $this->execute($sql,$param);

		return $result;
	}
}
