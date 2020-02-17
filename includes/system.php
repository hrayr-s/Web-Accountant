<?php
include_once 'config.php';
$config=new config();
if($config->dbcon->connect_errno) {
	echo $config->dbcon->connect_error;
	exit;
}
include_once 'db.php';
//include_once 'ps.php';
include_once 'pages.php';
include_once 'seo.php';
include_once 'module.php';
include_once 'ajax.php';
include_once 'json.php';
include_once 'content.php';
include_once 'html_maker.php';
class system {
	var $pTitle = null;
	var $pMeta = null;
	var $pScripts = null;
	var $pStyles = null;
	var $modules = null;
	var $mindex	= 0;
	function __construct() {
		global $styles,$scripts,$seo,$db;
		$db = new db();
		$db->connect();
		$seo = new seo();
		$this->loadData($_GET['returnDatatype']);
	}
	function check_up($login,$pass) {
		global $config,$log;
		$m=$config->dbcon;
		$query=$config->dbcon->query("SELECT * FROM `users` WHERE `login`='$login'") or die($m->error());
		$l=$query->fetch_assoc();
		if($query->num_rows>0) {
			if($l['password']==$pass){
				$_SESSION['userID'] = $l['id'];
				return true;
			}
		}
		return false;
	}
	public static function header() {
		include_once _layout.'/header.php';
	}
	public static function footer() {
		include_once _layout.'/footer.php';
	}
	function loadData($type='content') {
		$option=$_GET['option'];
		$pag=pages::getPath($option);
		if(empty($pag['path']))
			$this->processModules($option);
		else
			$this->processPage($option);
		$contentHandler=null;
		$data=$this->modules[0]->data;
		$type= mb_strtolower($type);
	//	var_dump($data);
		switch ($type) {
			case 'json':
					$contentHandler=new JsonData();
				break;
			case 'ajax':
					$contentHandler=new Ajax();
					$contentHandler->cookingHtml($data);
				break;
			case 'content':
			default:
					$contentHandler=new Content();
					$contentHandler->getDoc($data);
				break;
		}
		echo $contentHandler->html;
	}
	function processModules($name = null) {
		$this->modules[$this->mindex] = new module(!empty($name) ? $name : 1);
		$this->mindex++;
	}
	function processPage($option) {
		$this->modules[$this->mindex] = new module('Page Loader',$option);
		$this->mindex++;
	}
}