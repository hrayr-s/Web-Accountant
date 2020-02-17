<?php
class pages {
	var $page = null;
	var $path = null;
	function __construct() {
	}
	function getPath($page) {
		global $config,$db;
		if(gettype($page)=="string") {
			//$this->page = $page;
			$db->getRow(array(
				'tb' => 'pages',
				'wh' => array(
					'name' => $page
				)
			));
			$res=$db->r;
			$res=$res->fetch_array();
			//$this->path=$res['path'];
			return $res;
		}elseif(gettype($page)=="integer") {
			$db->getRow(array(
				'tb' => 'pages',
				'wh' => array(
					'id' => $page
				)
			));
			$res=$db->r;
			$res=$res->fetch_array();
			//$this->path = $res['path'];
			//$this->page = $res['name'];
			return $res;
		}
	}
	function count($table, $it_inpg = 20, $condition=null) {	// function pages quantity $table-Where looking for, $it_inpg - items in page, $condition - Conditions 
		global $config,$db;
	//	$q=$config->dbcon->query("SELECT COUNT(*) FROM `$table`".($condition!=null ? (strpos(trim($condition), "WHERE")==0 ? $condition : 'WHERE '.$condition) : ''));
	//	$query="SELECT COUNT(*) FROM `$table` ".($condition!=null ? (strpos(trim($condition), "WHERE")===0 ? $condition : 'WHERE '.$condition) : '');
		$condition = $condition!=null ? (strpos(trim($condition), "WHERE")===0 ? str_replace('WHERE', '', $condition) : $condition) : null;
		$db->orderby='';
		$db->limits='';
		$q=$db->select($table, $condition, null, 'COUNT(*)');
	//	$db->query($query);
	//	$q=$db->r;
		$q=$q->fetch_row();
		$qan=$q[0];	//Rows quantity
		$ps=round($qan/$it_inpg, 0, PHP_ROUND_HALF_EVEN)<$qan/$it_inpg ? round($qan/$it_inpg, 0, PHP_ROUND_HALF_EVEN)+1 : round($qan/$it_inpg, 0, PHP_ROUND_HALF_EVEN);
		//$ps; Pages quantity
		//if(isset($_SESSION['pagination']))$p=$_SESSION['pagination'];else $p=$ps;
		return $ps;
	}
	function query($p,$it_inpg=20) {	// function page query constructor, $p - Selected page, $it_inpg - items in page
		$ololo=$p*$it_inpg-$it_inpg;
		$query_limit=" LIMIT ".($ololo>0 ? $ololo : 0)." , $it_inpg";
		return $query_limit;
	}
}