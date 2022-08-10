<?php 
session_start();

require_once "../constants.php";
require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

if(!isset($_GET['bpid']) || !isset($_GET['rid']))
{
    require_once("./error/404.html");
    die();
}

$bprofile_id = $_GET['bpid'];
$request_id = $_GET['rid'];
$uid = $_SESSION['user_id'];

$orm = new KaamdaarORM();

$SQL = "SELECT REQUEST_TYPE AS `type` FROM request WHERE REQUEST_ID = '$request_id' AND U_ID = '$uid';";
$results = $orm->connection->query($SQL);
if($results)
{
    $business = $results->fetch_assoc();
    if($business)
        $business_type = $business['type'];
    else 
    {
        require_once("./error/access-error.html");
        die();
    }
}

$SQL = "SELECT 
                bp.B_PROFILE_NAME AS bname, 
                bp.B_PROFILE_IMAGE AS bimage, 
                br.BR_CAT_NAME AS bcatname,
                br.BR_CAT_ICON AS bcaticon, 
                bi.B_INFO_RATING AS brating,
                b.BUSINESS_DESC AS bdesc 
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

if(!$business_details || !count($business_details))
{
    require_once("./error/access-error.html");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $business_details['bname']; ?></title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="../static/css/base/layout.css">
        <link rel="stylesheet" href="../static/css/business-details.css">
        <link rel="stylesheet" href="../static/css/modal/notif-modal.css">

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
                        <div class="head-icon-section head-notif-section" onclick="showNotificationModal();">
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
                <div style="display: none;" id="business-info--banner-modal">
                    <i class="fa-solid fa-xmark business-info--close-modal round-elem" onclick="document.getElementById('business-info--banner-modal').style.display = 'none';"></i>
                    <img id="business-info--banner-modal--image" src="https://ied.eu/wp-content/uploads/2016/03/solution.jpg" alt="">
                </div>
                <div class="business-info--banner" onclick="document.getElementById('business-info--banner-modal').style.display = 'block';"></div>
                <div class="business-info">
                    <div class="business-info--s1">
                        <div class="business-info--s1--l">
                            <div class="business-info--s1--l--1 bottom-bordered">
                                <?php 
                                    $business_logo = $business_details['bimage'];
                                ?>
                                <img class="business-info--profile" src="<?php echo $business_logo != "" ? $business_logo : "../static/images/default/blogo.jpeg" ?>" alt="Business profile">
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
                                <?php echo $business_details['bdesc']; ?>
                            </div>
                            <div class="business-info--photos">
                                <?php 
                                    $business_photos_dir = $_SERVER['DOCUMENT_ROOT'] . "/kaamdaar-php/uploads/business/$bprofile_id/type$business_type";
                                    $business_photos = array_values(array_diff(scandir($business_photos_dir), ['.', '..']));
                                    sort($business_photos);
                                    foreach($business_photos as $bphoto)
                                    {
                                        echo "<img class='business-info--photo' src='../uploads/business/$bprofile_id/type$business_type/$bphoto'/>";
                                    }
                                ?>
                            </div>
                            <div class="business-info--rr">
                                <!-- ratings and reviews -->
                                <h2 id="rr-title" class="bottom-bordered">Ratings and reviews</h2>
                                <div id="birr--summary">
                                    <p><?php echo $rating; ?></p>
                                    <div>
                                        <i class='fa fa-star app-fa-star'></i>
                                        <i class='fa fa-star app-fa-star'></i>
                                        <i class='fa fa-star app-fa-star'></i>
                                        <i class='fa fa-star app-fa-star'></i>
                                        <i class='fa fa-star app-fa-star'></i>
                                    </div>
                                    <span>
                                        2 reviews
                                    </span>
                                </div>
                                <ul id="birr--f-list" class="birr--f-list" style="list-style-type: none;">
                                    <li class="birr--f-list--item">
                                        <div class="birr--fli--root">
                                            <div class="birr--fli--root--head">
                                                <img class="birr--fli--icon round-elem" src="https://i.pinimg.com/474x/ee/60/0b/ee600b5178e4f1648fd1e8623f049611.jpg" alt="Review Icon">
                                                <div class="birr--fli-nr">
                                                    <p class="birr--fli--name">Ramesh Poudel</p>
                                                    <div class="birr--fli--rating">
                                                        <div class="birr--fli--rating-stars">
                                                            <i class='fa fa-star app-fa-star'></i>
                                                            <i class='fa fa-star app-fa-star'></i>
                                                            <i class='fa fa-star app-fa-star'></i>
                                                            <i class='fa fa-star app-fa-star'></i>
                                                            <i class='fa fa-star app-fa-star'></i>
                                                        </div>
                                                        <div class="birr--fli--rating-date">
                                                            <span>June 16 2002</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="birr--fli--root--body">
                                                <p class="birr--fli--desc">Guy did poor job fixing my Dell Inspiron laptop. Ban him.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <button id="birr--see-all">See all reviews</button>
                            </div>
                        </div>
                        <div class="business-info--s1--r">
                            <div class="bottom-bordered" style="padding-bottom: 10px;">
                                <img id="business-info--cat-icon" width="100px" height="100px" style="margin-left: auto; margin-right: auto;" src="<?php echo $business_details['bcaticon']; ?>" alt="">
                                <p id="business-info--cat-name">
                                    <?php echo $business_details['bcatname']; ?>
                                </p>
                            </div>
                            <p class="business-info--pricing" id="business-info--pricing">
                                Rs. <b>100 hr</b>
                            </p>
                            <div class="business-info--buttons">
                                <button class="business-info--button business-info--reject" id="business-info--reject" onclick="offerResponse(1);">Decline</button>
                                <button class="business-info--button business-info--accept" id="business-info--accept" onclick="offerResponse(0);">Accept</button>
                            </div>
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