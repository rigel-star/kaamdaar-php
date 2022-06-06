<?php 
	require_once '../constants.php';
    require_once "k_auth.php";

	session_start();
	if(!isset($_SESSION['user_phone'])) header('location:login.php?route=profile.php');

	require_once '../utils.php';
	require_once ROOT_DIR . "controllers/db/db_kaamdaar.php";
	require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../static/css/nav.css">
		<link rel="stylesheet" href="../static/css/profile.css">

		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
    	<script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
		<script src="../static/js/profile-map.js" defer></script>
		
		<title>Profile</title>

		<style>
			.nav-link-active
			{
				color: blue;
				background-color: #E1EDFF;
				display: block;
				height: 40px;
				border-radius: 0 8px 8px 0;
				margin-left: 0px;
				transform: translateX(-20px);
				padding: 10px 0 0 20px;
			}
		</style>
	</head>
	<body>
		<div class="root">
			<div class="page-head">
				<div>
					<h2>Kaamdaar</h2>
				</div>
				<div>
					<input type="text" class="search-bar" placeholder="Search">
				</div>
			</div>
			<div class="page-body">
				<div id="nav-bar" class="nav-bar">
					<a href="#" class="nav-link"><span class="nav-link-active"><i class="fa fa-user" style="font-size:24px;"></i> Profile</span></a>
					<a href="bprofile.php" class="nav-link"><i class="fa fa-briefcase" style="font-size:24px"></i> Business Profile</a>
					<a href="requests.php" class="nav-link"><i class="fa fa-send" style="font-size:24px"></i> Your requests</a>
					<a href="notifications.php" class="nav-link"><i class="fa fa-bell" style="font-size:24px"></i> Notifications</a>
					<hr>
					<a href="add-request.php" class="nav-link">Add new request</a>
					<a href="add-business.php" class="nav-link">Add new business</a>
					<hr>
					<a href="logout.php" class="nav-link"><i class="fa fa-sign-out" style="font-size:24px"></i>Logout</a>
					<a href="settings.php" class="nav-link"><i class="fa fa-cog" style="font-size:24px"></i> Settings</a>
					<a href="#" class="nav-link"><i class="fa fa-print" style="font-size:24px"></i> Privacy policy</a>
				</div>
				<div class="page-content">
					<div class="pc-title">
						<div class="pct-1">
							<div class="pc-main-title">
								<h2>Profile</h2>
							</div>
							<div class="pc-sub-title">
								<h4>View and manage your profile</h4>
							</div>
						</div>
					</div>
					<?php 
						$korm = new KaamdaarORM();
						$uid = $_SESSION['user_id'];
						$user = $korm->getUserByID((int) $uid);
					?>
					<div class="profile-content">
						<div class="profile-top pdiv">
							<div class="pt-1"></div>
							<div class="pt-2">
								<img class="profile-pic" src="../static/images/profile.jpg" alt="Profile pic">
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
									<p>
										<?php $business_count = $korm->rawQuery("select count(*) as bcount from business where business_id = $uid")->current(); ?>
										<h3><?php echo $business_count['bcount']; ?></h3>
										business(es)
									</p>
									<p>
										<?php $business_count = $korm->rawQuery("select count(*) as bcount from request where request_id = $uid")->current(); ?>
										<h3><?php echo $business_count['bcount']; ?></h3>
										<br>
										Requests
									</p>
									<p>
										<h3>1</h3>
										<br>
										Ratings
									</p>
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

							<?php $user_loc = get_user_location(); ?>
							<div class="profile-map pdiv">
								<h4>You on map</h4>
								<p>Drag and drop to change your location</p>
								<div class="map" id="map"></div>
							</div>

							<script type="text/javascript">
								let latLong = <?php echo $user_loc['lat'] . " " . $user_loc['long']; ?>
								let markerArray = [[<?php echo $user_loc['long']; ?>, <?php echo $user_loc['lat']; ?>]];
								console.log("Hello");
							</script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>