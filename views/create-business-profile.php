<?php 
    session_start();

    require_once "../utils.php";
    require_once ROOT_DIR . "/controllers/db/kaamdaar_orm.php";
    require_once ROOT_DIR . "/models/user.php";

    $orm = new KaamdaarORM();
    $bp = $orm->getBusinessProfile($_SESSION["user_id"]);
    if($bp)
        header("location:bprofile.php");

    $route = "bprofile.php";

    if(isset($_GET['route']))
        $route = $_GET['route'];
    
    $error = [];

    // registerBusinessProfile function
    (function()
    {
        global $error;
        global $route;

        if(!isset($_POST['create-business']))
            return;

        $name = $_POST['business-name'];
        $phone = $_POST['business-phone'];

        if(empty(trim($name)))
        {
            $error['name'] = "Business name is required";
        }

        if(empty(trim($phone)))
        {
            $error['phone'] = "Business phone is required";
        }

        if(!count($error))
        {
            $orm = new KaamdaarORM();
            $business_id = random_uniqid("b.", 11);

            if(!mkdir("../uploads/bprofile/$business_id"))
            {
                die("500(Internal Server Error): Could not create business profile");
            }

            if(!mkdir("../uploads/business/$business_id"))
            {
                die("500(Internal Server Error): Could not create business profile");
            }

            $image_path = $_SESSION['user_image'];
            if(isset($_FILES['business-profile']['name']))
            {
                if(is_uploaded_file($_FILES['business-profile']['tmp_name']))
                {
                    $file_ext = end(explode($_FILES['business-profile']['name']));

                    $base_url = $_SERVER['DOCUMENT_ROOT'] . "/kaamdaar-php";
                    $rel_path = "uploads/bprofile/$business_id/bprofile.$file_ext";
                    $abs_path = $base_url . "/$rel_path";

                    echo $abs_path;
                    die();

                    if(!move_uploaded_file($_FILES['business-profile']['tmp_name'], $abs_path))
                        die("500(Internal Server Error): Could not create business profile");
                    else 
                        $image_path = "../" . $rel_path;
                }
                else 
                    die("500(Internal Server Error): Could not create business profile");
            }

            $SQL = "INSERT INTO business_profile(B_PROFILE_ID, B_PROFILE_NAME, B_PROFILE_IMAGE, U_ID) VALUES('$business_id', '$name', '$image_path', '" . $_SESSION['user_id'] . "');";
            $orm->connection->query($SQL);
            $orm->close();

            $_SESSION['business_id'] = $business_id;
            header("location:$route");
        }
    })();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
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
        <link rel="stylesheet" href="../static/css/create-business-profile.css">

        <script src="../static/js/notif/notif.js"></script>

        <title>Create business profile</title>
    </head>
    <body>
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
        <div class="container-body container">
            <div class="business-form">
                <h2>
                    Create business profile
                </h2>
                <p>
                    Create business profile to expand your businesses
                </p>
                <form class="bc-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="bc-form-1">
                        <div class="input-section profile-name-section">
                            <label for="bname">Business name <span class="input-op">*</span></label>
                            <input class="inputtext <?php echo isset($error['name']) ? "inputerror" : "";?>" name="business-name" type="text" placeholder="Enter your business name" value="<?php echo isset($_POST['business-name']) ? $_POST['business-name'] : ""; ?>">
                        </div>

                        <div class="input-section profile-phone-section">
                            <label for="bphone">Business phone <span class="input-op">*</span></label>
                            <input class="inputtext <?php echo isset($error['phone']) ? "inputerror" : "";?>" name="business-phone" type="text" placeholder="Enter your phone number" value="<?php echo isset($_POST['business-phone']) ? $_POST['business-phone'] : ""; ?>">
                        </div>

                        <div class="profile-image-section">
                            <label>Profile picture</label>
                            <div class="pis-1">
                                <!-- <img id="profile-img" class="profile-img" src="https://thypix.com/wp-content/uploads/2021/10/anime-avatar-profile-picture-thypix-117-700x700.jpg" alt=""> -->
                                <img id="profile-img" class="profile-img" src="<?php echo $_SESSION['user_image']; ?>" alt="">
                                <input id="input-profile" class="inputfile input-profile" name="business-profile" type="file" accept="image/*" onchange="readURL(this);">
                                <button onclick="openFileTray();" class="upload-file-btn" type="button">Upload new picture</button>
                            </div>
                        </div>
                    </div>
                    <div class="rfloat">
                        <input class="create-business-btn" type="submit" value="Create" name="create-business">
                    </div>
                </form>
            </div>
        </div>

        <script src="../static/js/notif/notif-modal.js"></script>
        <script>
            updateNotifCount();

            function openFileTray()
            {
                document.getElementById("input-profile").click();
            }

            function readURL(input) 
            {
                if(input.files) 
                {
                    for(const file of input.files)
                    {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            document.getElementById('profile-img').src = e.target.result;
                        };

                        reader.readAsDataURL(file);
                    }
                }
            }
        </script>
    </body>
</html>