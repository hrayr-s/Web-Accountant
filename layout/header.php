<?php global $styles,$scripts; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?=$metadatas?>
	<title>Amounts-<?=$page?></title>
	<?php /*<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="media/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="media/bootstrap/build/css/bootstrap-datetimepicker.min.css" />
  <link rel="stylesheet" href="media/bootstrap/dist/css/tether-theme-arrows-dark.min.css" />
  <link rel="stylesheet" href="media/bootstrap/dist/css/tether-theme-arrows.min.css" />
  <link rel="stylesheet" href="media/bootstrap/dist/css/tether-theme-basic.min.css" />
  <link rel="stylesheet" href="media/bootstrap/dist/css/tether.min.css" />
	<link href="css/theme.css" rel="stylesheet" type="text/css">*/ ?>
	<?php echo $styles ?>
	<?php /*<script src="media/jquery.js"></script>
	<script src="media/main.js"></script>
	  <!-- ... -->
  <script type="text/javascript" src="media/bootstrap/dist/js/tether.min.js"></script>
  <script type="text/javascript" src="media/moment.js"></script>
  <script type="text/javascript" src="media/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="media/bootstrap/build/js/bootstrap-datetimepicker.min.js"></script>*/ ?>
	<?php echo $scripts ?>
</head>
<body <?php echo $battr ?>>
<div id="header">
	<div class="home scenter nav <?php echo ($_GET[option]=='Home' ? '' : 'menu')?>">
		<div id="add"><a href="<?php echo seo::route("?option=Amounts&action=add")?>"><i class="fa fa-file-text-o"></i><p>Add</p></a></div>
		<div id="view"><a href="<?php echo seo::route("?option=Amounts")?>"><i class="fa fa-list"></i><p>View</p></a></div>
		<div id="profile"><a href="<?php echo seo::route("?option=profile")?>"><i class="fa fa-user"></i><p>Profile</p></a></div>
		<div id="exit"><a href="<?php echo seo::route("?option=exit")?>" data-ajax="0"><i class="fa fa-sign-out"></i><p>Exit</p></a></div>
	</div>
</div>