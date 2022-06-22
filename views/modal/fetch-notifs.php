<?php 
session_start();

if(!isset($_SESSION['business_id']))
    return [];

require_once $_SERVER['DOCUMENT_ROOT'] . "/kaamdaar-php/constants.php";
require_once ROOT_DIR . "models/request.php";
require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

$count = $_GET['count'];
$action = $_GET['action'];
$user_id = $_SESSION['user_id'];
$business_id = $_SESSION['business_id'];

if($action === "count")
{
    echo json_encode(['notif_count' => 6]);
    return;
}

$orm = new KaamdaarORM();
$notifications = [];

/* fetch_response_notifs() function */
(function ()
{
    global $orm;
    global $notifications;
    global $business_id;
    global $user_id;

    if(!isset($_SESSION['business_id'])) return;

    $RESPONSE_RESPONSE_SQL = "SELECT * FROM response_notifications rn NATURAL JOIN request r WHERE rn.RESPONSE_RECEIVER_ID = '$business_id';"; // fetch responses recived for user's business profile

    $result = $orm->connection->query($RESPONSE_RESPONSE_SQL);
    while($response = $result->fetch_assoc())
    {
        $responseType = $response['RESPONSE_TYPE'];
        $receiver_id = $response['RESPONSE_RECEIVER_ID'];
        $sender_id = $response['RESPONSE_SENDER_ID'];
        $response_status = $response['RESPONSE_STATUS'];
        $response_time = $response['RESPONSE_TIME'];
        $request_type = Model\REQUEST_TYPE_NAMES[$response['REQUEST_TYPE']];
        $request_id = $response['REQUEST_ID'];

        $NOTIF_SQL = 
            "SELECT u.U_IMAGE AS `ICON`, 
            concat_ws(' ', u.U_FNAME, u.U_LNAME, " . ($response_status == "1" ? "'accepted'" : "'rejected'") . ") AS `PROFILE`, 
            '$request_type' AS `TITLE`, 
            'This is description' as `DESCRIPTION`, 
            '$response_time' AS `TIME`, 
            $response_status AS `STATUS`, 
            $receiver_id AS `RECEIVER`, 
            $sender_id AS `SENDER`, 
            $request_id as `REQUEST_ID` 
            FROM users u 
            WHERE u.U_ID = '$receiver_id';"; // response response notifications are only received by business owners

        $notifs = $orm->connection->query($NOTIF_SQL);
        while($notif = $notifs->fetch_assoc())
        {
            $notif['NOTIF_TYPE'] = 'RESPONSE';
            $notif['RESPONSE_TYPE'] = $responseType;
            array_push($notifications, $notif);
        }
    }
})();

/* fetch_request_notifs() function */
(function ()
{
    global $notifications;
    global $orm;
    global $business_id;
    global $count;
    global $action;
    global $user_id;

    $businesses = new ResultSet($orm->connection->query("SELECT * FROM business WHERE B_PROFILE_ID = $business_id;"));
    if($businesses && count($businesses))
    {
        foreach($businesses as $business)
        {
            $type = $business['BUSINESS_TYPE'];
            $start_date = $business['BUSINESS_START_DATE'];
            $notif_sql = 
            "SELECT 
                u.U_IMAGE AS `ICON`, 
                concat_ws(' ', u.U_FNAME, u.U_LNAME, 'wants') as `PROFILE`,
                r.REQUEST_TYPE AS `TITLE`,
                r.REQUEST_LOCATION AS `DESCRIPTION`,
                r.REQUEST_TIME AS `TIME`,
                u.U_ID AS `USER_ID`,
                r.REQUEST_ID AS `REQUEST_ID` 
                FROM request_notifications rn 
                NATURAL JOIN request r 
                NATURAL JOIN users u 
                WHERE r.REQUEST_TYPE = $type 
                AND YEAR(r.REQUEST_TIME) >= YEAR('$start_date') 
                AND MONTH(r.REQUEST_TIME) >= MONTH('$start_date') 
                AND DAY(r.REQUEST_TIME) >= DAY('$start_date') 
                AND r.U_ID != '" . $user_id 
                . "' ORDER BY r.REQUEST_TIME DESC;";

            $notifs = new ResultSet($orm->connection->query($notif_sql));

            if(count($notifs))
            {
                foreach($notifs as $notif)
                {
                    $notif['NOTIF_TYPE'] = 'REQUEST';
                    $notif['STATUS'] = "0";
                    $notif['TITLE'] = Model\REQUEST_TYPE_NAMES[$notif['TITLE']];
                    array_push($notifications, $notif);
                }
            }
        }
    }
})();

$notif_count = count($notifications);
echo json_encode(array_slice($notifications, 0, $count > $notif_count ? $notif_count : $count));
?>