<?php
class ajax {
	public $html = null;
	function __construct() {}
	function load_page($page=null) {
		$p = new pages();
		if($page) {
			$pINFO=$p->getPath($page);
			if($p->path==null || !file_exists(_pages.'/ajax/'.$p->path)) {
				$pINFO=$p->getPath('Error');
			}
			include_once _pages.'/ajax/'.$p->path;
		}else
		{
			$pINFO=$p->getPath("Home");
			include_once _pages.'/ajax/'.$p->path;
		}
	//	get($_GET['type']);
	}
	function cookingHtml($data) {
		if($data['html']) {
			$h=makeHtml::makeTag($data['html']);
			$this->html=$this->html!=null ? $this->html : '';
			if(!empty($_SESSION['message'])) {
				$this->html='<div class="message">'.$_SESSION['message'].'</div>';
				unset($_SESSION['message']);
			}
			$this->html.=$h;
			return $h;
		}
	}
}