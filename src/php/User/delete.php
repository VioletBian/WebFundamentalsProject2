<?php
$pattern = "/^ImageID=(\d)+$/i";
preg_match($pattern, $_SERVER['QUERY_STRING'], $matches);
require_once dirname(__FILE__).'/'.'../config.php';

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "delete from travelimage where ".$matches[0]."";
//    $result = $pdo->exec($sql);
    if($num=$pdo->exec($sql)){
     echo "成功删除{$num}行!";
    }else{
        echo '删除失败!';
    }


$pdo = null;
} catch (PDOException $e) {
    die($e->getMessage());
}

header("Location: " . $_SERVER['HTTP_REFERER']);
?>