<?php session_start();
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Search Projectouriscenary</title>
    <link rel="stylesheet" href="../css/search.css">
    <script src='../../src/js/jquery-3.5.1.js'></script>
    <script src='../../src/js/vue.js'></script>
</head>

<body>
    <nav class="sky" id='nav' style="opacity: 0.8;">
        <ul>
            <nav_left></nav_left>
            <component v-bind:is="whichcomp"></component>
            <skin_changer></skin_changer>
        </ul>
    </nav>
    <main>
        <div class="search-block" id='aside'>
            <form name="form1" action="/src/php/Search/singleSearch.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Search</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td><button type="submit" id="submit">Filter</button></td>
                    </tr>

                </tfoot>
                <tbody>

                        <tr>
                            <td>
                                <input type="radio" name="filter-way" value="by-title" required><span>&nbsp Filter by
                                    title</span>

                            </td>
                        </tr>
                        <tr>
                            <td><input name="filter-input" class="filter-input" type='text'></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="filter-way" value="by-description" required><span>&nbsp Filter by
                                    description</span></td>
                        </tr>
                        <tr>
                            <td><textarea type="text" name="filter-input"
                                    class="filter-input description" style=""></textarea>
                            </td>
                        </tr>

                </tbody>
            </table>
            </form>
        </div>

        <section class="result-block">
            <table>
                <thead>
                    <tr>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center">
                            <svg id='placeholder' t="1591878697641" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6001" width="200" height="200"><path d="M855.6 427.2H168.5c-12.7 0-24.4 6.9-30.6 18L4.4 684.7C1.5 689.9 0 695.8 0 701.8v287.1c0 19.4 15.7 35.1 35.1 35.1H989c19.4 0 35.1-15.7 35.1-35.1V701.8c0-6-1.5-11.8-4.4-17.1L886.2 445.2c-6.2-11.1-17.9-18-30.6-18zM673.4 695.6c-16.5 0-30.8 11.5-34.3 27.7-12.7 58.5-64.8 102.3-127.2 102.3s-114.5-43.8-127.2-102.3c-3.5-16.1-17.8-27.7-34.3-27.7H119c-26.4 0-43.3-28-31.1-51.4l81.7-155.8c6.1-11.6 18-18.8 31.1-18.8h622.4c13 0 25 7.2 31.1 18.8l81.7 155.8c12.2 23.4-4.7 51.4-31.1 51.4H673.4zM819.9 209.5c-1-1.8-2.1-3.7-3.2-5.5-9.8-16.6-31.1-22.2-47.8-12.6L648.5 261c-17 9.8-22.7 31.6-12.6 48.4 0.9 1.4 1.7 2.9 2.5 4.4 9.5 17 31.2 22.8 48 13L807 257.3c16.7-9.7 22.4-31 12.9-47.8zM375.4 261.1L255 191.6c-16.7-9.6-38-4-47.8 12.6-1.1 1.8-2.1 3.6-3.2 5.5-9.5 16.8-3.8 38.1 12.9 47.8L337.3 327c16.9 9.7 38.6 4 48-13.1 0.8-1.5 1.7-2.9 2.5-4.4 10.2-16.8 4.5-38.6-12.4-48.4zM512 239.3h2.5c19.5 0.3 35.5-15.5 35.5-35.1v-139c0-19.3-15.6-34.9-34.8-35.1h-6.4C489.6 30.3 474 46 474 65.2v139c0 19.5 15.9 35.4 35.5 35.1h2.5z" p-id="6002" fill="#5a5252e0"></path></svg>
                            <ul>
                                <?php
                                // 分页输出代码
                                $pageSize = 9;
                                if (isset($_SESSION['search']['Title'])){
                                    $sess = $_SESSION['search'];
                                    $totalCount = $sess['Count'];
                                    if($totalCount != 0) echo "<script>document.getElementById('placeholder').style = 'display:none';</script>";
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
                                }

                                function output($start,$endNotIn){
                                    for ($k = $start; $k < $endNotIn; $k++){
                                        $img = "<img src='/images/normal/medium/".$_SESSION['search']['PATH'][$k]."'>";
                                        $ahref= "<a href='detail.php"."?ImageID=".$_SESSION['search']['ImageID'][$k]."'>";
                                        echo "<li><table><tr><td rowspan=\"2\" class=\"result-img\">".$ahref.$img."</a></td><th>".$_SESSION['search']['Title'][$k]."</th></tr><tr><td class='description'>".$_SESSION['search']['Description'][$k]."</td></tr></table></li>";
                                    }

                                }



                                ?>
