<?php
global $config,$sendHeaders;
$id=$_GET['page'];
$_SESSION['message']=$amount->delete($id);
$sendHeaders=true;
header('Location: '.seo::route('?option=Amounts'));