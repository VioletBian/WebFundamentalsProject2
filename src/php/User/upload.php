<?php
require_once dirname(__FILE__).'/'.'../config.php';
$fileName = "";
if(isset($_FILES["file"]))
{
    $ret = array();
    $uploadDir = 'images/normal/medium/';
    $dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$uploadDir;
    // 如果有，就算了。没有就写入。
    file_exists($dir) || (mkdir($dir,0777,true) && chmod($dir,0777));
    if(!is_array($_FILES["file"]["name"])) //single file
    {
        $fileName = $_FILES["file"]["name"];
        move_uploaded_file($_FILES["file"]["tmp_name"],$dir.$fileName);
        $ret['file'] = DIRECTORY_SEPARATOR.$uploadDir.$fileName;
    }
    echo json_encode($ret);
}
if(isset($_POST['title'])){
//    echo "<script>console.log(\"?????\")</script>";
    try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $UID = "(SELECT UID from traveluser where UserName = '".$_COOKIE['User']."')";
        $ctry = $_POST['country'];

        $Country = <<< cty
(SELECT ISO from geocountries where CountryName = '$ctry')
cty;


        $citi = str_replace("'","\'",$_POST['city']);
        $City = <<< city
            (SELECT a.GeoNameID from geocities as a, $Country as b where a.AsciiName = "$citi" and a.CountryCodeISO = b.ISO )
city;

        $Title = $_POST['title'];
        $Description = $_POST['description'];
        $Theme = strtolower($_POST['theme']);
        $Path = $fileName;


        $sql = <<<sql
  insert into  `travelimage` (`Title`, `Description`, `PATH`,`Content`,`UID`,`CountryCodeISO`,`CityCode`) values ('$Title','$Description','$Path','$Theme',$UID,$Country,$City)
sql;
        $result = $pdo->query($sql);
        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
?>


