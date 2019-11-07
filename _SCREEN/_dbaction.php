<?php
require  '_boot.php';
require  '_dbC.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/json');


$DB = new dbC();
$DB->connect('dbscreens');

switch ($_GET["action"]) {
    case "getsclist":
        $data = $DB->getScreens($_GET["param"], '.');
        echo json_encode(array('result' => '1', 'data' => $data));
        break;
        case "getsplist":
        $data = $DB->getPages($_GET["param"], '.');
        echo json_encode(array('result' => '1', 'data' => $data));
        break;   
    case "status":
        echo json_encode(array('result' => '1', 'DB' => $DB, 'POST' => $_POST, 'GET' => $_GET, 'COOKIE' => $_COOKIE));
        break;
    default:
        echo json_encode(array('result' => '-1'));
        break;
}


