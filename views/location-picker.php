<?php 
    session_start();

    $route = '';
    if(isset($_GET['redirect']))
    {
        $route = $_GET['redirect'];
    }
    else 
    {
        require_once('./error/access-error.html');
        die();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Location Picker</title>
        <link rel="stylesheet" href="../static/css/location-picker.css">
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <!-- <link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
    	<script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
        <script src="../static/js/map/location-picker.js" defer></script> -->

        <style>
            .modal 
            {
                display: none; 
                position: fixed; 
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgb(0, 0, 0);
                background-color: rgba(0, 0, 0, 0.4);
                animation-name: fadeIn;
                animation-duration: 0.4s
            }

            .modal-content 
            {
                position: fixed;
                bottom: 0;
                background-color: #fefefe;
                width: 100%;
                animation-name: slideIn;
                animation-duration: 0.4s
            }

            @keyframes slideIn 
            {
                from 
                {
                    bottom: -300px; 
                    opacity: 0;
                }
                to 
                {
                    bottom: 0; 
                    opacity: 1;
                }
            }

            @keyframes fadeIn 
            {
                from 
                {
                    opacity: 0;
                } 
                to 
                {
                    opacity: 1;
                }
            }
        </style>
    </head>
    <body>
        <div class="control">
            <input class="search" type="text" name="search" placeholder="Search places"/>

            <div class="location-info">
                <p class="loc-name">Sankhamul - 29, Lalitpur</p>
                <p class="loc-latlong">23, 85</p>
            </div>

            <div class="pin-control">
                <button class="map-btn pin-to-current"><i class='fas fa-map-pin'></i> Pin to current location</button>
            </div>

            <div class="rfloat">
                <button class="map-btn cancel-btn">Cancel</button>
                <button class="map-btn done-btn" onclick="document.getElementById('modal').style.display = 'block'">Done</button>
            </div>
        </div>

        <div class="map" id="map"></div>

        <div class="modal" id="modal">
            <?php require_once './modal/' . $route; ?>
        </div>

        <script>
            var modal = document.getElementById('modal');

            window.onclick = (e) => {
                if(window.event.target == modal)
                    modal.style.display = "none";
            }
        </script>
    </body>
</html>