<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./static/index.css">
	<base href="/">
	<title>Home - Kaamdaar</title>
</head>
<body>

	<?php

		require_once '/Applications/XAMPP/htdocs/kaamdaar-php/constants.php';
    	require_once ROOT_DIR . "/views/k_auth.php";

		if(already_logged_in())
		{
			$uid = $_COOKIE['user_id'];
			header("location:views/profile.php");
			echo $uid;
		}
		else
		{
			header("location:views/login.php");
		}
	?>

</body>
</html>