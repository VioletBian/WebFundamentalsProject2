<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/src/php/config.php');
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 国家-城市选了,要求三张表
    if (!!$_POST['country']) {
        $countryQuery = "  b.CountryName = '".$_POST['country']."' and c.AsciiName = '". $_POST['city']."'";
        // 主题也选了
        if (!!$_POST['theme']) {
            $themeQuery = " a.Content= '".$_POST['theme']."' ";
            $combinedQuery = $themeQuery . " and " . $countryQuery;
        } else {
            // 主题没选
            $combinedQuery = $countryQuery;
        }
        $sql = "select a.ImageID, a.PATH from travelimage as a , geocountries as b, geocities as c Where a.CityCode = c.GeoNameID AND a.CountryCodeISO = b.ISO and".$combinedQuery;
    }
    // 国家-城市没选，要求一张表
    else {
        // 主题选了
        if (!!$_POST['theme']) {
            $themeQuery = " a.Content= '".$_POST['theme']."' ";
            $sql =  "select a.ImageID, a.PATH from travelimage as a where". $themeQuery;
        } else {
            // 主题也没选
            $sql = "select a.ImageID, a.PATH from travelimage as a";
        }
    }


    $result = $pdo->query($sql);
    $_SESSION['search'] = array();
    $_SESSION['search']['ImageID'] = array();
    $_SESSION['search']['PATH'] = array();
    $_SESSION['search']['Count'] = 0;
    $_SESSION['search']['currentPage'] = 1;
    $_SESSION['search']['sql'] = $sql;
    while ($row = $result->fetch()) {

        $_SESSION['search']['ImageID'][$_SESSION['search']['Count']] = $row['ImageID'];
        $_SESSION['search']['PATH'][$_SESSION['search']['Count']] = $row['PATH'];
        $_SESSION['search']['Count'] ++;

    }
    if ($_SESSION['search']['Count'] == 0) unset($_SESSION['search']);
    $pdo = null;


    header("Location: " . $_SERVER['HTTP_REFERER']);

}
catch (PDOException $e) {
    die($e->getMessage());
}

?>