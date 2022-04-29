<?php 

	$users = [4, 5, 3, 9];

	if(isset($_GET['id']))
	{
		if(in_array((int) $_GET['id'], $users))
		{
			echo "Hello user " . $_GET['id'];
		}
		else
			echo "Get lost";
	}
	else
		header("location:/user/4");
?>