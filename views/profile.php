<?php 
	require_once '../constants.php';
    require_once "k_auth.php";

	session_start();
	if(!isset($_SESSION['user_phone'])) header('location:login.php?route=profile.php');

	require_once '../utils.php';
	require_once ROOT_DIR . "controllers/db/db_kaamdaar.php";
	require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

    $korm = new KaamdaarORM();
    $phone = $_SESSION['user_phone'];
    $user = $korm->getUserByPhone($phone);
    $uid = $user->id;
    $business_id = null;

    if(isset($_SESSION['business_id']))
    {
        $business_id = $_SESSION['business_id'];
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../static/css/base/layout.css">
		<link rel="stylesheet" href="../static/css/profile.css">
        <link rel="stylesheet" href="../static/css/modal/notif-modal.css">

		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<!-- <link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
    	<script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
		<script src="../static/js/map/profile-map.js" defer></script> -->
        <script src="../static/js/modal.js"></script>
		
		<title>Profile</title>
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
                <div class="nav-bar">
                    <div class="nav-links-cat">
                        <div class="nav-links-cat-head">
                            <p class="nav-links-cat-title">
                                Profile
                            </p>
                        </div>
                        <div class="nav-links-cat-body">
                            <ul class="nav-links-list">
                                <li class="nav-link nav-link-active">
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
                                <li class="nav-link">
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
					<div class="profile-content">
						<div class="profile-top pdiv">
							<div class="pt-1"></div>
							<div class="pt-2">
								<img class="profile-pic" src="<?php echo $_SESSION['user_image'] ?>" alt="Profile pic">
								<div class="pt-2-1">
									<h2 class="profile-name"><?php echo $user->fname . " " . $user->lname;?></h2>
									<p class="profile-loc"><?php echo $user->location; ?></p>
									<button class="profile-edit-btn">Edit your profile</button>
								</div>
							</div>
						</div>
						<div class="profile-middle">
							<div class="profile-about pdiv">
								<h4>About</h4>
								<p><?php echo $user->phone;?></p>
								<p><?php echo $user->location;?></p>
							</div>
							<div class="profile-stat pdiv">
								<h4>Insights</h4>
								<div>
                                    <div class="profile-stat-item profile-stat-1">
                                        <?php $business_count = $korm->rawQuery("select count(*) as bcount from business where business_id = '$business_id';")->current(); ?>
                                        <h3><?php echo $business_id ? $business_count['bcount'] : "0"; ?></h3>
                                        <p>business(es)</p>
                                    </div>
                                    <div class="profile-stat-item profile-stat-2">
                                        <?php $request_count = $korm->rawQuery("select count(*) as rcount from request where u_id = '$uid';")->current(); ?>
										<h3><?php echo $request_count['rcount']; ?></h3>
										<p>Request(s)</p>
                                    </div>
									<div class="profile-stat-item profile-stat-3">
										<h3>1</h3>
										<p>Rating(s)</p>
                                    </div>
								</div>
							</div>
						</div>
						<div class="profile-bottom">
							<div class="profile-recent-activity pdiv">
								<h4>Your recent activities</h4>
								<ul class="pra-list">
									<li class="pra-list-item">
										<div class="pra-li-root">
											<div class="pra-li-top">
												<span><i class="fa fa-laptop" aria-hidden="true"></i></span>
												<div>
													<h3 class="pra-bname">Computer Repair</h3>
													<p class="pra-boname">B. Tech Solutions</p>
												</div>
											</div>
											<div class="pra-li-bottom">
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star checked"></span>
												<span class="fa fa-star"></span>
												<span class="fa fa-star"></span>
												<span class="pra-review">I like it</span>
												<p class="pra-date">Date</p>
											</div>
										</div>
									</li>
								</ul>
							</div>

							<div class="profile-map pdiv">
								<h4>You on map</h4>
								<p>Drag and drop to change your location</p>
								<div class="map" id="map"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <script>
            (function updateNotifCount()
            {
                let countContainer = document.getElementById("notif-count");
                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = () => {
                    if(xhr.readyState == XMLHttpRequest.DONE)
                    {
                        if(xhr.status == 200)
                        {
                            var count = JSON.parse(xhr.responseText)?.notif_count;
                            if(!count || count == "0")
                                countContainer.style.display = "none";
                            else 
                            {
                                countContainer.style.display = "block";
                                countContainer.innerText = count;
                            }
                        }
                    }
                }

                xhr.open("GET", "./modal/fetch-notifs.php?count=10000000000&uid=<?php $_SESSION['user_id']; ?>&action=count", true);
                xhr.send();

                setInterval(() => { 
                    xhr.open("GET", "./modal/fetch-notifs.php?count=9999999999&uid=<?php $_SESSION['user_id']; ?>&action=count", true);
                    xhr.send();
                }, 10000);
            })();

            function createNotification(data)
            {
                let notifRoot = document.createElement("div");
                notifRoot.classList.add("notif-root", data.status == "0" ? "notif-unread" : "notif-read");

                let notifHead = document.createElement("div");
                notifHead.classList.add('notif-head');

                let notifHeadIcon = document.createElement("div");
                notifHeadIcon.classList.add('notif-head-icon');

                let notifHeadIconImg = document.createElement("img");
                notifHeadIconImg.classList.add('notif-head-icon-img');
                notifHeadIconImg.src = data.icon;

                let notifHeadTitle = document.createElement("div");
                notifHeadTitle.classList.add('notif-head-title');

                let notifProfile = document.createElement("p");
                notifProfile.classList.add('notif-profile');
                notifProfile.innerText = data.profile;

                let notifTitle = document.createElement("p");
                notifTitle.classList.add('notif-title');
                notifTitle.innerText = data.title;

                let notifBody = document.createElement("div");
                notifBody.classList.add('notif-body');

                let notifDesc = document.createElement("p");
                notifDesc.classList.add('notif-desc');
                notifDesc.innerText = data.description;

                let notifDate = document.createElement("p");
                notifDate.classList.add('notif-date');
                notifDate.innerText = data.time;

                notifHeadIcon.appendChild(notifHeadIconImg);
                notifHeadTitle.appendChild(notifProfile);
                notifHeadTitle.appendChild(notifTitle);
                notifHead.appendChild(notifHeadIcon);
                notifHead.appendChild(notifHeadTitle);

                notifBody.appendChild(notifDesc);
                notifBody.appendChild(notifDate);

                notifRoot.appendChild(notifHead);
                notifRoot.appendChild(notifBody);

                return notifRoot;
            }

            function createRequestNotification(data)
            {
                let notifItem = document.createElement("li");
                notifItem.classList.add("notif");

                let notif = createNotification(data);
                let actionBar = document.createElement("div");
                actionBar.classList.add('notif-action-bar');

                let offer = document.createElement('button');
                offer.innerText = "Offer service";
                offer.classList.add('notif-btn', "notif-offer-btn");

                offer.addEventListener("click", () => {
                    $.ajax({
                        url: `./offer-service.php?rec-id=${data.userId}&req-id=${data.requestId}&bus-id=1`,
                        success: () => {
                            console.log("OK");
                        },
                        error: () => {
                            console.log("bad");
                        }
                    });
                });

                actionBar.appendChild(offer);

                if(data.status == "1")
                    offer.disabled = true;

                notif.appendChild(actionBar);
                notifItem.appendChild(notif);
                return notif;
            }

            function createResponseNotification(type, data)
            {
                let notifItem = document.createElement("li");
                notifItem.classList.add("notif");

                let notif = createNotification(data);
                let actionBar = document.createElement("div");
                actionBar.classList.add('notif-action-bar');

                if(type === "res-res")
                {
                    let viewDetails = document.createElement('button');
                    viewDetails.innerText = "View details";
                    viewDetails.classList.add('notif-btn', 'notif-view-details-btn');
                    actionBar.appendChild(viewDetails);

                    if(data.status == "1")
                        viewDetails.disabled = true;
                }
                else if(type === "req-res")
                {
                    let accept = document.createElement("button");
                    accept.innerText = "Accept";
                    accept.classList.add('notif-btn', 'notif-accept-btn');

                    let reject = document.createElement("button");
                    reject.innerText = "Reject";
                    reject.classList.add('notif-btn', 'notif-reject-btn');

                    actionBar.appendChild(reject);
                    actionBar.appendChild(accept);

                    if(data.status == "1")
                    {
                        reject.disabled = true;
                        accept.disabled = true;
                    }
                }

                notif.appendChild(actionBar);
                notifItem.append(notif);
                return notif;
            }

            function showNotificationModal()
            {
                let modal = document.getElementById("notif-modal");
                modal.style.display = "block";

                let notifList = document.getElementsByClassName("notif-list")[0];

                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = () => {
                    if(xhr.readyState == XMLHttpRequest.DONE)
                    {
                        if(xhr.status == 200)
                        {
                            const notifications = JSON.parse(xhr.responseText);
                            if(notifications.length < 1)
                            {
                                let noNotifMsg = document.getElementsByClassName("no-notif-msg")[0];
                                noNotifMsg.style.display = "block";
                            }

                            for(const notification of notifications)
                            {
                                const notifModel = {
                                    icon: notification.ICON,
                                    profile: notification.PROFILE,
                                    title: notification.TITLE,
                                    description: notification.DESCRIPTION,
                                    time: notification.TIME,
                                    status: notification.STATUS,
                                    requestId: notification.REQUEST_ID
                                }

                                const notifType = notification.NOTIF_TYPE;
                                if(notifType === "REQUEST")
                                {
                                    notifModel.userId = notification.USER_ID;
                                    let notif = createRequestNotification(notifModel);
                                    notifList.appendChild(notif);
                                }
                                else if(notifType === 'RESPONSE')
                                {
                                    notifModel.receiver = notification.SENDER;
                                    notifModel.sender = notification.RECEIVER;

                                    let notif;
                                    const responseType = notification.RESPONSE_TYPE;
                                    if(responseType == "0")
                                        notif = createResponseNotification("req-res", notifModel);
                                    else if(responseType == "1")
                                        notif = createResponseNotification("res-res", notifModel);

                                    notifList.appendChild(notif);
                                } 
                            }
                        }
                    }
                }

                xhr.open("GET", "./modal/fetch-notifs.php?count=5&uid=1&action=fetch", true);
                xhr.send();

                window.onclick = (event) => {
                    if(event.target == modal)
                    {
                        modal.style.display = "none";
                        while(notifList.firstChild)
                        {
                            notifList.removeChild(notifList.firstChild);
                        }
                    }
                };
            }
        </script>
	</body>
</html>