<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Request</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		body{
			font-family: "Lato", sans-serif;
		}
		form label{
			display: inline-block;
			margin: 10px;
			font-size: 18px;
			
		}
		#new{
			text-align: center;
		}
		form{
			margin-left: 150px;
		}
		#request{
			position: absolute;
			width: 50%;
			left: 30%;
			height: 400px;
			border-bottom: 1px solid;
		}
		textarea{
			padding: 10px;
			margin-left: 10px;
			margin-bottom: 20px;
			font-size: 16px;
		}
		#view_on_map{
			margin-bottom: 10px;
			margin-left: 30%;
		}
		#map{
			position: absolute;
			left: 40%;
			top: 75%;
		}


.sidenav {
    height: 100%;
    width: 300px;
    position: fixed;
    z-index: 1;
    top: 50px;
    left: 0;
    background-color: white;
    overflow-x: hidden;
    border: 1px solid;
    border-top: none;
}

.sidenav a {
    padding: 16px 8px 8px 32px;
    text-decoration: none;
    font-size: 20px;
    color: black;
    display: block;
}

.sidenav a:hover {
    color: blue;
}

.nav-bar-top {
    margin: 20px 0 0 20px;
}
	</style>
</head>
<body>
	<h1>Kaamdaar</h1>
    <div id="mySidenav" class="sidenav">
        <a href="#"><i class="fa fa-user" style="font-size:24px"></i> Profile</a>
        <a href="#"><i class="fa fa-briefcase" style="font-size:24px"></i> Business Profile</a>
        <a href="#"><i class="fa fa-send" style="font-size:24px"></i> Your requests</a>
        <a href="#"><i class="fa fa-bell" style="font-size:24px"></i> Notifications</a>

        <hr>

        <a href="#">Add new request</a>
        <a href="#">Add new business</a>

        <hr>

        <a href="#"><i class="fa fa-sign-out" style="font-size:24px"></i> Logout</a>
        <a href="#"><i class="fa fa-cog" style="font-size:24px"></i> Settings</a>
        <a href="#"><i class="fa fa-print" style="font-size:24px"></i> Privacy policy</a>
    </div>
	<h1 id="new">Add new request</h1>
	<div id="request">
		<form>
			<label>Request :</label>
			<select>
				<option selected disabled >Select</option>
				<option value="carpenter">Carpenter</option>
				<option value="plumber">Plumber</option>
				<option value="painter">Painter</option>
				<option value="electrician">Electrician</option>
				<option value="mechanic">Mechanic</option>
			</select> 
			<label>Select Urgency:</label>
			<select>
				<option selected disabled >Select</option>
				<option value="urgent">Urgent</option>
				<option value="timely">Timely</option>
			</select> <br>

			<label>Address:</label>
			<input type="text" name="address" placeholder="Enter address">
			<br>

			<label>Add description:</label><br>
			<textarea rows="10" cols="40"></textarea>
			<br>
			<button id="view_on_map" onclick="focus:#map">Pin on map <i class="fa fa-map" style="font-size:20px;"></i></button></a>

		</form>
	</div>
	<div id="map">
		<h1>HELLO ITS ME MAP</h1>
	</div>
	
</body>
</html>