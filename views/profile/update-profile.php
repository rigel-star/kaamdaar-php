<?php 
session_start();

require_once "../../constants.php";
require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

$uid = $_SESSION['user_id'];
$key = $_GET['field'];
$value = $_GET['value'];

$SQL = "UPDATE users SET $key = '$value' WHERE U_ID = '$uid'";

$orm = new KaamdaarORM;
if($orm->connection->query($SQL))
{
    echo "OK";
}
?>