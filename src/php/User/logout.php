<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/src/php/config.php');

setcookie("User", "", -1,"/");
header("Location: http://".$_SERVER['HTTP_HOST']."/src/html/login.php");

?>