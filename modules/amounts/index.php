<?php
include_once 'amount.php';
$amount = new Amount($this->params);
switch($_GET['action']) {
	case 'add':
			include_once 'add.php';
		break;
	case 'edit':
			include_once 'edit.php';
		break;
	case 'delete':
			include_once 'delete.php';
		break;
	case 'view':
	default:
			include_once 'view.php';
		break;
}
$this->data['html']=$data;