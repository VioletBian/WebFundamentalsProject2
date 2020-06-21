<?php
$pattern = "/^ImageID=(\d+)$/i";
preg_match($pattern, $_SERVER['QUERY_STRING'], $matches);
require_once dirname(__FILE__).'/'.'../config.php';

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $User = $_COOKIE['User'];
    $sql = "INSERT INTO `travelimagefavor` (`ImageID`, `UID`) VALUES
($matches[1],(SELECT UID from traveluser where UserName = '$User'))";

    if($num=$pdo->exec($sql)){
        echo "成功添加{$num}行!";
    }else{
        echo '添加失败!';
    }


    $pdo = null;
} catch (PDOException $e) {
    die($e->getMessage());
}

header("Location: " . $_SERVER['HTTP_REFERER']);
?>