<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/src/php/config.php');
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $_SESSION['search'] = array();
    $_SESSION['search']['ImageID'] = array();
    $_SESSION['search']['PATH'] = array();
    $_SESSION['search']['Count'] = 0;
    $_SESSION['search']['currentPage'] = 1;
    if(isset($_POST['Title'])) $sql = "select ImageID, PATH from travelimage Where Title LIKE '%".$_POST['Title']."%'  ";
    if(isset($_POST['theme'])) $sql = "select ImageID, PATH from travelimage Where Content LIKE '%".$_POST['theme']."%'  ";
    if(isset($_POST['country'])) $sql = "select a.ImageID, a.PATH from travelimage as a, geocountries as b Where a.CountryCodeISO = b.ISO and b.CountryName LIKE '%".$_POST['country']."%'  ";
    if(isset($_POST['city'])) $sql = "select a.ImageID, a.PATH from travelimage as a, geocities as c Where c.GeoNameID = a.CityCode and c.AsciiName LIKE '%".$_POST['city']."%'  ";
    if(isset($_POST['filter-way'])){
        $_SESSION['search']['Title'] = array();
        $_SESSION['search']['Description'] = array();
        if ($_POST['filter-way'] == 'by-title') $sql="select ImageID, PATH, Title, Description from travelimage where Title LIKE '%".$_POST['filter-input']."%'  ";
        if ($_POST['filter-way'] == 'by-description') $sql="select ImageID, PATH, Title, Description from travelimage where Description LIKE '%".$_POST['filter-input']."%'  ";
    }
    $result = $pdo->query($sql);
    while ($row = $result->fetch()) {
        $_SESSION['search']['ImageID'][$_SESSION['search']['Count']] = $row['ImageID'];
        $_SESSION['search']['PATH'][$_SESSION['search']['Count']] = $row['PATH'];
        if(isset($_SESSION['search']['Title']) && isset($_SESSION['search']['Description'])){
            $_SESSION['search']['Title'][$_SESSION['search']['Count']] = $row['Title'];
            $_SESSION['search']['Description'][$_SESSION['search']['Count']] = $row['Description'];
        }
        $_SESSION['search']['Count'] ++;


    }
    $pdo = null;

    header("Location: " . $_SERVER['HTTP_REFERER']);

}
catch (PDOException $e) {
    die($e->getMessage());
}
?>
