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
                        <img id="profile-edit--img-src" src="https://dl.memuplay.com/new_market/img/com.vicman.newprofilepic.icon.2022-06-07-21-33-07.png" alt="Profile image">
                    </div>
                    <div class="profile-edit-details">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="profile-edit-details--sec profile-edit-details--fname">
                                <label class="profile-edit--input-label">First Name</label>
                                <input placeholder="First name" class="profile-edit--input" type="text" id="fname" name="fname" onchange="updateName('f');">
                            </div>
                            <div class="profile-edit-details--sec profile-edit-details--lname">
                                <label class="profile-edit--input-label">Last Name</label>
                                <input placeholder="Last name" class="profile-edit--input" type="text" id="lname" name="lname" onchange="updateName('l');">
                            </div>
                            <div class="profile-edit-details--phone">
                                <label class="profile-edit-details--sec profile-edit--input-label">Phone</label>
                                <input placeholder="New phone number" class="profile-edit--input" type="text" id="phone" name="phone">
                            </div>
                            <div class="profile-edit-details--sec profile-edit-details--gender">
                                <div class="ped--gender-1">
                                    <label class="profile-edit--input-label">Gender</label>
                                    <select class="profile-edit--select--gender" onchange="updateGender();" id="gender" name="gender">
                                        <option value="m">MALE</option>
                                        <option value="f">FEMALE</option>
                                        <option value="o">OTHER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="profile-edit-details--sec profile-edit-details--password">
                                <div class="ped--password-1">
                                    <label class="profile-edit--input-label">Password</label>
                                    <button class="ped--password-change">Change</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="update-notif" id="update-notif">
                <span id="update-notif--msg"></span>
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

            function updateName(position)
            {
                switch(position)
                {
                    case "f":
                        let newFname = document.getElementById("fname").value;
                        updateField('U_FNAME', newFname, "First name updated")
                        break;

                    case "l":
                        let newLname = document.getElementById("lname").value;
                        updateField('U_LNAME', newLname, "Last name updated");
                        break;
                }
            }

            function updateField(key, value, msg)
            {
                let xhr = new XMLHttpRequest();
                xhr.open("GET", `./profile/update-profile.php?field=${key}&value=${value}`, true);

                xhr.onreadystatechange = function() {
                    if(xhr.readyState == XMLHttpRequest.DONE)
                    {
                        let updateMsgContainer = document.getElementById("update-notif");
                        updateMsgContainer.style.display = "block";

                        let updateMessage = document.getElementById("update-notif--msg");

                        if(xhr.status == 200)
                            updateMessage.innerText = msg;
                        else
                            updateMessage.innerText = "Failed to update";
                        
                        setTimeout(() => {
                            updateMsgContainer.style.display = "none";
                        }, 2000);
                    }
                }

                xhr.send(null);
            }
        </script>
    </body>
</html>