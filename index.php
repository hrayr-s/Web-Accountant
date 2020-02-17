<?php
session_start();
define("_root",__DIR__);
define("_Ready",true);
include_once _root.'/includes/defines.php';
if(!empty($_SESSION['login'])) {
	include_once 'includes/system.php';
	$system = new system();
	exit;
}
if(!empty($_POST['login'])) {
	include_once 'includes/system.php';
	if(system::check_up($_POST['l'],$_POST['p'])) {
		$_SESSION['login']=true;
		header("Location: index.php");
		echo "success";
		exit;
	}
	else
		$err="Login Error, check your Login or Password";
}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Amount History - Please  Login!</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" crossorigin="anonymous"></script>
	<link href="css/theme.css" rel="stylesheet" type="text/css">
	<script src="media/jquery.js"></script>
</head>
<body>
	<div id="error" style="display:<?php echo !empty($err) ? 'block' : 'none' ?>;">
		<p><?=(!empty($err) ? $err : '')?></p>
	</div>
	<div class="oneform">
		<form action="" method="post">
			<div class="form-group">
				<input type="login" class="form-control" name="l" placeholder="Input login here" value="<?=$_POST['l']?>">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="p" placeholder="Input Password here" min=6>
			</div>
			<div class="form-group">
				<input type="submit" class="form-control" name="login" value="Login">
			</div>
		</form>
	</div>
</body>
</html>