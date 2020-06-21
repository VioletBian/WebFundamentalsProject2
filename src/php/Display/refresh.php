<?php session_start();?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/config.php');

    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $queryAll = 'SELECT Title, Description, ImageID, PATH FROM travelimage';
        $result = $pdo->query($queryAll);
        $count = $pdo->query("SELECT count(1) FROM travelimage")->fetchColumn();
        $numbers = range(1, $count);
        shuffle($numbers);
        $randomResult = array_slice($numbers, 0, 6);
        $refresh = array();
        $_SESSION['refresh'] = $refresh;
        $_SESSION['titles'] = array();
        $_SESSION['descriptions'] = array();
        $_SESSION['ids'] = array();
        for ($i = 1; $i <= $count; $i++) {
            $row = $result->fetch();
            if (inRandom($i,$randomResult)) {
                array_push($_SESSION['refresh'],$row['PATH']);
                array_push($_SESSION['titles'], $row['Title']);
                array_push($_SESSION['descriptions'], $row['Description']);
                array_push($_SESSION['ids'], $row['ImageID']);

            }
            else continue;
        }

        $pdo = null;


        header("Location: " . $_SERVER['HTTP_REFERER']);

    }
    catch (PDOException $e) {
        die($e->getMessage());
    }



    function inRandom($x,$arr){
        for ($i = 0; $i < 6; $i++) {
            if ($x == $arr[$i]) {return true;}
        }
        return false;

    }
?>