<?php session_start();
if(isset($_SESSION['search'])){
    $now = $_SESSION['search']['currentPage'];
    if ($now != 1) $_SESSION['search']['currentPage'] = $now-1;
}
header("Location: " . $_SERVER['HTTP_REFERER']);
?>