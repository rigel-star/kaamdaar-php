<?php 
session_start();

require_once "../../constants.php";
require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

$old = $_GET['old'];
$new = $_GET['new'];
$cnew = $_GET['cnew'];

$phone = $_SESSION['user_phone'];
$uid = $_SESSION['user_id'];

$kdb = new KaamdaarORM;
$user = $kdb->getUserByPhone($phone);

if($old !== $user->password)
{
    echo "Incorrect old password";
}
else 
{
    $SQL = "update users set u_password = '$new' where u_id = '$uid';";
    if($kdb->connection->query($SQL))
    {
        echo "true";
    }
    else 
        echo "false";
}
?>