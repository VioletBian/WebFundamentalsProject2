<?php session_start();

require_once dirname(__FILE__).'/'.'../php/config.php';

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select a.ImageID, a.Title, a.Description, a.PATH from travelimage as a, traveluser as b where a.UID = b.UID and b.UserName ='".$_COOKIE['User']."'";
    $result = $pdo->query($sql);

        $_SESSION['my_photos'] = array();
        $_SESSION['my_photos']['ImageID'] = array();
        $_SESSION['my_photos']['PATH'] = array();
        $_SESSION['my_photos']['Title'] = array();
        $_SESSION['my_photos']['Description'] = array();
        $_SESSION['my_photos']['Count'] = 0;
        $_SESSION['my_photos']['currentPage'] = 1;

        while ($row = $result->fetch()) {
            $count = $_SESSION['my_photos']['Count'];
            $_SESSION['my_photos']['ImageID'][$count] = $row['ImageID'];
            $_SESSION['my_photos']['PATH'][$count] = $row['PATH'];
            $_SESSION['my_photos']['Title'][$count] = $row['Title'];
            $_SESSION['my_photos']['Description'][$count] = $row['Description'];
            $_SESSION['my_photos']['Count'] ++;
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
    <title>My Projectouriscenary photos</title>
    <link rel="stylesheet" href="../css/my_photos.css">
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
            <ul id="my-photos">
                <li class="headline">My photos</li>
                <li class="placeholder headline" id="placeholder">
                    Empty here, upload yours now!
                    <svg  t="1591878697641" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6001" width="200" height="200"><path d="M855.6 427.2H168.5c-12.7 0-24.4 6.9-30.6 18L4.4 684.7C1.5 689.9 0 695.8 0 701.8v287.1c0 19.4 15.7 35.1 35.1 35.1H989c19.4 0 35.1-15.7 35.1-35.1V701.8c0-6-1.5-11.8-4.4-17.1L886.2 445.2c-6.2-11.1-17.9-18-30.6-18zM673.4 695.6c-16.5 0-30.8 11.5-34.3 27.7-12.7 58.5-64.8 102.3-127.2 102.3s-114.5-43.8-127.2-102.3c-3.5-16.1-17.8-27.7-34.3-27.7H119c-26.4 0-43.3-28-31.1-51.4l81.7-155.8c6.1-11.6 18-18.8 31.1-18.8h622.4c13 0 25 7.2 31.1 18.8l81.7 155.8c12.2 23.4-4.7 51.4-31.1 51.4H673.4zM819.9 209.5c-1-1.8-2.1-3.7-3.2-5.5-9.8-16.6-31.1-22.2-47.8-12.6L648.5 261c-17 9.8-22.7 31.6-12.6 48.4 0.9 1.4 1.7 2.9 2.5 4.4 9.5 17 31.2 22.8 48 13L807 257.3c16.7-9.7 22.4-31 12.9-47.8zM375.4 261.1L255 191.6c-16.7-9.6-38-4-47.8 12.6-1.1 1.8-2.1 3.6-3.2 5.5-9.5 16.8-3.8 38.1 12.9 47.8L337.3 327c16.9 9.7 38.6 4 48-13.1 0.8-1.5 1.7-2.9 2.5-4.4 10.2-16.8 4.5-38.6-12.4-48.4zM512 239.3h2.5c19.5 0.3 35.5-15.5 35.5-35.1v-139c0-19.3-15.6-34.9-34.8-35.1h-6.4C489.6 30.3 474 46 474 65.2v139c0 19.5 15.9 35.4 35.5 35.1h2.5z" p-id="6002" fill="#5a5252e0"></path></svg>

                </li>
            </ul>
            <ul>

                <?php

                function output($start,$endNotIn){
                    for ($k = $start; $k < $endNotIn; $k++){
                        $title = $_SESSION['my_photos']['Title'][$k];
                        $description = $_SESSION['my_photos']['Description'][$k];
                        $query = "?ImageID=".$_SESSION['my_photos']['ImageID'][$k]."\"";
                        $img = "<a href=\"detail.php?ImageID=".$_SESSION['my_photos']['ImageID'][$k]."\"><img src=\"/images/normal/medium/".$_SESSION['my_photos']['PATH'][$k]."\"></a>";
                        $btns = <<< bt
<span class='btns'><button id="modify"><a href="upload.php$query><svg t="1585329550188" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2931" width="20px" height="20px"><path d="M679.51874187 662.40298719H344.48989156c-18.50297531 0-33.50240531-14.99943-33.50240531-33.50240625v-50.25456657h402.03462094v50.25456657c0 18.50297531-15.00039 33.50240531-33.50336532 33.50240625z" fill="#00D8A0" p-id="2932"></path><path d="M813.52548594 930.78966031H210.473555c-36.95414531 0-67.00576969-30.36149531-67.00577062-67.69266375V160.89437c0-37.322535 30.05162531-67.68498938 67.00577062-67.68499031h402.03462c18.50201531 0 33.50240531 15.00134906 33.50240625 33.50240531s-15.00134906 33.50240531-33.50240625 33.50240531h-402.03462V863.09699656l603.05193094 0.68689407V366.00138688c0-18.50201531 15.00134906-33.50240531 33.50336437-33.50240532s33.50240531 15.00134906 33.50240532 33.50240531V863.09699656c0 37.33116937-30.05066531 67.69266469-67.00576969 67.69266375z" fill="#ffffff" p-id="2933"></path><path d="M495.24879688 503.26800031a33.43333219 33.43333219 0 0 1-24.27634032-10.41277969c-12.74304-13.40595094-12.22019438-34.61525063 1.19439-47.36692593L815.40677 118.99957438c13.39827563-12.73536563 34.59894188-12.20388562 47.35925063 1.18575562 12.744 13.40595094 12.22019438 34.61525063-1.19439 47.36692594L518.33074813 494.04193531c-6.47848781 6.16765875-14.78837344 9.226065-23.08195125 9.226065z" fill="#ffffff" p-id="2934"></path></svg></a></button>
                    <button id="delete" ><a href="/src/php/User/delete.php$query><svg t="1585329594694" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3069" width="20px" height="20px"><path d="M735.351927 958.708971H288.647049c-37.516452 0-68.119447-30.234605-68.706824-67.633376L185.611371 273.366018c-1.057075-18.942421 13.456477-35.158754 32.398898-36.21583 19.395746-1.006933 35.166941 13.456477 36.224016 32.407084l34.361599 618.498546c0.033769 0.63752 0.050142 1.27504 0.050142 1.912559l446.704878 0.016373c0-0.63752 0.016373-1.292436 0.050142-1.929955l34.361599-618.498546c1.057075-18.959817 17.533328-33.229822 36.224016-32.407084 18.942421 1.057075 33.455973 17.273409 32.398898 36.21583L804.056706 891.074571c-0.584308 37.399795-31.188326 67.6344-68.704779 67.6344z" fill="#ffffff" p-id="3070"></path><path d="M889.980657 271.461645H134.01832c-18.97619 0-34.361599-15.385409-34.361599-34.361599s15.385409-34.361599 34.361599-34.361599h755.962337c18.97619 0 34.361599 15.385409 34.361599 34.361599s-15.384385 34.361599-34.361599 34.361599z" fill="#ffffff" p-id="3071"></path><path d="M683.814134 735.350904H340.195076v51.54291c0 18.977213 15.384385 34.361599 34.361599 34.361599h274.89586c18.977213 0 34.361599-15.384385 34.361599-34.361599V735.350904z" fill="#00D8A0" p-id="3072"></path><path d="M676.930353 271.461645c-18.97619 0-34.361599-15.385409-34.361599-34.361599v-68.724221c0-18.950607-15.419178-34.361599-34.361598-34.361599H415.776472c-18.942421 0-34.361599 15.410991-34.361599 34.361599v68.724221c0 18.97619-15.385409 34.361599-34.361599 34.361599s-34.361599-15.385409-34.361599-34.361599v-68.724221c0-56.844659 46.24116-103.08582 103.08582-103.08582H608.206132c56.844659 0 103.08582 46.24116 103.08582 103.08582v68.724221c0 18.97619-15.385409 34.361599-34.361599 34.361599z" fill="#ffffff" p-id="3073"></path></svg></a></button>
                </span>
bt;
                        $details = <<< de
    <div class="detail"><span class="title">$title</span><div class="description">$description</div>$btns</div>
de;
                        echo "<li>".$img."</a>".$details."</li>";
                    }

                }
                ?>
                <?php
                $sess = $_SESSION['my_photos'];
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
            <blockquote>
                <?php


                    if ($totalCount <= $pageSize){
                        echo "<a href='my_photos.php' class='highlight'>1</a>";
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




                ?>
            </blockquote>
            <div class="clearboth"></div>
        


        
    </main>




</body>

<footer id="footer"></footer>
<script src='../js/nav&footer.js'></script>
<!-- <script src="../js/my_photos.js"></script> -->
<script src='../js/change_skin.js'></script>


</html>