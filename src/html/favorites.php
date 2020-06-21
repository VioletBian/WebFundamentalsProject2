<?php
session_start();
require_once dirname(__FILE__).'/'.'../php/config.php';

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select a.ImageID, a.Title, a.Description, a.PATH from travelimage as a, traveluser as b, travelimagefavor as c where c.UID = b.UID and c.ImageID = a.ImageID and b.UserName ='".$_COOKIE['User']."'";
    $result = $pdo->query($sql);
    $_SESSION['favorites'] = array();
    $_SESSION['favorites']['ImageID'] = array();
    $_SESSION['favorites']['PATH'] = array();
    $_SESSION['favorites']['Title'] = array();
    $_SESSION['favorites']['Description'] = array();
    $_SESSION['favorites']['Count'] = 0;
    $_SESSION['favorites']['currentPage'] = 1;

    while ($row = $result->fetch()) {
        $count = $_SESSION['favorites']['Count'];
        $_SESSION['favorites']['ImageID'][$count] = $row['ImageID'];
        $_SESSION['favorites']['PATH'][$count] = $row['PATH'];
        $_SESSION['favorites']['Title'][$count] = $row['Title'];
        $_SESSION['favorites']['Description'][$count] = $row['Description'];
        $_SESSION['favorites']['Count'] ++;
    }



    $pdo = null;
} catch (PDOException $e) {
    die($e->getMessage());
}


?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Favorite Projectouriscenary </title>
    <link rel="stylesheet" href="../css/favorites.css">
    <script src='../../src/js/jquery-3.5.1.js'></script>
    <script src='../../src/js/vue.js'></script>
</head>

