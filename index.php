<?php session_start();?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Welcome To Projectouriscenary</title>
    <!-- <link rel="stylesheet" href="css/nav.css"> -->
    <link rel="stylesheet" href="src/css/home.css">
    <script src='src/js/jquery-3.5.1.js'></script>
    <script src='src/js/vue.js'></script>
</head>

<body>
    <nav class="light" id='nav' style="opacity: 0.8;">
        <ul>
            <nav_left></nav_left>
            <component v-bind:is="whichcomp"></component>
            <skin_changer></skin_changer>


        </ul>
    </nav>
    <div class="top-image">
        <img src="images/top_image.jpg">
    </div>
    <div class="hot-images">
        <ul>
            <?php
            require_once("src/php/config.php");
            try {
                $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $queryFavor = "SELECT F.ImageID, COUNT(F.ImageID), I.PATH, I.Title, I.Description FROM travelimagefavor AS F, travelimage AS I WHERE F.ImageID = I.ImageID GROUP BY F.ImageID ORDER BY COUNT(F.ImageID) DESC";
                $result = $pdo->query($queryFavor);
                for ($j = 0; $j < 6; $j++){
                    $row = $result->fetch();
                    $id = $row["ImageID"];
                    $tit = $row["Title"];
                    $des = $row["Description"];
//                    echo <<< html
//                    <a href='src/html/detail.php?ImageID=$id'><li class='hot1' id=$j><div class= 'description'><h2>$tit</h2><p>$des</p></div></li></a>
// html;
                    echo "<a href='src/html/detail.php?ImageID=".$row["ImageID"]."'><li class='hot1' id='".$j."'><div class= 'description'>";
                    echo "<h2>$tit</h2><p>$des</p></div></li></a>";
//                        .$row["Title"]."</h2>
//                        <p>".$row["Description"]."</p>
//                    </div>
//                </li>
//                </a>";
                    echo "<script>document.getElementById(" .$j. ").style = 'background-image: url(/images/normal/medium/" . $row['PATH'] . ");';</script>";
                }
                $pdo = null;
            }
            catch (PDOException $e) {
                die($e->getMessage());
            }




            ?>
            <div class="clearboth"></div>
        </ul>
    </div>

    <footer id="footer"></footer>

    <div class="float-button" id="float_button"></div>
    <script src='src/js/nav&footer.js'></script>
    <script src='src/js/change_skin.js'></script>
    <script src='src/js/float_button.js'></script>


    <?php
    if (isset($_SESSION['refresh'])){
        for ($j = 0; $j < 6; $j++){
            $desc = str_replace("\"","'",$_SESSION['descriptions'][$j]);
            $titl =  str_replace("\"","'",$_SESSION['titles'][$j]);
            echo "<script> var hot = document.getElementById(" .$j. ");
            var title = \"".$_SESSION['titles'][$j]."\";
            hot.style = 'background-image: url(/images/normal/medium/" . $_SESSION['refresh'][$j] . ")';
            hot.parentNode.href = 'src/html/detail.php?ImageID=".$_SESSION['ids'][$j]."';
            hot.getElementsByTagName('h2').item(0).innerText = \"". $titl. "\";
            hot.getElementsByTagName('p').item(0).innerText = \"". $desc. "\";
            </script>";
//            echo <<<html
//            $desc";</script>";
//html;

        }
        unset($_SESSION['refresh']);
        unset($_SESSION['ids']);
        unset($_SESSION['titles']);
        unset($_SESSION['descriptions']);
    }
    ?>


</body>
</html>