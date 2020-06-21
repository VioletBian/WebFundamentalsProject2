<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Login Projectouriscenary</title>
    <link rel="stylesheet" href="../css/login.css">
    <script src='../../src/js/jquery-3.5.1.js'></script>
    <script src='../../src/js/vue.js'></script>
    <link rel="stylesheet" href="../css/base/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="../css/base/web-icons.min.css"> 

</head>

<body>

    <main>
        <div class="bg"></div>
        <div id="sign_in_out">
            <div class="window">
                <div class='wrap'>
                    <div class="tab_menu">
                        <a href="signup.php">Signup</a>
                        <a href="login.php" class="selected">Login</a>
                    </div>
                    <form id="login_form" spellcheck="false" class="" action="../php/User/loginValidCheck.php" method="post">
                        <p> <input type="text" name="username" data-autofocus="" placeholder="Username"
                                maxlength="100" required id="id_username"></p>
                        <p> <input type="password" name="password" placeholder="Password" required id="id_password">
                        </p>
                        <div>
                         <input class="sign_in_button button-green" type="submit" value="Login">
                        </div>
                    </form>
                </div>
                <div class='no-account'>
                    <a href="signup.php">Have no account?</a>
                </div>
            </div>
        </div>
    </main>
</body>

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
<script src="../js/login.js"></script>


</html>