<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Signup Projectouriscenary</title>
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/base/toastr.min.css">

    <script src='../../src/js/jquery-3.5.1.js'></script>
    <script src='../../src/js/vue.js'></script>
    <script src="../js/signup.js"></script>
    <script>

    </script>

</head>

<body>

    <main>
        <div class="bg"></div>

        <div id="sign_in_out">
            <div class="window">
                <div class='wrap'>
                    <div class="tab_menu">
                        <a href="signup.php" class=selected>Signup</a>
                        <a href="login.php" >Login</a>
                    </div>
                    <form id="signup_form"  class="" action="signup.php" method="POST">
                        <p> <input type="text" name="username"  placeholder="Your username"
                                maxlength="100" required id="id_username" pattern="^[a-zA-Z]{1}[a-zA-Z0-9_.]{3,15}$"
                                   oninvalid="setCustomValidity('UserName must be 4~16 digits beginning with a letter. Underscores and dots are allowed.')" oninput="setCustomValidity('')">

                        </p>
                        <p> <input type="text" name="email"  placeholder="Your email"
                                    maxlength="100" required id="id_email" pattern="^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$"
                                   oninvalid="setCustomValidity('Email required is invalid')" oninput="setCustomValidity('')"></p>
                        <p> <input type="password" name="password" placeholder="Password" required id="password">
                            <span class="red" id="A">Pass Strength</span>
                        <table height="8" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#EEEEEE" style="border-collapse:collapse;">
                            <tr>
                                <td bgcolor="#EEEEEE" width="1" align="center" valign="middle" id="B"></td>
                            </tr>
                        </table>
                        </p>

                        <p> <input type="password" name="confirm_password" placeholder="Confirm password" required id="confirm_password">
                        </p>

                        <div>
<!--                            <button class="sign_in_button button-green"  value="Signup"  id="sub">Signup</button>-->
                            <button type='submit' class="sign_in_button button-green"  value="Signup"  id="sub">Signup</button>

                        </div>
                    </form>
                </div>
                <div class='have-account'>
                    <a href="login.php">Already have an account?</a>
                </div>
            </div>
        </div>
    </main>
</body>
<?php
function validLogin(){
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    //very simple (and insecure) check of valid credentials.
    $sql = "SELECT * FROM traveluser WHERE UserName=:user";

    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user',$_POST['username']);
    $statement->execute();
    $pdo = null;
    if($statement->rowCount()>0){
        echo "<script>console.log('F')</script>";
        return false;
    }
    echo "<script>console.log('T')</script>";
    return true;
}

require_once dirname(__FILE__).'/'.'../php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(validLogin()){
        echo "<script>console.log('ttt')</script>";
        $email = "'".$_POST['email']."'";
        $username = "'".$_POST['username']."'";
        $pass = "'".$_POST['password']."'";
        $date = "'".date('Y-m-d H:\i:\s')."'";
        $salt1 = "'".Hashsalt1($pass)."'";
        $salt2 = "'".Hashsalt2()."'";
        $finalpasss = "'".md5($salt2.$pass.$salt1)."'";
        $insertSQL = "INSERT INTO `traveluser` (`Email`, `UserName`,`Pass`,`State`,`Salt`) VALUES
($email,$username,$finalpasss,1,$salt2)";
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->exec($insertSQL);
        // add 1 day to the current time for expiry time
//        $expiryTime = time()+60*60*24;
//        setcookie("User", $_POST['username'], $expiryTime,"/");
        echo "<script>fnCreateAlert('Successfully signed up, go to login!',true);</script>";
        $pdo = null;
    }
    else{
        echo "<script>console.log('fff')</script>";
        echo "<script>fnCreateAlert('UserName has been occupied.',false);</script>";

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
// 2号盐，随机生成的存在数据库的。
function Hashsalt2(){
    $intermediateSalt = md5(uniqid(rand(mt_rand(),true)));
    $salt = substr($intermediateSalt, 0, 6);
    $salt = substr(md5($salt),0,6);
    return $salt;
}
?>
<footer id="footer">
    <p>备案号：苏ICP备20030033号
        <br>
        All rights reserved.
        <br>
        Email:18307110428@fudan.edu.cn
        <br>
        <img src="../../images/2071584682073.jpg" width=80px height=80px>
    </p>
</footer>
<script type="text/javascript" src="http://libs.baidu.com/jquery/2.0.3/jquery.min.js"></script>


</html>