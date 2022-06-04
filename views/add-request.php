<?php 
	require_once "../constants.php";
    require_once ROOT_DIR . "models/business-category.php";
	require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

    use Model\{BusinessCategory};

	$orm = new KaamdaarORM();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Request</title>

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<link rel="stylesheet" href="../static/css/nav.css">
		<link rel="stylesheet" href="../static/css/add-request.css">
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
					<a href="profile.php" class="nav-link"><i class="fa fa-user" style="font-size:24px"></i> Profile</a>
					<a href="bprofile.php" class="nav-link"><i class="fa fa-briefcase" style="font-size:24px"></i> Business Profile</a>
					<a href="requests.php" class="nav-link"><i class="fa fa-send" style="font-size:24px"></i> Your requests</a>
					<a href="notifications.php" class="nav-link"><i class="fa fa-bell" style="font-size:24px"></i> Notifications</a>
					<hr>
					<a href="#" class="nav-link">Add new request</a>
					<a href="add-business.php" class="nav-link">Add new business</a>
					<hr>
					<a href="logout.php" class="nav-link"><i class="fa fa-sign-out" style="font-size:24px"></i>Logout</a>
					<a href="#" class="nav-link"><i class="fa fa-cog" style="font-size:24px"></i> Settings</a>
					<a href="#" class="nav-link"><i class="fa fa-print" style="font-size:24px"></i> Privacy policy</a>
				</div>
				<div class="page-content">
					<div class="pc-title">
						<div class="pct-1">
							<div class="pc-main-title">
								<h2>Add new request</h2>
							</div>
							<div class="pc-sub-title">
								<h4>Send a new request</h4>
							</div>
						</div>
					</div>
					<div id="request">
						<?php 
						$categories = $orm->getBusinessCategories();
						session_start();
						$_SESSION['redirect-to'] = 'profile.php';
						?>

						<div class="business-cat-list">
							<?php 
							foreach($categories as $category)
							{
							?>
								<div class="bcli" onclick="location.href='location-finder.php'">
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
		</div>
	</body>
</html>