<?php
////        $id = 1;
////        $pass = 'abcd1234';
////        $salt1 = "'".Hashsalt1($pass)."'";
////        $salt2 = '5f70c2';
////        $finalpasss = "'".md5($salt2.$pass.$salt1)."'";
////echo $finalpasss;
//function Hashsalt1($password) {
//    $x  = "";
//    $saltFromPass = "";
//    for($i = strlen($password)-1; $i >= 0; $i--){
//        $x .= substr($password,$i,1);
//        $saltFromPass .= $x;
//    }
//    // 1号盐：（倒递增记字符串）的前五位的 md5 哈希
//    $salt = md5(substr($saltFromPass,0,5));
//    return $salt;
//}
//// 2号盐，随机生成的存在数据库的。
//function Hashsalt2(){
//    $intermediateSalt = md5(uniqid(rand(mt_rand(),true)));
//    $salt = substr($intermediateSalt, 0, 6);
//    $salt = substr(md5($salt),0,6);
//    return $salt;
//}
//require_once dirname(__FILE__).'/'.'../php/config.php';
//try {
//    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $sql = "select UID, Pass from traveluser";
//    $result = $pdo->query($sql);
//    while($row = $result->fetch()){
//        $id = $row['UID'];
//        $pass = "'".$row['Pass']."'";
//        $salt1 = "'".Hashsalt1($pass)."'";
//        $salt2 = "'".Hashsalt2()."'";
//        $finalpasss = "'".md5($salt2.$pass.$salt1)."'";
//        echo $finalpasss." : ".$salt2."<br>";
//        $update = "update traveluser set Pass = $finalpasss, Salt = $salt2 where UID = $id";
//        $pdo->exec($update);
//    }
//    $pdo = null;
//} catch (PDOException $e) {
//    die($e->getMessage());
//}
//?>