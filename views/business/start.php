<?php 
    session_start();

    require_once "../../utils.php";
    require_once ROOT_DIR . "/controllers/db/kaamdaar_orm.php";
    require_once ROOT_DIR . "/models/user.php";
    require_once ROOT_DIR . "/models/business-category.php";

    $orm = new KaamdaarORM();
    $bp = $orm->getBusinessProfile($_SESSION["user_id"]);
    if(!$bp)
        header("location:./create-business-profile.php");

    $newb_type = null;
    if(isset($_GET['type']) && !empty(trim($_GET['type'])))
        $newb_type = $_GET['type'];
    else 
    {
        require_once "./error/404.html";
        die();
    }

    $categories = $orm->getBusinessCategories();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="../">

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link rel="stylesheet" href="../static/css/base/layout.css">
        <link rel="stylesheet" href="../static/css/modal/notif-modal.css">
        <link rel="stylesheet" href="../static/css/business/start.css">

        <script src="../static/js/notif/notif.js"></script>

        <title>Start new business</title>
    </head>
    <body>
        <div class="container">
            <div id="notif-modal" class="modal notif-modal">
                <?php 
                    require_once("../modal/notif-modal.php");
                ?>
            </div>

            <div class="container-head">
                <div class="container-head-pt-1">
                    <h1>Kaamdaar</h1>
                    <input type="text" class="search" placeholder="&setminus; Search kaamdaar">
                </div>
                <div class="container-head-pt-2">
                    <div class="head-icons">
                        <div class="head-icon-section head-notif-section" onclick="showNotificationModal(); //showNotificationModal function is inside notif-modal.js">
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
                <div class="newb-form-container">
                    <form class="newb-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype='multipart/form-data'>
                        <h2>Start a business</h2>
                        <div class="newb-form-in-sec newb-type">
                            <select name="newb-type" id="newb-type--select">
                                <?php 
                                foreach($categories as $category) 
                                {
                                ?>
                                    <option value="<?php echo $category->cat_id; ?>" style="background-image: url('<?php echo $category->cat_icon; ?>');"><?php echo $category->cat_name; ?></option>
                                <?php 
                                } 
                                ?>
                            </select>
                        </div>
                        <div class="newb-form-in-sec newb-desc">
                            <p class="white-bg" id="newb-desc--info">
                                Please write descriptive information about your experience in this business. Single-word or misleading description will be removed.
                            </p>
                            <textarea placeholder="Enter description here..." name="newb-desc" class="newb-desc-in inputtext" cols="30" rows="20"></textarea>
                        </div>
                        <div class="newb-form-in-sec white-bg newb-photos-container">
                            <input class="inputfile input-pics" id="input-pics" type="file" accept="image/*" name="newb-photos" onchange="chooseBusinessPictures(this);" multiple>
                            <div class="newb-photos-list" id="newb-photos-list" style="display: inline-block;">
                            </div>
                            <button type="button" id="newb-photos-upload-btn-2" onclick="document.getElementById('input-pics').click();"><img src="https://img.icons8.com/external-tanah-basah-glyph-tanah-basah/344/external-plus-user-interface-tanah-basah-glyph-tanah-basah-2.png"/></button>
                            <button type="button" id="newb-photos-upload-btn" onclick="document.getElementById('input-pics').click();">Upload</button>
                        </div>
                        <div class="newb-form-in-sec newb-acts rfloat">
                            <button type="button" class="newb-form-action-button newb-form-cancel">
                                Cancel
                            </button>
                            <button type="submit" class="newb-form-action-button newb-form-start">
                                Start
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="../static/js/notif/notif-modal.js"></script>
        <script>
            updateNotifCount();

            var photoCount = 0;
            function chooseBusinessPictures(input) 
            {
                let container = document.getElementById("newb-photos-list");

                if(input.files) 
                {
                    for(const img of input.files)
                    {
                        var reader = new FileReader();
                        reader.onload = (e) => {
                            let image = document.createElement("img");
                            image.classList.add("newb-photo");
                            image.src = e.target.result;
                            container.appendChild(image);
                            photoCount++;
                        };

                        reader.readAsDataURL(img);
                    }
                }

                document.getElementById('newb-photos-upload-btn').style.display = 'none';

                if(photoCount < 5)
                    document.getElementById('newb-photos-upload-btn-2').style.display = 'inline-block';
                else 
                    document.getElementById('newb-photos-upload-btn-2').style.display = 'none';
            }
        </script>
    </body>
</html>