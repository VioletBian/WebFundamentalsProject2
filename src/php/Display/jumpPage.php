<?php session_start();
$i = $_SERVER['QUERY_STRING'];
$_SESSION['search']['currentPage'] = $i;
echo $i;
header("Location: " . $_SERVER['HTTP_REFERER']);
?>