<?php
class db {
	public $c 				=	null;
	public $r 				=	null;
	public $columns_show	=	null;
	public $wh_vars			=	null;
	public $columns			=	null;
	public $values			=	null;
	public $table			=	null;
	public $command			=	null;
	public $coldata			=	null;
	public $limits			=	null;
	public $query_string	=	null;
	public $answer			=	null;
	public $orderby			=	null;
	private $errors			=	null;
	public function __construct() {
		
	}
	public function connect() {
		global $config;
		$this->c = $config->dbcon;
	}
	public function query($query) {
		$this->r = $this->c->query($query) or $this->errorHanding($this->c->error,$query);
		return $this->r;
	}
	public function deleteRow($info) {

	}
	public function addRow($info) {

	}
	public function editRow($info) {

	}
	public function getRow($info) {
		if(!$info['tb'])
			return 0;
		if(!$info['wh'])
			return 0;
		$where="1=1";
		foreach($info['wh'] as $k => $v) {
			$where.=" AND `$k`=".(gettype($v)=='integer' ? $v : "'$v'");
		}
		$finalyQuery="SELECT * FROM `$info[tb]` WHERE $where";
		$k = $this->c->query($finalyQuery) or $this->errorHanding($this->c->error,$finalyQuery);
		$this->r = $k;
		return $k;
	}
	public function insert($table=null, $columns=null, $values=null) {
		$table=!empty($table) ? $table : $this->table;
		$columns= !empty($columns) ? $columns : $this->columns;
		$values= !empty($values) ? $values : $this->values;
		// array like this array() { 1 => 'column1', 2 => 'column2',... }
		// array like this array() {  1 => 'value1', 2 => 'value2',... }
		// The keys of $columns and $values must been synchronized 
		if(gettype($columns)=='array') {
			$colstr='(';
			$valstr='VALUES(';
			foreach($columns as $k=>$v) {
				$colstr.="`$v`,";
				$valstr.="'".$values[$k]."',";
			}
			$colstr=substr_replace($colstr,'',-1);
			$colstr.=')';
			$valstr=substr_replace($valstr,'',-1);
			$valstr.=')';
		}elseif(gettype($columns)=='string') {
			$colstr=$columns;
			$valstr=$values;
		}
		/*
		if(gettype($values)=='array') {
			$valstr='VALUES(';
			foreach($values as $v) {
				$valstr.="'$v',";
			}
			$valstr=substr_replace($valstr,'',-1);
			$valstr.=')';
		}elseif(gettype($values)=='string') {
			$valstr=$values;
		}*/
		$orderby= $this->orderby ? "ORDER BY `$this->orderby`" : '';
		$limits= $this->limits ? "LIMIT $this->limits" : '';
		$finalyQuery="INSERT INTO `$table` $colstr $valstr $orderby $limits";
		$k=$this->c->query($finalyQuery) or $this->errorHanding($this->c->error,$finalyQuery);
		$this->r = $k;
		return $k;
	}
	public function delete($table=null, $columns=null, $values=null) {
		$table=!empty($table) ? $table : $this->table;
		$columns= !empty($columns) ? $columns : $this->columns;
		$values= !empty($values) ? $values : $this->values;
		$colval="";
		if(gettype($values)=='array' && gettype($columns)=='array'){
		// array like this array() { 1 => 'column1', 2 => 'column2',... }
		// array like this array() {  1 => 'value1', 2 => 'value2',... }
		// The keys of $columns and $values must be synchronized 
			foreach ($columns as $k => $v) {
				$colval.="`$v`='$values[$k]',";
			}
			$colval=str_replace($colval, '', -1);
		}
		else
			$colval="`$columns`=".(gettype($values)=='integer'?$values:"'$values'");
		$orderby= $this->orderby ? "ORDER BY `$this->orderby`" : '';
		$limits= $this->limits ? "LIMIT $this->limits" : '';
		$finalyQuery="DELETE FROM `$table` WHERE $colval $orderby $limits";
		$k=$this->c->query($finalyQuery) or $this->errorHanding($this->c->error,$finalyQuery);
		unset($colval);
		$this->r = $k;
		return $k;
	}
	public function select($table=null, $columns=null, $values=null, $columns_show=null) {
		$table=!empty($table) && $table!=null ? $table : $this->table;
		$columns= !empty($columns) && $columns!=null ? $columns : $this->columns;
		$values= !empty($values) && $values!=null ? $values : $this->values;
		$columns_show = !empty($columns_show) && $columns_show!=null ? $columns_show : $this->columns_show;
		// array like this array() { 1 => 'column1', 2 => 'column2',... }
		// array like this array() {  1 => 'value1', 2 => 'value2',... }
		// The keys of $columns and $values have to be synchronized 
		if(gettype($columns_show)=='array') {
			$t="";
			foreach ($columns_show as $k => $v)
				$t.="`$v`,";
			$columns_show=str_replace($t, '', -1);
			unset($t);
		}
		if(gettype($table)=='array') {
			$t='';
			foreach ($table as $k => $v)
				$t.='`$v`,';
			$table=str_replace($t,'',-1);
			unset($t);
		}
		if(gettype($columns)=='array') {
			$t='';
			foreach ($columns as $k => $v) {
				$t.="`$v`='$values[$k]',";
			}
			$columns=str_replace($t, '',-1);
			unset($t);
		}
	//	if(gettype($columns)=='string'&& $values == null)
		$values='';
		$columns_show = $columns_show ==null ? '*' : $columns_show;
		$orderby= $this->orderby ? "ORDER BY `$this->orderby`" : '';
		$limits= $this->limits ? "LIMIT $this->limits" : '';
		$finalyQuery="SELECT $columns_show FROM $table WHERE $columns $orderby $limits";
		$k=$this->c->query($finalyQuery) or $this->errorHanding($this->c->error,$finalyQuery);
		$this->query_string=$finalyQuery;
		$this->r = $k;
		return $k;
	}
	public function update($table=null, $columns=null,$values=null, $colshow=null, $vars=null) {
		$table=$table ? $table : $this->table;
		$columns= $columns ? $columns : $this->columns;
		$values= $values ? $values : $this->values;
		$colshow= $colshow ? $colshow : $this->$columns_show;
		$vars= $vars ? $vars : $this->wh_vars;
		// array like this array() { 1 => 'column1', 2 => 'column2',... }
		// array like this array() {  1 => 'value1', 2 => 'value2',... }
		// The keys of $columns and $values must be synchronized 
		if(gettype($table)=='array') {
			$t='';
			foreach ($table as $k => $v)
				$t.='`$v`,';
			$table=str_replace($t,'',-1);
			unset($t);
		}
		if(gettype($columns)=='array') {
			$t='';
			foreach ($columns as $k => $v) {
				$t.="`$v`='$values[$k]',";
			}
			$columns=str_replace($t, '',-1);
			unset($t);
		}
		if(gettype($colshow)=='array') {
			$t='';
			foreach ($colshow as $k => $v) {
				$t.="`$v`='$vars[$k]',";
			}
			$colshow=str_replace($t, '',-1);
			unset($t);
		}
		$orderby= $this->orderby ? "ORDER BY `$this->orderby`" : '';
		$limits= $this->limits ? "LIMIT $this->limits" : '';
		$finalyQuery="UPDATE $table SET $columns WHERE $colshow $orderby $limits";
		$k=$this->c->query($finalyQuery) or $this->errorHanding($this->c->error,$finalyQuery);
		$this->r = $k;
		return $k;
	}
	public function errorHanding($error=null,$query=null) {
		$error= $error ? $error : $this->errors;
		if(!$error)
			return 0;
		$err_path=_errors;
		if(file_exists($err_path.'/errors.php')) {
			if(filesize($err_path.'/errors.php')>=102400) {
				for($I=0;;$I++) {
					if(file_exists($err_path."/errors$I.php") && filesize($err_path."/errors$I.php")>=102400) continue;
					$file = $err_path."/errors$I.php";	//fopen($this->err_path."/errors$I.php", 'w+');
					break;
				}
			}
		}
		if($file==null)
			$file = $err_path.'/errors.php';	//fopen($this->err_path.'/errors.php', 'w+');
		//fopen($this->file, 'w+');
		if(file_exists($file))
			$fp=fopen($file, 'r+');
		else {
			$fp=fopen($file, 'w+');
			fwrite($fp, "<"."?"."php die(); ?".">\n");
		}
		fread($fp,filesize($file));
		fwrite($fp, "\n".$error."\t<br />$query");
		fclose($fp);
		return 1;
	}
}