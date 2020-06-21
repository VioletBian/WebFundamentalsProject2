<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/src/php/config.php');
//session_start();
$userFound = false;
if (isset($_POST['username'])){
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select Username, Pass, Salt from traveluser";
        $result = $pdo->query($sql);
        while ($row = $result->fetch()) {
            if($_POST['username'] == $row['Username']) {
                $userFound = true;
                $salt2 = "'".$row['Salt']."'";
//                echo "<script>console.log('".$salt2."')</script>";
                $pass = "'".$_POST['password']."'";
                $salt1 = "'".Hashsalt1($pass)."'";
                $finalpasss = "'".md5($salt2.$pass.$salt1)."'";
                if (isset($_POST['password']) && $finalpasss == "'".$row['Pass']."'"){
//                    $_SESSION['Username']=$_POST['username'];
                    setcookie("User", $_POST['username'], $expiryTime,"/");
                    header("Location: http://".$_SERVER['HTTP_HOST']."/index.php");
                }
                else {
                    header("Location: http://".$_SERVER['HTTP_HOST']."/src/html/login.php"."?login=wrongpass");
//                echo "1".$_POST['password'].":".$_POST['username'];
                    break;
                }
            }

        }
        $pdo = null;

        if (!$userFound) header("Location: http://".$_SERVER['HTTP_HOST']."/src/html/login.php"."?login=wronguser");

    }
    catch (PDOException $e) {
        die($e->getMessage());
    }
}
function Hashsalt1($password) {
    $x  = "";
    $saltFromPass = "";
    for($i = strlen($password)-1; $i >= 0; $i--){
        $x .= substr($password,$i,1);
        $saltFromPass .= $x;
    }
    // 1号盐：（倒递增记字符串）的前五位的 md5 哈希
    $salt = md5(substr($saltFromPass,0,5));
    return $salt;
}

?>