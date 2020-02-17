<?php
$_SESSION['login']=false;
global $config;
header("Location: $config->sitePath");