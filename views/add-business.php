<?php 
	require_once '../constants.php';
    require_once "k_auth.php";

	session_start();
	if(!isset($_SESSION['user_phone'])) header('location:login.php?route=add-business.php');

    require_once ROOT_DIR . "models/business-category.php";
	require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

    use Model\{BusinessCategory};

	$orm = new KaamdaarORM();
    $business_profile = $orm->getBusinessProfile($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		
        <link rel="stylesheet" href="../static/css/base/layout.css">
		<link rel="stylesheet" href="../static/css/add-business.css">

		<title>Add business</title>
	</head>

    <body>
        <div class="container">
            <div class="container-head">
                <div class="container-head-pt-1">
                    <h1>Kaamdaar</h1>
                    <input type="text" class="search" placeholder="&setminus; Search kaamdaar">
                </div>
                <div class="container-head-pt-2">
                    <div class="head-icons">
                        <div class="head-icon-section head-notif-section">
                            <span class="notif-count">
                                3
                            </span>
                            <img class="head-icon notif-icon" src="https://img.icons8.com/fluency-systems-filled/452/appointment-reminders.png" alt="Notif">
                        </div>
                        <div class="head-icon-section head-profile-section">
                            <img class="head-icon profile-icon" src="<?php echo $_SESSION['user_image']; ?>" alt="Profile">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-body">
                <div class="nav-bar">
                    <div class="nav-links-cat">
                        <div class="nav-links-cat-head">
                            <p class="nav-links-cat-title">
                                Profile
                            </p>
                        </div>
                        <div class="nav-links-cat-body">
                            <ul class="nav-links-list">
                                <li class="nav-link">
                                    <div class="nav-link-root">
                                        <div class="nav-link-icon">
                                            <img class="nav-link-icon-round" src="<?php echo $_SESSION['user_image']; ?>" alt="">
                                        </div>
                                        <div class="nav-link-text">
                                            <a href="profile.php">Profile</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-link">
                                    <div class="nav-link-root">
                                        <div class="nav-link-icon">
                                            <img class="nav-link-icon-norm" src="https://img.icons8.com/ios-glyphs/344/briefcase.png" alt="business icon">
                                            <!-- src="https://img.icons8.com/color/344/briefcase.png"  -->
                                        </div>
                                        <div class="nav-link-text">
                                            <a href="bprofile.php">Business profile</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-link">
                                    <div class="nav-link-root">
                                        <div class="nav-link-icon">
                                            <!-- <img class="nav-link-icon-norm" src="https://img.icons8.com/fluency/344/paper-plane.png" alt=""> -->
                                            <img class="nav-link-icon-norm" src="https://img.icons8.com/ios-glyphs/344/paper-plane.png" alt="">
                                        </div>
                                        <div class="nav-link-text">
                                            <a href="requests.php">Your requests</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-links-cat">
                        <div class="nav-links-cat-head">
                            <p class="nav-links-cat-title">
                                New
                            </p>
                        </div>
                        <div class="nav-links-cat-body">
                            <ul class="nav-links-list">
                                <li class="nav-link">
                                    <div class="nav-link-root">
                                        <div class="nav-link-icon">
                                            <!-- <img class="nav-link-icon-norm" src="https://img.icons8.com/office/344/plus-math.png" alt=""> -->
                                            <img class="nav-link-icon-norm" src="https://img.icons8.com/external-simple-solid-edt.graphics/344/external-Plus-add-and-remove-simple-solid-edt.graphics.png" alt="">
                                        </div>
                                        <div class="nav-link-text">
                                            <a href="add-request.php">Add new request</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-link nav-link-active">
                                    <div class="nav-link-root">
                                        <div class="nav-link-icon">
                                            <img class="nav-link-icon-norm" src="https://img.icons8.com/external-simple-solid-edt.graphics/344/external-Plus-add-and-remove-simple-solid-edt.graphics.png" alt="">
                                        </div>
                                        <div class="nav-link-text">
                                            <a href="add-business.php">Add new business</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-links-cat">
                        <div class="nav-links-cat-head">
                            <p class="nav-links-cat-title">
                                Others
                            </p>
                        </div>
                        <div class="nav-links-cat-body">
                            <ul class="nav-links-list">
                                <li class="nav-link">
                                    <div class="nav-link-root">
                                        <div class="nav-link-icon">
                                            <!-- <img class="nav-link-icon-norm" src="https://img.icons8.com/fluency/344/exit.png" alt=""> -->
                                            <img class="nav-link-icon-norm" src="https://img.icons8.com/material-rounded/344/exit.png" alt="">
                                        </div>
                                        <div class="nav-link-text">
                                            <a href="logout.php">Logout</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-link">
                                    <div class="nav-link-root">
                                        <div class="nav-link-icon">
                                            <!-- <img class="nav-link-icon-norm" src="https://img.icons8.com/fluency/344/settings.png" alt=""> -->
                                            <img class="nav-link-icon-norm" src="https://img.icons8.com/material-sharp/344/settings.png" alt="">
                                        </div>
                                        <div class="nav-link-text">
                                            <a href="settings.php">Settings</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="nav-link-root">
                                        <div class="nav-link-icon">
                                            <!-- <img class="nav-link-icon-norm" src="https://img.icons8.com/fluency/344/privacy-policy.png" alt=""> -->
                                            <img class="nav-link-icon-norm" src="https://img.icons8.com/ios-filled/344/privacy-policy.png" alt="">
                                        </div>
                                        <div class="nav-link-text">
                                            <a href="#">Privacy and policies</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <?php 
						$categories = $orm->getBusinessCategories();
					?>
                    <div class="confirm-business-modal" style="display: none;">
                        <div class="cbm-content">
                            <p id="modal-business-name"></p>
                            <img id="modal-business-icon" src="" alt="">
                            <div class="confirm-modal-btns rfloat">
                                <button id="modal-cancel-btn">Cancel</button>
                                <button id="modal-confirm-btn">Confirm</button>
                            </div>
                        </div>
                    </div>

					<div class="business-cat-list">
                        <?php 
                        foreach($categories as $category)
                        {
                            if(isset($_SESSION['business_id']))
                            {
                                $onclick = "openConfirmModal({
                                    id: '$category->cat_id',
                                    name: '$category->cat_name',
                                    icon: '$category->cat_icon'
                                });";
                            }
                            else 
                            {
                                $onclick = "location.href = 'create-business-profile.php';";
                            }
                        ?>
                            <div class="bcli" onclick="<?php echo $onclick; ?>">
                                <div class="bcli-root">
                                    <img id="bcli-icon" width="50px" height="50px" src='<?php echo $category->cat_icon; ?>' alt='Icon'/>
                                    <p id="bcli-name"><?php echo $category->cat_name; ?></p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openConfirmModal(businessCategory)
            {
                let name = document.getElementById("modal-business-name");
                let icon = document.getElementById("modal-business-icon");

                name.innerText = businessCategory.name;
                icon.src = businessCategory.icon;

                let modal = document.getElementsByClassName("confirm-business-modal")[0];
                modal.style.display = "block";

                document.getElementById("modal-cancel-btn").addEventListener("click", () => {
                    modal.style.display = "none";
                });

                document.getElementById("modal-confirm-btn").addEventListener("click", () => {
                    let xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = () => {
                        if(xhr.readyState = XMLHttpRequest.DONE)
                        {
                            if(xhr.status == 200)
                            {
                                console.log(xhr.responseText);
                            }
                        }
                    }

                    xhr.open("GET", "", true);
                    xhr.send();
                });
            }
        </script>
    </body>
</html>