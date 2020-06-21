<?php
require_once dirname(__FILE__).'/'.'../config.php';
try {
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$fileName = "";
//$pattern = "/^ImageID=(\d+)$/i";
//preg_match($pattern, $_SERVER['QUERY_STRING'], $matches);
//$ID = $matches[1];
$ID = $_POST['ImageID'];
$Title = $_POST['title'];
$Description = $_POST['description'];
$ctry = $_POST['country'];
$citi = str_replace("'","\'",$_POST['city']);
$Theme = strtolower($_POST['theme']);
$Country = <<< cty
(SELECT ISO from geocountries where CountryName = '$ctry')
cty;
$City = <<< city
            (SELECT a.GeoNameID from geocities as a, $Country as b where a.AsciiName = '$citi' and a.CountryCodeISO = b.ISO )
city;
$ctry = $pdo->query($Country)->fetch()['ISO'];
$citi = $pdo->query($City)->fetch()['GeoNameID'];

if(isset($_FILES["file"]) && isset($_POST['original']))
{
    $ret = array();
    $uploadDir = 'images/normal/medium/';
    $originalPath = $_POST['original'];
    $dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$uploadDir;
    // 如果有目录，就算了。没有就写入。
    file_exists($dir) || (mkdir($dir,0777,true) && chmod($dir,0777));
    if(!is_array($_FILES["file"]["name"])) //single file
    {
        $fileName = $_FILES["file"]["name"];
        chmod($dir.$originalPath,0777);
        unlink($dir.$originalPath);
        move_uploaded_file($_FILES["file"]["tmp_name"],$dir.$fileName);
        $ret['file'] = DIRECTORY_SEPARATOR.$uploadDir.$fileName;
    }
    echo json_encode($ret);
}
 $filesql = (isset($_POST['original']) && isset($_FILES["file"]))? ", PATH = '$fileName'" : " ";
$sql = "update travelimage set Title = '$Title', Description = '$Description', CountryCodeISO = '$ctry', CityCode = '$citi', Content = '$Theme' $filesql
where ImageID= $ID";
$pdo->exec($sql);
$pdo = null;
} catch (PDOException $e) {
    die($e->getMessage());
}
?>


