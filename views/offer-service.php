<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/kaamdaar-php/constants.php";
require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

$request_id = $_GET['req-id'];
$receiver_id = $_GET['rec-id'];
$business_id = $_GET['bus-id'];

$orm = new KaamdaarORM;

$SQL = "INSERT INTO response_notifications(RESPONSE_SENDER_ID, RESPONSE_RECEIVER_ID, REQUEST_ID, RESPONSE_TYPE, RESPONSE_STATUS, RESPONSE_TIME) VALUES($business_id, $receiver_id, $request_id, 0, 0, DEFAULT);";
$orm->connection->query($SQL);
?>