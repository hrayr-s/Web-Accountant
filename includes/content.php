<?php
class Content {
	private $ajax 	= null;
	public $html 	= null;
	function __construct() {
		$this->ajax=new Ajax;
		$this->html='';
		$this->addStyles("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css");
		$this->addStyles("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css");
		$this->addStyles("https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css");
		$this->addStyles("media/bootstrap/dist/css/bootstrap.min.css");
		$this->addStyles("media/bootstrap/build/css/bootstrap-datetimepicker.min.css");
		$this->addStyles("media/bootstrap/dist/css/tether-theme-arrows-dark.min.css");
		$this->addStyles("media/bootstrap/dist/css/tether-theme-arrows.min.css");
		$this->addStyles("media/bootstrap/dist/css/tether-theme-basic.min.css");
		$this->addStyles("media/bootstrap/dist/css/tether.min.css");
		$this->addStyles("css/theme.css");
		$this->addScripts("media/jquery.js");
		$this->addScripts("media/main.js");
		$this->addScripts("media/bootstrap/dist/js/tether.min.js");
		$this->addScripts("media/moment.js");
		$this->addScripts("media/bootstrap/dist/js/bootstrap.min.js");
		$this->addScripts("media/bootstrap/build/js/bootstrap-datetimepicker.min.js");
	}
	public function getDoc($data) {
		global $system,$styles,$scripts,$sendHeaders;
		if($sendHeaders) exit();
		system::header();
		echo '<div id="content">';
		echo $this->ajax->cookingHtml($data);
		echo '</div>';
		system::footer();
	}
	public function addStyles($url) {
		global $styles,$config;
		$http=strripos( $url,'http');
		$https=strripos( $url ,'https');
		if($http===0 || $https===0)
			$styles.="<link href='$url' rel='stylesheet' type='text/css' />";
		else{
			if(strripos($url,'/')===0)
				$styles.="<link href='$config->sitePath$url' rel='stylesheet' type='text/css' />";
			else
				$styles.="<link href='$config->sitePath/$url' rel='stylesheet' type='text/css' />";
		}
	}
	public function addScripts($url) {
		global $scripts,$config;
		$http=strripos( $url,'http');
		$https=strripos( $url ,'https');
		if($http===0 || $https===0)
			$scripts.='<script type="text/javascript" src="'.$url.'"></script>';
		else {
			if(strripos($url,'/')===0)
				$scripts.='<script type="text/javascript" src="'.$config->sitePath.$url.'"></script>';
			else
				$scripts.='<script type="text/javascript" src="'.$config->sitePath.'/'.$url.'"></script>';
		}
	}
}