<!--                                <li>-->
<!--                                    <table>-->
<!--                                        <tr>-->
<!--                                            <td rowspan="2" class="result-img 1"><a href="detail.php"><img src="../../images/normal/small/9505897492.jpg"></a></td>-->
<!--                                            <th>Title</th>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td class="description">Welcome to the Fundamentals of Web Development. This textbook is-->
<!--                                                intended to cover the broad range of topics required for modern web-->
<!--                                                development and is suitable for intermediate to upper-level computing-->
<!--                                                students. A significant percent-age of the material in this book has-->
<!--                                                also been used by the authors to teach web development principles to-->
<!--                                                first-year computing students and to non-computing students as well. So-->
<!--                                                these words are absolutely, totally, nonsense. If you are lucky enough to see this line, it means your screen is indeed a great one.-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                    </table>-->
<!---->
<!--                                </li>-->
                            </ul>
                        </td>
                    </tr>


                </tbody>
                <tfoot>
                <tr>
                    <td>
                        <blockquote>
                            <?php

                            if (isset($_SESSION['search']['Title'])){
                                if ($totalCount <= $pageSize){
                                    echo "<a href='search.php' class='highlight'>1</a>";
                                }else {
                                    // 前几页index: 9currentPage-9 ~ 9*currentPage-1 末页index: 9*totalPage - 9 ~ count
                                    if ($sess['totalPage'] > 5) pages(5);
                                    else pages($sess['totalPage']);
                                    echo "<script>var current = document.getElementById('page".$sess['currentPage']."');
                                        current.classList.add('highlight');
                                        </script>";
                                }
                            }
                            function pages($totalPage){
                                $urlPart = '/src/php/DisPlay/jumpPage.php';
                                echo "<a href='/src/php/Display/toPreviousPage.php'>&lt&lt</a>";
                                for ($p = 1; $p <= $totalPage; $p++){
                                    echo "<a href='".$urlPart."?".$p."' id='page".$p."'>".$p."</a>";
                                }
                                echo "<a href='/src/php/Display/toNextPage.php'>&gt&gt</a>";
                            }


                            ?>
                        </blockquote>
                    </td>
                </tr>
                </tfoot>
            </table>


        </section>

    </main>




</body>

<footer id="footer"></footer>
<div class="float-button">
    <ul>
        <li><a id="unfold""><svg id='unfold-logo' t=" 1586273115456" class="icon down" viewBox="0 0 1024 1024" version="1.1"
                xmlns="http://www.w3.org/2000/svg" p-id="2487">
                <path
                    d="M684.691107 434.776198 513.02433 604.484368 341.355505 434.776198c-11.850909-11.713786-31.06553-11.713786-42.916439 0-11.850909 11.716856-11.850909 30.711466 0 42.427298l193.126532 190.918237c11.850909 11.713786 31.06246 11.713786 42.916439 0l193.124486-190.918237c11.850909-11.716856 11.850909-30.711466 0-42.427298C715.756637 423.062412 696.540993 423.062412 684.691107 434.776198zM513.49812 63.075571c-246.687402 0-446.664969 199.980637-446.664969 446.664969S266.810718 956.405509 513.49812 956.405509c246.684332 0 446.664969-199.980637 446.664969-446.664969S760.182452 63.075571 513.49812 63.075571zM513.49812 900.5729c-215.851093 0-390.83236-174.981267-390.83236-390.83236S297.647027 118.90818 513.49812 118.90818s390.83236 174.981267 390.83236 390.83236S729.349213 900.5729 513.49812 900.5729z"
                    p-id="2488"></path></svg>
            </a>
        </li>
    </ul>
</div>
<script src='../js/nav&footer.js'></script>
<script src='../js/unfold.js'></script>
<script src='../js/change_skin.js'></script>
<script src="../js/search.js"></script>

</html>