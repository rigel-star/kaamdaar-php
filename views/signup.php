<?php 
	session_start();

    require_once'/opt/lampp/htdocs/kaamdaar/utils.php';
    require_once ROOT_DIR . "/controllers/db/db_kaamdaar.php";
    require_once ROOT_DIR . "/models/user.php";

	function validate_regestration()
	{
		$error = [];
		if(!isset($_POST['submit']))
			return;

		if(empty(trim($_POST['fname'])))
			$error['fname'] = "Enter a valid first name";

		if(empty(trim($_POST['lname'])))
			$error['lname'] = "Enter a valid last name";

		if(empty(trim($_POST['phone'])))
			$error['phone'] = "Enter a valid phone";

		if(empty(trim($_POST['password'])))
			$error['password'] = "Enter password";

		if(!count($error))
		{
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$phone = $_POST['phone'];
			$password = $_POST['password'];
			$password = $_POST['gender'];

			$loc = get_user_location();
			$date = date('Y-m-d H:i:s');

			$new_user = new User(
								0, $fname, 
								$lname, $phone, 
								$password, "M", 
								$date, 
								$loc['country']. ', ' .$loc['city'], 
								$loc['lat']. ', '. $loc['lon']
							);

			$kdb = new KaamdaarDBHandler();
			$kdb->addUser($new_user);
			$kdb->close();

			$user_phone = $user->phone;
			$user_pass = $user->password;
			$user_id = 4;

			$cookie_time = time() + (86400 * 30 * 12);
            $HOME_URL = "/";

            setcookie('user_phone', $user_phone, $cookie_time, $HOME_URL);
            setcookie('user_pass', $user_pass, $cookie_time, $HOME_URL);
            setcookie('user_id', $user->id, $cookie_time, $HOME_URL);
            $_SESSION['user_phone'] = $user_phone;
            $_SESSION['user_pass'] = $user_pass;
            $_SESSION['user_id'] = $user->id;

			header('location:profile.php');
		}
	}

	validate_regestration();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User</title>
	<style type="text/css">
		label {
			display: inline-block;
			padding: 12px;
			width: 80px;
		}

		span {
			color: red;
		}

		#errmsg {
		    color: red;
		}

		div {
			position: absolute;
			left: 380px;
			top: 10px;
			width: auto;
		}

		div h1 {
			text-align: center;
		}

		fieldset {
			height: 420px;
			width: 100%;
			background-color: white;
		}

		.button_r {

		    position: relative;
		    margin: 10px;
		    left: 90px;
		    top: 30px;
		    border-radius: 5px;
		    height: 30px;
		    width: 60px;
		    color: white;
		    background-color: #2196f3;
		}

		form .input_tag {
		  border-top-style: hidden;
		  border-right-style: hidden;
		  border-left-style: hidden;
		  border-bottom-style: groove;
		}

		.input_tag:focus {
		  outline: none;
		}
	</style>
</head>
<body>
	<?php if(isset($errmsg)){ ?>
		<span id="errmsg"><?php echo $errmsg ?></span>
	<?php } ?>
</body>
	<div>
		<fieldset>
			<h1>Registration</h1>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
				<label for="fname">First name:</label>
				<input class="input_tag" type="text" name="fname" required>

				<span>
					<?php
		           	if(isset($error['fname'])) {
		           		echo $error['fname'];
		           	}
			     	?>
			    </span><br>

			    <label for="lname">Last name:</label>
				<input class="input_tag" type="text" name="lname" required>

				<span>
					<?php
		           	if(isset($error['lname'])) {
		           		echo $error['lname'];
		           	}
			     	?>
			    </span><br>


				<label for="phone">Phone:</label>
				<input class="input_tag" type="text" name="phone" required>

				<span>
					<?php
		           		if(isset($error['phone'])) {
		           			echo $error['phone'];
		           		}
			     	?>
			    </span><br>

				<label for="password">Password:</label>
				<input class="input_tag" type="password" name="password" required>

				<span>
					<?php
			           if(isset($error['password'])) {
			           		echo $error['password'];
			        	}
			    	?>
			    </span><br>

	    		<label>Gender</label>
		  		<input type="radio" name="gender" value="M"> Male

		  		<input type="radio" name="gender" value="F">Female 

		  		<input type="radio" name="gender" value="O">Others
		  	
		  		<span>
		  			<?php
			        	if(isset($error['gender'])) {
			           		echo $error['gender'];
			           	}
			     	?>
			    </span><br>

				<input id="register" class="button_r" type="submit" name="submit" value="Register">
	    		<input id="reset" class="button_r" type="reset" name="reset" value="Reset">
			</form>
		</fieldset>
	</div>
</body>
</html>