<?php
class module {
	var $db		= null;
	var $config = null;
	var $params = null;
	var $jsParams=null;
	var $name	= null;
	var $path	= null;
	var $id 	= null;
	var $data	= null;
	var $aParams= null;
	function __construct($name=null,$params=null) {
		global $db,$config;
		$this->db=$db;
		$this->config = $config;
		$this->aParams=$params;
		if($name!=null)
			$this->name=$name;
		$this->getParams();
		$this->path=_modules.'/'.$this->path;
		$this->includeModule();
	}
	function getParams($name=null) {
		if($name==null)
			$name= !empty($this->name) ? $this->name : $this->id;
		if(gettype($name)=="integer") {
			$this->getParams_int($name);
		}elseif(gettype($name)=="string"){
			$this->getParams_str($name);
		}
	}
	function getParams_int($id) {
		$this->db->getRow(array('tb'=>'modules','wh'=>array('id'=>$id)));
		$m=$this->db->r->fetch_assoc();
		$params=$m['params'];
		$this->path = $m['path'];
		$this->name = $m['name'];
		$params=json_decode($params);
		$this->params=$params;
	}
	function getParams_str($name) {
		$this->db->getRow(array('tb'=>'modules','wh'=>array('name'=>$name)));
		$m=$this->db->r->fetch_assoc();
		$params=$m['params'];
		$this->path = $m['path'];
		$this->id = $m['id'];
		$this->jsParams=$m['params'];
		$params=json_decode($params);
		$this->params=$params;
	}
	function includeModule($path=null) {
		$path= $path ? $path : $this->path;
		include_once $path.'/index.php';
	}
}