<?php
final class seo {
	var $data=null;
	var $get=null;
	private function __construct() {
		global $config;
		$this->get = $get = str_replace($config->sitePath,'', $_SERVER['REQUEST_URI']);
		$this->data = explode('/',$get);
		foreach ($this->data as $k => $v) {
			$ipos=strripos($this->data[$k],'?');
			if($ipos>1)
				$this->data[$k]=substr($this->data[$k],0, $ipos);
		}
		unset($ipos);
		if($this->data[1]=="index.php" || $this->data[1]=="" || $this->data[1]==null)
			$this->data[1]="Home";
		$data=$this->data;
		if(!empty($data[1])) $_GET['option']=$data[1];
		if(!empty($data[2])) $_GET['action']=$data[2];
		if(!empty($data[3])) $_GET['page']=$data[3];
		for($i=4;!empty($data[$i]);$i++)
			$_GET[$i]=$data[$i];
	}
	public static function route($url) {
		//Edit urls from get mode to sef urls
		global $config;
		$ipos=strripos($url,'?');
		if($ipos >= 0){
			$urls= explode('?',$url);//substr($url,$ipos+1,$substr);
			foreach($urls as $k=>$v) {
				if(strripos($v,'?')>=0 && strripos($v,'?')!=null)
					continue;
				else $url=$urls[$k];
			}
			$gets=explode("&",$url);
			$out='';
			$page='';
			$action='';
			$index='';
			for($i=0;$gets[$i]!=null;$i++) {
				$v=explode('=',$gets[$i]);
				switch ($v[0]) {
					case 'option':
						$page='/'.$v[1];
						break;
					case 'action':
						$action='/'.$v[1];
						break;
					case 'page':
						$index='/'.$v[1];
						break;
					default:
						$out.= ($out=='' ? '?' : '&').$gets[$i];
						break;
				}
			}
			$out=$config->sitePath.$page.$action.$index.$out;
			unset($page);
			unset($action);
			unset($index);
			unset($gets);
			unset($ipos);
			unset($url);
			unset($v);
			unset($i);
			return $out;
		}
	}
}