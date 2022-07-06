<?php 
session_start();

require_once "../constants.php";
require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

if(!isset($_GET['user_id']) || !isset($_GET['request_id']))
{
    require_once("./error/404.html");
    die();
}

$uid = $_GET['user_id'];
$rid = $_GET['request_id'];

$orm = new KaamdaarORM();

$SQL = "SELECT r.REQUEST_LATLONG AS reqlatlong, r.REQUEST_LOCATION AS reqloc, u.U_PHONE AS reqphone, concat(u.U_FNAME, ' ', u.U_LNAME) AS reqname, u.U_IMAGE AS reqimage, r.REQUEST_TIME AS reqdate FROM request r INNER JOIN users u ON r.U_ID = u.U_ID WHERE u.U_ID = '$uid' AND r.REQUEST_ID = '$rid';";
$result = $orm->connection->query($SQL);

$request_details = [];
if($result)
{
    $request_details = $result->fetch_assoc();
    if(!$request_details || !count($request_details))
    {
        require_once("./error/access-error.html");
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
    	<script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>

        <link rel="stylesheet" href="../static/css/base/layout.css">
        <link rel="stylesheet" href="../static/css/modal/notif-modal.css">
        <link rel="stylesheet" href="../static/css/request-details.css">

        <script src="../static/js/notif/notif.js"></script>
        <script src="./utils.js"></script>

        <title><?php echo $request_details['reqname']; ?></title>
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
            <div class="container-body">
                <div class="req-details">
                    <div class="req-details--head bottom-bordered">
                        <img class="req-details--head--image round-elem" src="<?php echo $request_details['reqimage']; ?>" alt="">
                        <div class="req-details--head-1">
                            <p class="req-details--head--name"><?php echo $request_details['reqname']; ?></p>
                            <p class="req-details--head--phone"><?php echo $request_details['reqphone']; ?></p>
                            <p class="req-details--head--date" id="req-details--head--date"></p>
                        </div>
                    </div>
                    <div class="req-details--body">
                        <p class="req-details--body--location">Near <b><?php echo $request_details['reqloc']; ?></b></p>
                        <button>Show direction <i class="fa-solid fa-diamond-turn-right"></i></button>
                    </div>
                </div>
                <div class="req-map" id="req-map"></div>
            </div>
        </div>

        <?php 
            $latlongarray = explode(",", $request_details['reqlatlong']);
            $lng = trim($latlongarray[1]);
            $lat = trim($latlongarray[0]);
        ?>

        <script src="../static/js/notif/notif-modal.js"></script>
        <script defer>
            updateNotifCount();

            (() => {
                let requestDate = document.getElementById("req-details--head--date");
                requestDate.innerText = `${timeSince(new Date("<?php echo $request_details['reqdate']; ?>"))} ago`;
            })();

            const MAPBOX_TOKEN = "pk.eyJ1Ijoia2FhbWRhYXIiLCJhIjoiY2wwNWhwNjl5MDhjMjNjbnoxajMxOXExMCJ9.KDuSWfD7invXCiRTg_WMfg";
            mapboxgl.accessToken = MAPBOX_TOKEN;

            function initMap(center)
            {
                var mapOptions = {
                    container: 'req-map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    zoom: 17,
                    center
                };

                // main map object
                const map = new mapboxgl.Map(mapOptions);
                map.addControl(new mapboxgl.NavigationControl({
                        visualizePitch: true
                    }),
                    "bottom-right"); // Add zoom and rotation controls to the map.

                let userLocControl = new mapboxgl.GeolocateControl({
                    positionOptions: {
                        enableHighAccuracy: true
                    },
                    trackUserLocation: true,
                    // Draw an arrow next to the location dot to indicate which direction the device is heading.
                    showUserHeading: true
                });

                map.addControl(userLocControl, "bottom-right");

                var markerDetails = createMarker(map, center);
            }

            (function requestAndLoadMap()
            {
                if(navigator.geolocation)
                {
                    let locOptions = {
                        maximumAge: 0,
                        timeout: 40000,
                        enableHighAccuracy: true
                    };

                    navigator.geolocation.getCurrentPosition(
                                                            (pos) => {
                                                                initMap([<?php echo $lng; ?>, <?php echo $lat; ?>]);
                                                            },
                                                            (err) => {
                                                                console.log(err);
                                                            },
                                                            locOptions
                                                        );
                }
                else
                    console.error("[KAAMDAAR DEBUG]: Geolocation is not supported by this browser.");
            })();

            function createMarker(map, latlong)
            {
                const el = document.createElement('div');
                el.className = 'marker';
                el.style.backgroundSize = '100%';

                const marker = new mapboxgl.Marker(el, {})
                                    .setLngLat(latlong)
                                    .addTo(map);
                return [el.className, marker];
            }
        </script>
    </body>
</html>