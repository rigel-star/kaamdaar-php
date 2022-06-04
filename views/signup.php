<?php 
	session_start();

    require_once "../utils.php";
    require_once ROOT_DIR . "/controllers/db/db_kaamdaar.php";
    require_once ROOT_DIR . "/models/user.php";

	function identify_phone($phone)
	{
		$codes = [
			'977' => "np",
			'1' => 'us',
			'2' => 'uk'
		];

		$numeric_codes = array_keys($codes);
		implode('|', $numeric_codes);

		$pattern = "{(\+". implode('|', $numeric_codes) .")(?:\s*-?\s*)?([0-9]{10})}";
		$valid = preg_match($pattern, $phone, $matches);
		if(!$valid) return False;

		return [$codes[substr($matches[1], 1)], $matches[2]];
	}

	function valid_password($pass)
	{
		if(strlen($pass) < 6)
			return False;
		else 
		{	
			$lowAlpha = False;
			$capAlpha = False;
			$numeric = False;
			foreach(str_split($pass) as $char)
			{
				if(is_numeric($char)) $numeric = True;
				else if(ctype_lower($char)) $lowAlpha = True;
				else if(ctype_upper($char)) $capAlpha = True;
			}

			if(!(function($arr) {
				foreach($arr as $item)
					if(!$item) return False;
				return True;
			})([$lowAlpha, $capAlpha, $numeric]))
				return False;
		}
		return True;
	}

	$error = [];

	/* 
		PHP IIFE for validating regestration.
	*/
	(function ()
	{
		global $error;

		if(!isset($_POST['submit']))
			return;

		if(!isset($_POST['fname']) || empty(trim($_POST['fname'])))
			$error['name'] = "First name not valid.";

		if(!isset($_POST['lname']) || empty(trim($_POST['lname'])))
			$error['name'] = "Last name not valid.";

		if(isset($_POST['phone']) && !empty(trim($_POST['phone'])))
		{
			$phone = $_POST['phone'];
			$info = identify_phone($phone);

			if(!$info)
				$error['phone'] = "Please enter valid phone number.";
		}
		else $error['phone'] = "Please enter phone number.";

		if(!isset($_POST['password']) || empty(trim($_POST['password'])))
			$error['password'] = "Password can't be empty";

		if(!valid_password($_POST['password']))
			$error['password'] = "Password has to be at least of length 6 with one or more numeric value and capital and small letter.";

		if(!isset($_POST['gender']))
			$error['gender'] = "Select gender";

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
								$lat. ', '. $lon,
								''
							);

			// $kdb = new KaamdaarDBHandler();
			// $kdb->addUser($new_user);
			// $kdb->close();

			$_SESSION['u_id'] = $user->id;
			$_SESSION['u_fname'] = $user->fname;
			$_SESSION['u_fname'] = $user->fname;
            $_SESSION['u_phone'] = $user->phone;
			$_SESSION['u_password'] = $user->password;
			$_SESSION['u_gedner'] = $user->gender;
			$_SESSION['u_date'] = $user->dateJoined;
			$_SESSION['u_location'] = $user->location;
			$_SESSION['u_latlong'] = $user->locLatLong;
			$_SESSION['u_image'] = $user->image;

			header('location:verify-phone.php');
		}
	})();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Signup - Kaamdaar</title>
		<link rel="stylesheet" href="../static/css/signup.css">
		<script type="text/javascript" src="./utils.js"></script>
	</head>
	<body>
		<div class="container">
			<h1>Signup</h1>
			<hr>

			<form method="POST" action="<?php echo 'verify-phone.php';//echo $_SERVER['PHP_SELF']; ?>">
				<div class="ifc-group ifcg-1">
					<div class="fullname-field">
						<div class="ifc">
							<input placeholder="First name" class="inputtext if-text fname" type="text" name="fname" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
						</div>
						<div class="ifc">
							<input placeholder="Last name" class="inputtext if-text lname" type="text" name="lname" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
						</div>
					</div>
					<?php if(isset($error['name'])) { ?>
						<span class="error">
							<?php echo $error['name']; ?>
						</span>
					<?php } ?>
				</div>

				<div class="ifc-group">
					<div class="ifc">
						<input placeholder="Phone" class="inputtext if-text phone" type="text" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
					</div>
					<?php if(isset($error['phone'])) { ?>
						<span class="error">
							<?php echo $error['phone']; ?>
						</span>
					<?php } ?>
				</div>

				<div class="ifc-group">
					<div class="ifc">
						<input placeholder="New password" class="inputtext if-text password" type="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
					</div>
					<?php if(isset($error['password'])) { ?>
						<span class="error">
							<?php echo $error['password']; ?>
						</span>
					<?php } ?>
				</div>

				<div class="ifc-group ifcg-4">
					<label class="ifc-label">Gender</label>
					<div>
						<div class="ifc if-radio">
							<span class="ifc-radio-label">Male </span><input class="inputradio male" type="radio" name="gender" value="M">
						</div>
						<div class="ifc if-radio">
							<span class="ifc-radio-label">Female </span><input class="inputradio female" type="radio" name="gender" value="F">
						</div>
						<div class="ifc if-radio">
							<span class="ifc-radio-label">Other </span><input class="inputradio other" type="radio" name="gender" value="O">
						</div>
					</div>
					<?php if(isset($error['gender'])) { ?>
						<span class="error">
							<?php echo $error['gender']; ?>
						</span>
					<?php } ?>
				</div>

				<script>
					var elements = document.getElementsByClassName("if-radio");
					for(let i = 0; i < elements.length; i++)
					{
						let element = elements.item(i);
						element.addEventListener('click', () => {
							let radio = element.getElementsByClassName('inputradio')[0];
							radio.checked = true;
						});
					}
				</script>

				<?php 
				// $lat_lon = get_user_location();
				// $lat = $lat_lon['lat'];
				// $lon = $lat_lon['lon'];
				?>

				<input id="lat" type="hidden" name="lat" value="<?php echo $lat; ?>"/>
				<input id="lon" type="hidden" name="lon" value="<?php echo $lon; ?>"/>
				<input id="location" type="hidden" name="address"/>
				
				<script>
					/*document.getElementById("location").value = getUserAddressByLatLon({
						latitude: <?php // echo $lat; ?>,
						longitude: <?php // echo $lon; ?>
					});*/
				</script>

				<input type="submit" name="submit" value="Signup" id="reg-btn">
			</form>

			<a style="display: block; text-align: center; font-size: 20px; color: blue; text-decoration: none;" href="login.php">Already have an account?</a>
		</div>
	</body>
</html>