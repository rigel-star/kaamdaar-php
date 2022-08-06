<?php 
	require_once '../../constants.php';
    require_once "../k_auth.php";

	session_start();
	if(!isset($_SESSION['user_phone'])) header('location:login.php?route=profile.php');

	require_once '../../utils.php';
	require_once ROOT_DIR . "controllers/db/db_kaamdaar.php";
	require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

    $korm = new KaamdaarORM();
    $phone = $_SESSION['user_phone'];
    $user = $korm->getUserByPhone($phone);
    $uid = $user->id;
?>

<!DOCTYPE html>
<html>
    <head>
        <base href='../'></base>
		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="../static/css/base/layout.css">
        <link rel="stylesheet" href="../static/css/modal/notif-modal.css">
        <link rel="stylesheet" href="../static/css/profile/edit.css">

        <script src="../static/js/notif/notif.js"></script>

		<title>Edit profile</title>
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
                <div class="profile-edit">
                    <div class="profile-edit-img">
                        <img id="profile-edit--img-src" src="<?php echo $_SESSION['user_image']; ?>" alt="Profile image">
                    </div>
                    <div class="profile-edit-details">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="profile-edit--section profile-edit--section--profile">
                                <div class="profile-edit--section--head">
                                    <p class="profile-edit--section--title">Profile</p>
                                </div>
                                <div class="profile-edit--section--body">
                                    <div class="profile-edit-details--sec profile-edit-details--fname">
                                        <label class="profile-edit--input-label">First Name</label>
                                        <input placeholder="First name" class="profile-edit--input" type="text" id="fname" name="fname" onfocusout="updateName('f');" value="<?php echo $user->fname; ?>">
                                    </div>
                                    <div class="profile-edit-details--sec profile-edit-details--lname">
                                        <label class="profile-edit--input-label">Last Name</label>
                                        <input placeholder="Last name" class="profile-edit--input" type="text" id="lname" name="lname" onfocusout="updateName('l');" value="<?php echo $user->lname; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="profile-edit--section profile-edit--section--account">
                                <div class="profile-edit--section--head">
                                    <p class="profile-edit--section--title">Account</p>
                                </div>
                                <div class="profile-edit--section--body">
                                    <div class="profile-edit-details--sec profile-edit-details--gender">
                                        <div class="ped--gender-1">
                                            <label class="profile-edit--input-label">Gender</label>
                                            <select class="profile-edit--select--gender" onchange="updateGender();" id="gender" name="gender">
                                                <option value="m" <?php echo $user->gender === "M" ? "selected" : ""; ?>>MALE</option>
                                                <option value="f" <?php echo $user->gender === "F" ? "selected" : ""; ?>>FEMALE</option>
                                                <option value="o" <?php echo $user->gender === "O" ? "selected" : ""; ?>>OTHER</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="profile-edit-details--phone">
                                        <div class="ped--phone-1">
                                            <label class="profile-edit-details--sec profile-edit--input-label">Phone</label>
                                            <button type="button" class="ped--phone-change">Change</button>
                                        </div>
                                    </div>
                                    <div class="profile-edit-details--sec profile-edit-details--password">
                                        <div class="ped--password-1">
                                            <label class="profile-edit--input-label">Password</label>
                                            <button type="button" class="ped--password-change" onclick="openChangePasswordModal();">Change</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="update-notif" id="update-notif">
                <span id="update-notif--msg"></span>
            </div>

            <div class="change-password-modal" id="change-password-modal">
                <div class="change-password-modal--content">
                    <span id="change-password-modal--close" onclick="document.getElementById('change-password-modal').style.display = 'none';">X</span>
                    <div class="change-password-modal--form">
                        <form action="?" method="POST">
                            <div class="change-password-modal--form-in-sec change-password-modal--form-old-pass">
                                <label class="change-password-modal--label">Old password</label>
                                <input id="old-pass" class="change-password-modal--input" type="password" placeholder="Old password">
                            </div>

                            <div class="change-password-modal--form-in-sec">
                                <label class="change-password-modal--label">New password</label>
                                <input id="new-pass" class="change-password-modal--input" type="password" placeholder="New password">
                            </div>

                            <div class="change-password-modal--form-in-sec">
                                <label class="change-password-modal--label">Confirm new password</label>
                                <input id="c-new-pass" class="change-password-modal--input" type="password" placeholder="Confirm new password">
                            </div>

                            <div class="change-password-modal--form-in-sec">
                                <button class="change-password-modal--save" type="button" onclick="updatePassword();">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="../static/js/notif/notif-modal.js"></script>
        <script defer>
            updateNotifCount();

            // change gender of user
            function updateGender()
            {
                let newGender = document.getElementById('gender').value.charAt(0).toUpperCase();
                updateField('U_GENDER', newGender, "Gender updated successfully");
            }

            // update name of user
            function updateName(position)
            {
                let field = "";
                let newName = "";
                if(position === "f")
                {
                    newName = document.getElementById("fname").value.trim();
                    if(newName === "")
                    {
                        popupNotifMessageBox("Field can't be empty", 2000);
                    }
                    field = "U_FNAME"
                }
                else if(position === "l")
                {
                    newName = document.getElementById("lname").value.trim();
                    field = "U_LNAME";
                }

                if(newName === "")
                {
                    popupNotifMessageBox("Name field can't be empty", 2000);
                    return;
                }

                if(/(\d|[^a-zA-Z])/.test(newName))
                {
                    popupNotifMessageBox("Name field can't contain any special character or numeric value", 2000);
                    return;
                }

                updateField(field, newName, "Name updated");
            }

            function updatePassword()
            {
                let oldPass = document.getElementById('old-pass').value;
                let newPass = document.getElementById('new-pass').value;
                let cnewPass = document.getElementById('c-new-pass').value;

                if(newPass !== cnewPass)
                {
                    popupNotifMessageBox("New password and confirm new password must match", 2000);
                    return;
                }

                if(newPass.length < 6 || newPass === '' || cnewPass === '')
                {
                    popupNotifMessageBox("Password must be at least of length 6 and contain one or more numeric value and capital and small letter", 2000);
                    return;
                }

                let xhr = new XMLHttpRequest();
                xhr.open("GET", `./profile/update-pass.php?old=${oldPass}&new=${newPass}&cnew=${cnewPass}`, true);
                xhr.onreadystatechange = function() {
                    if(xhr.readyState == XMLHttpRequest.DONE)
                    {
                        if(xhr.status == 200)
                        {
                            if(xhr.responseText === "true")
                            {
                                popupNotifMessageBox("Password updated successfully", 2000);
                            }
                            else 
                                popupNotifMessageBox(xhr.responseText, 2000);
                        }
                        else
                            popupNotifMessageBox("Failed to update password", 2000);
                    }
                }
                xhr.send(null);
            }

            function updateField(key, value, msg)
            {
                if(key === '' || value === '')
                {
                    popupNotifMessageBox("Field can't be empty", 2000);
                    return;
                }

                let xhr = new XMLHttpRequest();
                xhr.open("GET", `./profile/update-profile.php?field=${key}&value=${value}`, true);

                xhr.onreadystatechange = function() {
                    if(xhr.readyState == XMLHttpRequest.DONE)
                    {
                        if(xhr.status == 200)
                            popupNotifMessageBox(msg, 2000);
                        else
                            popupNotifMessageBox("Failed to update", 2000);
                    }
                }

                xhr.send(null);
            }

            function popupNotifMessageBox(msg, time)
            {
                let updateMsgContainer = document.getElementById("update-notif");
                updateMsgContainer.style.display = "block";

                let updateMessage = document.getElementById("update-notif--msg");
                updateMessage.innerText = msg;

                setTimeout(() => {
                    updateMsgContainer.style.display = "none";
                }, time);
            }

            function openChangePasswordModal()
            {
                let passModal = document.getElementById("change-password-modal");
                passModal.style.display = "block";
            }
        </script>
    </body>
</html>