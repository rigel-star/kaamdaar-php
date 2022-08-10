<?php 
session_start();

require_once "../constants.php";
require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

$type = $_GET['type'];
$desc = $_GET['desc'];
$bid = $_SESSION['business_id'];

$SQL = "INSERT INTO business(BUSINESS_TYPE, BUSINESS_START_DATE, B_PROFILE_ID, BUSINESS_STATUS, BUSINESS_DESC) VALUES($type, DEFAULT, '$bid', 0, '$desc');";

$orm = new KaamdaarORM();

if(!$orm->connection->query($SQL))
    header("HTTP/1.1 500 $SQL");

$orm->close();
?>