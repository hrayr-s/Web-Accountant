<?php
class Amount {
	private $db		=	null;
	private $table 	=	null;
	private $params =	null;
	public $page 	=	null;
	public $pages	=	null;
	function __construct($params) {
		global $config,$db;
		$this->db=$db;
		$this->table='amounts';
		$this->params=$params;
		if($_GET['iip']) {
			$_SESSION['Am_itinpage']=$_GET['iip'];
		}
		if($_POST['iip']) {
			$_SESSION['Am_itinpage']=$_POST['iip'];
		}
		if($_SESSION['Am_itinpage']==null)
			$_SESSION['Am_itinpage']=$params->itemsinpage;
		/* Items in page block End. */
	}
	function view($page=null,$id=null) {
		if($page==null) $page=$_SESSION['Am_page']=$_SESSION['Am_page']!=null ? $_SESSION['Am_page'] : 1 ;
		$limits=pages::query($page);
		//$query="SELECT * FROM `amounts` WHERE `userid`=$_SESSION[userID]".($id!=null ? " `id`=$id" : '')." ORDER BY `id` DESC $limits;";
		/*$query=array(
			'tb'=>$this->table,//'amounts',
			'wh'=>array('userid'=>$_SESSION['userID'])
		);
		if($id!=null)
			$query['wh']['id']=(int)$id;
		$q=$this->db->getRow($query);*/
		$col=array('userid');
		$val=array($_SESSION['userID']);
		if($id!=null) {
			array_push($col, 'id');
			array_push($val, $id);
		}
		$this->db->orderby='`id` ASC';
		$this->db->limits=$limits;
		unset($limits);
		$q=$this->db->select($this->table,$col,$val);
		$this->page=$page;
		if($id==null) $this->pages=pages::count($this->table,$_SESSION['Am_itinpage'],'`userid`='.$_SESSION['userID']);
		return $q;
	}
	function add() {
		$name=$_POST['name'];
		$date=$_POST['date'];
		$descr=$_POST['description'];
		$income=$_POST['income'];
		$expense=$_POST['expense'];
		$table='amounts';
		$cols=array('title','date','description','income','expense','userid');
		$vals=array($name,$date,$descr,$income,$expense,$_SESSION['userID']);
		$this->db->insert($table,$cols,$vals);
		return 'Item has been added';
	}
	function delete($id=null) {
	//	$id=$_GET['odn'];
		$id1=$id;
		$this->db->query("ALTER TABLE `amounts` AUTO_INCREMENT = 1");
		$lol=$this->db->delete('amounts','id',$id);
		$lol=$this->db->select('amounts','id>$id1');
		if($lol)
		while($mq=mysql_fetch_assoc($lol)) {
			$id=$mq['id'];
			$this->db->update('amounts','`id`=$id-1',null,'`id`=$id');
		}
		$id=(int)$id;
		$this->db->query("ALTER TABLE `amounts` AUTO_INCREMENT = $id");
		return '<i>Selected item has successfully deleted</i>';
	}
	function edit($id=null) {
		$name=$_POST['name'];
		$date=$_POST['date'];
		$descr=$_POST['description'];
		$income=$_POST['income'];
		$expense=$_POST['expense'];
		$table='amounts';
		$cols=array('title','date','description','income','expense','userid');
		$vals=array($name,$date,$descr,$income,$expense,$_SESSION['userID']);
		$this->db->update($table,$cols,$vals);
		return 'Item has been added';
	}
}