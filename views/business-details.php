<?php 
session_start();

require_once "../constants.php";
require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

$bprofile_id = $_GET['bpid'];
$request_id = $_GET['rid'];

$orm = new KaamdaarORM();

$SQL = "SELECT REQUEST_TYPE AS `type` FROM request WHERE REQUEST_ID = '$request_id';";
$business_type = $orm->connection->query($SQL)->fetch_assoc()['type'];

$SQL = "SELECT 
                bp.B_PROFILE_NAME AS bname, 
                bp.B_PROFILE_IMAGE AS bimage, 
                br.BR_CAT_NAME AS bcatname,
                br.BR_CAT_ICON AS bcaticon, 
                bi.B_INFO_RATING AS brating 
                FROM business_profile bp 
                NATURAL JOIN business b 
                INNER JOIN br_category br 
                ON b.BUSINESS_TYPE = br.BR_CAT_ID 
                INNER JOIN business_info bi
                ON b.BUSINESS_ID = bi.BUSINESS_ID 
                WHERE bp.B_PROFILE_ID = '$bprofile_id' 
                AND b.BUSINESS_TYPE = '$business_type';";

$results = $orm->connection->query($SQL);
$business_details = [];
if($results)
{
    $business_details = $results->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $business_details['bname']; ?></title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="../static/css/base/layout.css">
        <link rel="stylesheet" href="../static/css/business-details.css">
        <link rel="stylesheet" href="../static/css/modal/notif-modal.css">

        <script src="../static/js/modal.js"></script>
        <script src="../static/js/notif/notif.js"></script>
    </head>
    <body>
        <div class="container">
            <div id="notif-modal" class="modal notif-modal">
                <?php 
                    require_once("./modal/notif-modal.php");
                ?>
            </div>

            <div class="container-head">
                <div class="container-head-pt-1">
                    <h1>Kaamdaar</h1>
                    <input type="text" class="search" placeholder="&setminus; Search kaamdaar">
                </div>
                <div class="container-head-pt-2">
                    <div class="head-icons">
                        <div class="head-icon-section head-notif-section" onclick="showModal('notif-modal');">
                            <span id="notif-count" class="notif-count"></span>
                            <img class="head-icon notif-icon" src="https://img.icons8.com/fluency-systems-filled/452/appointment-reminders.png" alt="Notif">
                        </div>
                        <div class="head-icon-section head-profile-section">
                            <img class="head-icon profile-icon" src="<?php echo $_SESSION['user_image']; ?>" alt="Profile">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container--body">
                <div class="business-info--banner"></div>
                <div class="business-info">
                    <div class="business-info--s1">
                        <div class="business-info--s1--l">
                            <div class="business-info--s1--l--1">
                                <img class="business-info--profile" src="<?php echo $business_details['bimage']; ?>" alt="Business profile">
                                <div>
                                    <span style="display: block;" class="business-info--name"><?php echo $business_details['bname']; ?></span>
                                    <div class="business-info--rating">
                                        <?php 
                                        $rating = $business_details['brating']; 
                                        for($i = 0; $i < (int) $rating; $i++) echo "<span class='fa fa-star app-fa-star fa-star--checked'></span>";
                                        for($i = 0; $i < (5 - (int) $rating); $i++) echo "<span class='fa fa-star app-fa-star'></span>";
                                        ?>
                                        <span>
                                            <?php echo $rating; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="business-info--desc">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae quis in expedita, dignissimos eligendi suscipit pariatur iusto magni non voluptatibus dolorum magnam eaque repudiandae voluptas fuga! Illum, ad eum. Recusandae!
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae quis in expedita, dignissimos eligendi suscipit pariatur iusto magni non voluptatibus dolorum magnam eaque repudiandae voluptas fuga! Illum, ad eum. Recusandae!
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae quis in expedita, dignissimos eligendi suscipit pariatur iusto magni non voluptatibus dolorum magnam eaque repudiandae voluptas fuga! Illum, ad eum. Recusandae!
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae quis in expedita, dignissimos eligendi suscipit pariatur iusto magni non voluptatibus dolorum magnam eaque repudiandae voluptas fuga! Illum, ad eum. Recusandae!
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae quis in expedita, dignissimos eligendi suscipit pariatur iusto magni non voluptatibus dolorum magnam eaque repudiandae voluptas fuga! Illum, ad eum. Recusandae!
                            </div>
                        </div>
                        <div class="business-info--s1--r">
                            <div>
                                <img width="100px" height="100px" src="<?php echo $business_details['bcaticon']; ?>" alt="">
                                <p>
                                    <?php echo $business_details['bcatname']; ?>
                                </p>
                                <p class="business-info--pricing">
                                    Rs. 100 hour
                                </p>
                            </div>
                            <div class="business-info--buttons">
                                <button class="business-info--button business-info--accept" id="business-info--accept" onclick="offerResponse(0);">Accept</button>
                                <button class="business-info--button business-info--reject" id="business-info--reject" onclick="offerResponse(1);">Reject</button>
                            </div>
                        </div>
                    </div>
                    <div class="business-info--s2">
                        <div class="business-info--activities">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../static/js/notif/notif-modal.js"></script>
        <script defer>
            updateNotifCount();

            function offerResponse(response)
            {
                let url = `./offer-response.php?rec-id=<?php echo $bprofile_id; ?>&req-id=<?php echo $request_id; ?>&response-status=${response}`;
                let xhr = new XMLHttpRequest();
                xhr.open("GET", url, true);
                xhr.send();
            }
        </script>
    </body>
</html>