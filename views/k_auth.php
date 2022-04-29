<?php 

	function already_logged_in()
	{
		return (isset($_COOKIE['user_phone']) && isset($_COOKIE['user_pass'])) ||
			(isset($_SESSION['user_phone']) && isset($_SESSION['user_pass']));
	}

?>