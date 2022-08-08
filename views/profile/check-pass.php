<?php
session_start();

require_once "../../constants.php";
require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

$pass = $_GET['pass'];

$phone = $_SESSION['user_phone'];

$kdb = new KaamdaarORM;
$user = $kdb->getUserByPhone($phone);

if($old !== $user->password)
    echo "false";
else 
    echo "true";
?>