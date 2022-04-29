<?php 

	session_start();

	require_once'/opt/lampp/htdocs/kaamdaar/utils.php';
    require_once ROOT_DIR . "/views/k_auth.php";

    if(!already_logged_in()) header('location:login.php');

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="/">
	<title></title>

	<style type="text/css">
		*
		{
			margin: 0;
			padding: 0;
		}

		.container
		{
			display: grid;
			grid-template-columns: 1fr 4fr;
			width: 100%;
			height: 100%;
		}

		.navbar
		{
			height: 100vh;
			border-right: 1px solid black;
		}
		
		.app-title
		{
			display: flex;
			justify-content: space-between;
			padding:  5px;
		}

		.logo 
		{
			width: 200px;
			height: 50px;
		}

		.app-title-kaamdaar
		{
			font-size: 2em;
			color: red;
			font-family: sans-serif;
			font-weight: 500;
		}

		.content-body
		{
			background-size: cover;
		}

		.navbar-item 
		{
			padding-left: 20px;
			border-bottom: 0.01em solid grey;
		}

		.navbar-item-4
		{
			border-bottom: none;
		}

		.navbar-list-container
		{
			box-sizing: border-box;
			padding:  5px;
		}

		.navbar-list-container-3
		{
			border:  none;
		}

		.navbar-list-container ul
		{
			list-style-type: none;
			font-family: Tahoma, sans-serif;
		}

		.navbar-list-container ul li
		{
			font-size: 1em;
			margin: 10px 0 10px 0;
		}

		.navbar-list-container ul li:hover
		{
			color: purple;
			cursor: pointer;
		}

		.icon20x20
		{
			height: 20px;
			width: 20px;
		}


		/* profile body */
		.top-profile
		{
			display: flex;
			justify-content: start;
			font-family: Tahoma, sans-serif;
		}

		.top-profile div
		{
			padding: 10px;
		}

		#profile-picture
		{
			width: 150px;
			height: 150px;
		}

		#profile-name
		{
			font-size: 1.5em;
			font-family: Tahoma, sans-serif;
		}

		#profile-location
		{
			color: grey;
			font-size: 0.8em;
		}

		#profile-number
		{
			color: grey;
		}

		.top-profile-info-container
		{
			border-bottom: 1px solid black;
			width: 100%;
		}

		.cross-nav-bar:hover
		{
			cursor: pointer;
		}

		.business-cards
		{
			display: flex;
			flex-direction: row;
			flex-flow: wrap;
		}

		.business-card
		{
			border: 1px solid black;
			border-radius: 4px;
			width:  200px;
			height: 200px;
		}

		.business-card .business-card-img img {
			width:  50px;
			height: 50px;
		}

	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script>
		$(document).ready(() => {
				$(".cross-nav-bar").click(() => {
				$(".navbar").hide();
			});
		});
	</script>
</head>
<body>

	<?php 
		require_once'/opt/lampp/htdocs/kaamdaar/utils.php';
		require_once ROOT_DIR . "/controllers/db/db_kaamdaar.php";
	?>

	<div class="container">
		<div class="navbar">
			<div class="navbar-item navbar-item-1">
				<div class="app-title">
					<img class="logo" src="<?php echo url_for('images/logo.png'); ?>">
					<img class="cross-nav-bar" src="<?php echo url_for('icons/cross24x24.png'); ?>">
				</div>
			</div>

			<div class="navbar-item navbar-item-2">
				<div class="navbar-list-container navbar-list-container-1">
					<ul>
						<li>
							<img class="icon20x20" 
									src="<?php echo url_for('icons/user24x24.png'); ?>">
							<a href="kaamdaar/views/profile.php">Profile</a>
						</li>
						<li>
							<img class="icon20x20" 
									src="<?php echo url_for('icons/briefcase24x24.png'); ?>">
							<span>Business profile</span>
						</li>
						<li>
							<img class="icon20x20" 
									src="<?php echo url_for('icons/request24x24.png'); ?>">
							<span>Your requests</span>
						</li>
						<li>
							<img class="icon20x20" 
									src="<?php echo url_for('icons/notif24x24.png'); ?>">
							<span>Notifications</span>
						</li>
					</ul>
				</div>
			</div>

			<div class="navbar-item navbar-item-3">
				<div class="navbar-list-container navbar-list-container-2">
					<ul>
						<li>
							Add new request
						</li>
						<li>
							Add new business
						</li>
					</ul>
				</div>
			</div>

			<div class="navbar-item navbar-item-4">
				<div class="navbar-list-container navbar-list-container-3">
					<ul>
						<li>
							<a href="kaamdaar/views/logout.php">Logout</a>
						</li>
						<li>
							Settings
						</li>
						<li>
							Privacy policy
						</li>
					</ul>
				</div>
			</div>
			
		</div>

		<div class="content-body">

			<div class="top-profile">

				<div class="top-profile-pic-container">
					<img id="profile-picture" 
						src="<?php echo url_for('images/profile.jpg'); ?>" alt="Image">
				</div>

				<div class="top-profile-info-container">

					<?php
						require_once ROOT_DIR . "/controllers/db/db_kaamdaar.php";

						$kdb = new KaamdaarDBHandler();
						$uid = null;

						if(isset($_COOKIE['user_id']))
						{
							$uid = $_COOKIE['user_id'];
						}
						else if(isset($_SESSION['user_id']))
						{
							$uid = $_SESSION['user_id'];
						}
						else 
						{
							die("User with given id does not exist");
						}

						$user = $kdb->getUserWithID((int) $uid);
					?>

					<span id="profile-name">
						<?php echo $user->fname . " " . $user->lname; ?>
					</span>

					<span id="profile-location">
						<?php echo $user->location; ?>
					</span>
					<p id="profile-number"><?php echo $user->phone; ?></p>
					<div id="profile-edit">
						<button>Edit profile</button>
					</div>
				</div>
			</div>
			<h4>Your businesses</h4>
			<div class="business-cards">
				<div class="business-card">
					<div class="business-card-img">
						<img src="https://cdn-icons.flaticon.com/png/512/2365/premium/2365013.png?token=exp=1651080544~hmac=4ab07d99117eace7f407cf1830af9327">
					</div>
					<span>Painter</span>
					<div>
						<button>Manage</button>
						<button>History</button>
					</div>
				</div>
				<div class="business-card">
					<div class="business-card-img">
						<img src="https://cdn-icons.flaticon.com/png/512/2365/premium/2365013.png?token=exp=1651080544~hmac=4ab07d99117eace7f407cf1830af9327">
					</div>
					<span>Painter</span>
					<div>
						<button>Manage</button>
						<button>History</button>
					</div>
				</div>
				<div class="business-card">
					<div class="business-card-img">
						<img src="https://cdn-icons.flaticon.com/png/512/2365/premium/2365013.png?token=exp=1651080544~hmac=4ab07d99117eace7f407cf1830af9327">
					</div>
					<span>Painter</span>
					<div>
						<button>Manage</button>
						<button>History</button>
					</div>
				</div>
				<div class="business-card">
					<div class="business-card-img">
						<img src="https://cdn-icons.flaticon.com/png/512/2365/premium/2365013.png?token=exp=1651080544~hmac=4ab07d99117eace7f407cf1830af9327">
					</div>
					<span>Painter</span>
					<div>
						<button>Manage</button>
						<button>History</button>
					</div>
				</div>
			</div>
		</div>

	</div>
</body>
</html>