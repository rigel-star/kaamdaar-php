<?php 
	session_start();

	require_once '/Applications/XAMPP/htdocs/kaamdaar-php/constants.php';
    require_once ROOT_DIR . "/views/k_auth.php";

    if(!already_logged_in()) header('location:login.php');
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

		<?php 
			require_once '/Applications/XAMPP/htdocs/kaamdaar-php/utils.php';
			require_once ROOT_DIR . "/controllers/db/db_kaamdaar.php";
		?>

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
					<a href="#" class="nav-link"><i class="fa fa-bell" style="font-size:24px"></i> Notifications</a>
					<hr>
					<a href="add-request.php" class="nav-link">Add new request</a>
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
								<h2>Profile</h2>
							</div>
							<div class="pc-sub-title">
								<h4>View and manage you profile</h4>
							</div>
						</div>
					</div>
					<?php 
					$kdb = new KaamdaarDBHandler();
					$uid = $_COOKIE['user_id'];
					$user = $kdb->getUserWithID((int) $uid);
					echo $user->fname;
					?>
				</div>
			</div>
		</div>
	</body>
</html>