<body>
    <nav class="dark" id='nav' style="opacity: 0.8;">
        <ul>
            <nav_left></nav_left>
            <component v-bind:is="whichcomp"></component>
            <skin_changer></skin_changer>
        </ul>
    </nav>
    <main>

        <div class="">
            <ul id="my-photos">
                <li class="headline">My favorites</li>
                <li class="placeholder headline" id="placeholder">
                    Empty here, favor pictures now!
                    <svg  t="1591878697641" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6001" width="200" height="200"><path d="M855.6 427.2H168.5c-12.7 0-24.4 6.9-30.6 18L4.4 684.7C1.5 689.9 0 695.8 0 701.8v287.1c0 19.4 15.7 35.1 35.1 35.1H989c19.4 0 35.1-15.7 35.1-35.1V701.8c0-6-1.5-11.8-4.4-17.1L886.2 445.2c-6.2-11.1-17.9-18-30.6-18zM673.4 695.6c-16.5 0-30.8 11.5-34.3 27.7-12.7 58.5-64.8 102.3-127.2 102.3s-114.5-43.8-127.2-102.3c-3.5-16.1-17.8-27.7-34.3-27.7H119c-26.4 0-43.3-28-31.1-51.4l81.7-155.8c6.1-11.6 18-18.8 31.1-18.8h622.4c13 0 25 7.2 31.1 18.8l81.7 155.8c12.2 23.4-4.7 51.4-31.1 51.4H673.4zM819.9 209.5c-1-1.8-2.1-3.7-3.2-5.5-9.8-16.6-31.1-22.2-47.8-12.6L648.5 261c-17 9.8-22.7 31.6-12.6 48.4 0.9 1.4 1.7 2.9 2.5 4.4 9.5 17 31.2 22.8 48 13L807 257.3c16.7-9.7 22.4-31 12.9-47.8zM375.4 261.1L255 191.6c-16.7-9.6-38-4-47.8 12.6-1.1 1.8-2.1 3.6-3.2 5.5-9.5 16.8-3.8 38.1 12.9 47.8L337.3 327c16.9 9.7 38.6 4 48-13.1 0.8-1.5 1.7-2.9 2.5-4.4 10.2-16.8 4.5-38.6-12.4-48.4zM512 239.3h2.5c19.5 0.3 35.5-15.5 35.5-35.1v-139c0-19.3-15.6-34.9-34.8-35.1h-6.4C489.6 30.3 474 46 474 65.2v139c0 19.5 15.9 35.4 35.5 35.1h2.5z" p-id="6002" fill="#5a5252e0"></path></svg>

                </li>
            </ul>
            <ul>

                <?php

                function output($start,$endNotIn){
                    for ($k = $start; $k < $endNotIn; $k++){
                        $title = $_SESSION['favorites']['Title'][$k];
                        $description = $_SESSION['favorites']['Description'][$k];
                        $query = "?ImageID=".$_SESSION['favorites']['ImageID'][$k]."\"";
                        $img = "<a href=\"detail.php?ImageID=".$_SESSION['favorites']['ImageID'][$k]."\"><img src=\"/images/normal/medium/".$_SESSION['favorites']['PATH'][$k]."\"></a>";
                        $btns = <<< bt
<span class='btns'>                   <button id="undo-favor"><a href="/src/php/User/unfavor.php$query"><svg
                                    t="1585331001715" class="icon" viewBox="0 0 1024 1024" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" p-id="3378" width="20px" height="20px">
                                    <path
                                        d="M887.7 380.2L693 331.4c-3.6-0.9-6.7-3.2-8.7-6.3l-106.5-170c-4.6-7.3-10.8-13.5-18.1-18.1-26.8-16.8-62.2-8.7-79 18.1L374 325.2c-2 3.1-5.1 5.4-8.7 6.3l-194.7 48.8c-8.4 2.1-16.2 6.1-22.9 11.7-24.3 20.3-27.5 56.5-7.2 80.8l33.6 40.2 42.6 3.8c201.6 18 379.4 143.6 464 327.9l18.9 41.1 21 8.4c8 3.2 16.7 4.6 25.4 4 31.6-2.2 55.4-29.5 53.3-61.1l-13.8-200.2c-0.3-3.7 0.9-7.3 3.3-10.2l128.8-153.9c5.6-6.6 9.5-14.5 11.7-22.9 7.7-30.9-10.9-62-41.6-69.7z"
                                        p-id="3379" fill="#ffffff"></path>
                                    <path
                                        d="M213.1 559.2l56.4 67.4c2.4 2.8 3.6 6.5 3.3 10.2L259 836.9c-0.6 8.6 0.8 17.3 4 25.4 9 22.3 30.5 35.9 53.2 35.9 7.1 0 14.4-1.3 21.4-4.2l186.2-75c1.7-0.7 3.5-1 5.4-1 1.8 0 3.6 0.3 5.4 1l107.5 43.3c-76.6-166.6-238-286.1-429-303.1z"
                                        p-id="3380" fill="#ffffff"></path>
                                </svg></a></button></span>
bt;
                        $details = <<< de
    <div class="detail"><span class="title">$title</span><div class="description">$description</div>$btns</div>
de;
                        echo "<li>".$img."</a>".$details."</li>";
                    }

                }
                ?>
                <?php
                $sess = $_SESSION['favorites'];
                $pageSize = 9;
                $totalCount = $sess['Count'];
                if($totalCount != 0) echo "<script>document.getElementById('placeholder').style = 'display:none';</script>";
                echo "<script>console.log('".$sess['Count']."')</script>";
                // 单页
                // 单页
                if ($totalCount <= $pageSize){
                    $sess['totalPage'] = 1;
                    output(0,$totalCount);
                }else {
                    // 前几页index: 9currentPage-9 ~ 9*currentPage-1 末页index: 9*totalPage - 9 ~ count
                    $sess['totalPage'] = (int)(($totalCount%$pageSize==0)?($totalCount/$pageSize):($totalCount/$pageSize+1));
                    if ($sess['currentPage'] == $sess['totalPage']){
                        output($pageSize*$sess['totalPage']-$pageSize,$totalCount);
                    }else {
                        output($pageSize*$sess['currentPage']-$pageSize,$pageSize*$sess['currentPage']);
                    }

                }
                ?>




            </ul>
            <blockquote><?php


                    if ($totalCount <= $pageSize){
                        echo "<a href='favorites.php' class='highlight'>1</a>";
                    }else {
                        // 前几页index: 9currentPage-9 ~ 9*currentPage-1 末页index: 9*totalPage - 9 ~ count
                        if ($sess['totalPage'] > 5) pages(5);
                        else pages($sess['totalPage']);
                        echo "<script>var current = document.getElementById('page".$sess['currentPage']."');
                                        current.classList.add('highlight');
                                        </script>";
                    }

                function pages($totalPage){
                    $urlPart = '/src/php/Display/jumpPage.php';
                    echo "<a href='/src/php/Display/toPreviousPage.php'>&lt&lt</a>";
                    for ($p = 1; $p <= $totalPage; $p++){
                        echo "<a href='".$urlPart."?".$p."' id='page".$p."'>".$p."</a>";
                    }
                    echo "<a href='/src/php/Display/toNextPage.php'>&gt&gt</a>";
                }




                ?></blockquote>
            <div class="clearboth"></div>
        </div>


        </div>
    </main>




</body>

<footer id="footer"></footer>
<script src='../js/nav&footer.js'>ß</script>
<script src='../js/change_skin.js'></script>


</html>