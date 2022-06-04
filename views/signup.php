<?php 
	session_start();

    require_once "../utils.php";
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
			$gender = $_POST['gender'];
			$date = date('Y-m-d H:i:s');
			$lat = $_POST['lat'];
			$lon = $_POST['lon'];
			$address = $_POST['address'];

			$new_user = new Model\User(
								0, 
								$fname, 
								$lname, 
								$phone, 
								$password,
								$gender, 
								$date, 
								$address, 
								$lat. ', '. $lon
							);

			$kdb = new KaamdaarDBHandler();
			$kdb->addUser($new_user);
			$kdb->close();

			$user_phone = $user->phone;
			$user_pass = $user->password;
			$user_id = $user->id;

            setcookie('user_phone', $user_phone, DEF_COOKIE_TIME, HOME_URL);
            setcookie('user_pass', $user_pass, DEF_COOKIE_TIME, HOME_URL);
            setcookie('user_id', $user->id, DEF_COOKIE_TIME, HOME_URL);
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
		*{
			font-family:Helvetica;
		}
		.label {
			display: inline-block;
			font-size:1.5em;
			padding: 12px;
			width: 30%;
			font-family: Roboto;
		}

	.container{
    position: absolute;
    background-color: #ffff;
    width: 500px;
    height: 500px;
    left: 35%;
    top: 15%;
    margin: 10px;
    border-radius: 10px;
    box-shadow: 2px 2px 9px rgb(184, 184, 184),
            -1px -1px 5px rgb(184, 184, 184);
}

.input_tag {
  width: 50%;
  height: 25px;
  margin-top: 5px;
  text-indent: 5px;
  font-size: 12.6pt;
  border-radius: 5px;
  border: solid 1.5px #D3D3D3;
  
}
input[type=text]:hover{
  box-shadow: 0 0 5pt 0.5pt #D3D3D3;
}
input[type=text]:focus {
  box-shadow: 0 0 5pt 2pt #D3D3D3;
  outline-width: 0px;
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


		.button_r {

		    position: relative;
		    margin: 10px;
		    left: 30px;
		    top: 40px;
		    border-radius: 5px;
		    height: 30px;
		    width: 200px;
		    color: white;
			border:none;
			font-size:1em;
		    background-color:rgb(255,185,70);
		}

		.input_tag:focus {
		  outline: none;
		}
	</style>

	<script type="text/javascript" src="./utils.js"></script>
</head>
<body>
	<?php if(isset($errmsg)){ ?>
		<span id="errmsg"><?php echo $errmsg ?></span>
	<?php } ?>
	<div class="container">
	        <h1>Registration</h1>
			<hr style="width:80%">
			<form method="POST" action="verify-phone.php">
				<label for="fname" class="label">First name:</label>
				<input class="input_tag" type="text" name="fname" >

				<span>
					<?php
		           	if(isset($error['fname'])) {
		           		echo $error['fname'];
		           	}
			     	?>
			    </span><br>

			    <label for="lname" class="label">Last name:</label>
				<input class="input_tag" type="text" name="lname" >

				<span>
					<?php
		           	if(isset($error['lname'])) {
		           		echo $error['lname'];
		           	}
			     	?>
			    </span><br>


				<label for="phone" class="label">Phone:</label>
				<input class="input_tag" type="text" name="phone" >

				<span>
					<?php
		           		if(isset($error['phone'])) {
		           			echo $error['phone'];
		           		}
			     	?>
			    </span><br>

				<label for="password" class="label">Password:</label>
				<input class="input_tag" type="password" name="password" >

				<span>
					<?php
			           if(isset($error['password'])) {
			           		echo $error['password'];
			        	}
			    	?>
			    </span><br>

	    		<label class="label">Select Gender</label>
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

				<?php 
				$lat_lon = get_user_location();
				$lat = $lat_lon['lat'];
				$lon = $lat_lon['lon'];
				?>

				<input id="lat" type="hidden" name="lat" value="<?php echo $lat; ?>"/>
				<input id="lon" type="hidden" name="lon" value="<?php echo $lon; ?>"/>
				<input id="location" type="hidden" name="address"/>
				
				<script>
					document.getElementById("location").value = getUserAddressByLatLon({
						latitude: <?php echo $lat; ?>,
						longitude: <?php echo $lon; ?>
					});
				</script>

				<input id="register" class="button_r" type="submit" name="submit" value="Register">
	    		<input id="reset" class="button_r" type="reset" name="reset" value="Reset">
			</form>
	</div>
</body>
</html>