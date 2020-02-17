<?php
	$page=$this->aParams;
	$path=pages::getPath($page);
	include_once _pages.'/'.$path['path'];
	$this->data=$data;