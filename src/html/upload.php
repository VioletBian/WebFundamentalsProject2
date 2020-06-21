<?php session_start();
$pattern = "/^ImageID=(\d+)$/i";
$status = false;
if (isset($_SERVER['QUERY_STRING'])){
$status = preg_match($pattern, $_SERVER['QUERY_STRING'], $matches);}
$btn_id = ($status)? "btn-modify":"btn-upload";
if($status){
    require_once dirname(__FILE__).'/'.'../php/config.php';

    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select a.Title, a.Description, a.PATH, a.Content, b.CountryName, c.AsciiName from travelimage as a, geocountries as b, geocities as c 
where a.ImageID = $matches[1] and b.ISO = a.CountryCodeISO and c.GeoNameID = a.CityCode";
        $result = $pdo->query($sql);
        while ($row = $result->fetch()) {
           $title = $row['Title'];
           $description = $row['Description'];
           $path = $row['PATH'];
           $theme = $row['Content'];
           $country = $row['CountryName'];
           $city = $row['AsciiName'];
        }



        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }


}
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Upload Projectouriscenary</title>
    <link rel="stylesheet" href="../css/upload.css">
    <!-- <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/unique" type="text/css"/> -->
    <script src='../../src/js/jquery-3.5.1.js'></script>
    <script src="../../src/js/jquery.ajaxfileupload.js"></script>
    <script src='../../src/js/vue.js'></script>
    <script src='../js/city.js'></script>
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
        <span class="headline">Upload your photos!</span>
        <div class="upload-form" onclick="document.querySelector('.js-file-input').click()">
            <button class="btn browse"><?php
                echo ($status)? "Change the file":"Choose a file";
                ?></button>
        </div>
    <div class="display&info">
            <img class="display" src="<?php
             echo ($status)? "/images/normal/medium/".$path: "" ;
            ?>" alt="A Pic" id="myimg" style="<?php
            if($status) echo "display:block;";
            ?>">
            <form class="info" name="info" id="info" οnsubmit="return false;"  method="post">
                <input type="file" id="file" class="hidden js-file-input"
                       accept="image/*" enctype="multipart/form-data"
                       multiple="">
                <ul id="upload-info" style="<?php
                if($status) echo "display:block;";
                ?>">
                    <li><label>Title</label></li>
                    <li><input type="text" class="upload title txt" name="title" id="title" required value="<?php
                               if($status) echo "$title";
                               ?>">
                    </li>
                    <li><label>Description</label></li>
                    <li><textarea class="upload description txt" name="description" id="description" required style="text-align: left" ><?php
                        if($status) echo "$description";?></textarea></li>
                    <li><label>Country</label></li>
                    <select class="upload country" name="country" id="country" ></select>
                    <li><label>City</label></li>
                    <select class="upload city" name="city" id="city" ></select>
                    <li><label>Theme</label></li>
                    <select class="upload theme" name="theme" id="theme" >
                        <option value="">Choose a theme</option>
                        <option value="scenery">Scenery</option>
                        <option value="modern">Modern</option>
                        <option value="religion">Religion</option>
                        <option value="relic">Relic</option>
                        <option value="romantic">Romantic</option>
                    </select>
                    <input name="original" hidden>
                    <input  name="ImageID" class="upload" hidden>
                    <li><button class="btn" type="button" id=<?php echo $btn_id ?> name="btn-upload"><?php
                            echo ($status)? "Modify!":"Submit!";
                            ?></button>
                    </li>
                </ul>
            </form>
            <div class="clearboth"></div>
        </div>
    </div>
    </main>
</body>

<footer id="footer"></footer>
<script src='../js/nav&footer.js'></script>
<script src="../js/upload.js"></script>
<!--<script src='../js/browse.js'></script>-->
<script src='../js/change_skin.js'></script>

<script>


    var arr_country = [];
    var arr_city = [];
    for (e in city) {
        arr_country.push(e);
        arr_city.push(city[e]);
    }
    function id$(x) {
        return document.getElementById(x);
    }
    //遍历的添加国家数据
    for (var i = 0; i < arr_country.length; i++) {
        var op = document.createElement("option");
        if (i!=0)op.value = arr_country[i];
        else op.value = "";
        op.innerText = arr_country[i];
        id$("country").appendChild(op);
    }
    //设置默认值
    var on = document.createElement("option");
    on.innerText = arr_city[0][0];
    id$("city").appendChild(on);

    id$("country").onchange = function (){
        console.log("selectedIndex= " + this.selectedIndex);
        //selectedIndex表示选中的索引值
        var index = this.selectedIndex;

        //添加前先删除sp
        id$("city").innerHTML = "";
        //遍历的添加城市数据
        for (var i = 0; i < arr_city[index].length; i++) {
            var sp = document.createElement("option");
            sp.value = arr_city[index][i];
            sp.innerText = arr_city[index][i];
            id$("city").appendChild(sp);
        }
        if(id$("city").classList.contains("emptyInput"))id$("city").classList.remove("emptyInput");
    }

</script>
<?php
if ($status) {
    $city = str_replace("'","\'",$city);
    $js =  <<<js
selectByData('theme','$theme');
selectByData('country','$country');
inputs['country'].onchange();
selectByData('city','$city');
js;
    echo "<script>$js</script>";
}
?>
</html>