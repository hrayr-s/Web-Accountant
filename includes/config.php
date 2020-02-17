<?php
class config {
	var $dbname=null;
	var $dbuser=null;
	var $dbpass=null;
	var $dbhost=null;
	var $dbcon=null;
	var $sitePath=null;
	function __construct() {
		$this->dbname='ch32665_b2';
		$this->dbpass='Localisation';
		$this->dbuser='ch32665_b2';
		$this->dbhost='localhost';
		$this->sitePath='/ah';
		$this->dbcon=new mysqli($this->dbhost,$this->dbuser,$this->dbpass,$this->dbname) or die("Error");
		$this->dbcon->query("SELECT * FROM `users`");
	}
}