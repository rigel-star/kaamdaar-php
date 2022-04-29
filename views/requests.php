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

		a
		{
			text-decoration: none;
			color: black;
		}

		a:hover
		{
			color: purple;
			cursor: pointer;
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

		.icon20x20
		{
			height: 20px;
			width: 20px;
		}

		.request-list
		{
			list-style-type: none;
		}

		.request-item
		{
			border: 1px solid black;
			display: inline-block;
			width: 500px;
			height: 200px;
		}
	</style>
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
					<img class="logo" src="<?php echo url_for("images/logo.png"); ?>">
					<img src="<?php echo url_for("icons/cross24x24.png"); ?>">
				</div>
			</div>

			<div class="navbar-item navbar-item-2">
				<div class="navbar-list-container navbar-list-container-1">
					<ul>
						<li>
							<img class="icon20x20" src="<?php echo url_for("icons/user24x24.png"); ?>">
							<span><a href="kaamdaar/requests/78">Profile</a></span>
						</li>
						<li>
							<img class="icon20x20" src="<?php echo url_for("icons/briefcase24x24.png"); ?>">
							<span><a href="kaamdaar/requests/78">Business profile</a></span>
						</li>
						<li>
							<img class="icon20x20" src="<?php echo url_for("icons/request24x24.png"); ?>">
							<span><a href="kaamdaar/requests/78">Your requests</a></span>
						</li>
						<li>
							<img class="icon20x20" src="<?php echo url_for("icons/business24x24.png"); ?>">
							<span><a href="kaamdaar/requests/78">Your businesses</a></span>
						</li>
						<li>
							<img class="icon20x20" src="<?php echo url_for("icons/notif24x24.png"); ?>">
							<span><a href="kaamdaar/requests/78">Notifications</a></span>
						</li>
					</ul>
				</div>
			</div>

			<div class="navbar-item navbar-item-3">
				<div class="navbar-list-container navbar-list-container-2">
					<ul>
						<li>
							<a href="kaamdaar/requests/78">Add new request</a>
						</li>
						<li>
							<a href="kaamdaar/requests/78">Add new business</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="navbar-item navbar-item-4">
				<div class="navbar-list-container navbar-list-container-3">
					<ul>
						<li>
							<a href="kaamdaar/requests/78">Settings</a>
						</li>
						<li>
							<a href="kaamdaar/requests/78">Privacy policy</a>
						</li>
					</ul>
				</div>
			</div>
			
		</div>

		<div class="content-body">
			<div>
				<?php 

					$kdb = new KaamdaarDBHandler();
					$rows = $kdb->fetchTableAll('painter_requests');

				?>
				<ul class="request-list">
					<li>
						<?php 
						foreach ($rows as $row) {
						?>
						<div class="request-item">
							<img src="">
							<span>Painter Request</span>
							<br>
							<span>Duration: <?php echo $row->getField('pr_date_started'); ?></span>
							<br>
							<span>Location: <?php echo $row->getField('pr_location'); ?></span>
							<br>
							<span>Pending</span>
							<br>
							<button>Cancel</button>
						</div>
						<?php } ?>
					</li>
				</ul>
			</div>
		</div>

	</div>
</body>
</html>