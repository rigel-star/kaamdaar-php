<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../static/css/nav.css">
		<link rel="stylesheet" href="../static/css/request.css">

		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
        <div class="root">
            <div class="page-head">
				<div>
					<h2>Kaamdaar</h2>
				</div>
				<div>
					<input type="text" class="search-bar" placeholder="Search">
				</div>
			</div>
        </div>
        <div class="page-body">
            <div id="nav-bar" class="nav-bar">
                <a href="profile.php" class="nav-link"><i class="fa fa-user" style="font-size:24px"></i> Profile</a>
                <a href="bprofile.php" class="nav-link"><i class="fa fa-briefcase" style="font-size:24px"></i> Business Profile</a>
                <a href="request.php" class="nav-link"><i class="fa fa-send" style="font-size:24px"></i> Your requests</a>
                <a href="#" class="nav-link"><i class="fa fa-bell" style="font-size:24px"></i> Notifications</a>
                <hr>
                <a href="add-request.php" class="nav-link">Add new request</a>
                <a href="add-business.php" class="nav-link">Add new business</a>
                <hr>
                <a href="#" class="nav-link"><i class="fa fa-sign-out" style="font-size:24px"></i>Logout</a>
                <a href="#" class="nav-link"><i class="fa fa-cog" style="font-size:24px"></i> Settings</a>
                <a href="#" class="nav-link"><i class="fa fa-print" style="font-size:24px"></i> Privacy policy</a>
            </div>
            <div class="page-content">
                <div class="pc-title">
                    <div class="pct-1">
                        <div class="pc-main-title">
                            <h2>All requests</h2>
                        </div>
                        <div class="pc-sub-title">
                            <h4>View all the requests you have made</h4>
                        </div>
                    </div>
                    <div class="pct-2">
                        <button class="new-r-btn">Add new</button>
                    </div>
                </div>
                <div>
                    <select name="View" id="view">
                        <option  selected disabled>Sort by</option>
                        <option value="date">By date</option>
                        <option value="urgency">By urgency</option>
                    </select>
                    <ul class="rl">
                        <li class="rli">
                            <div class="rli-root">
                                <div class="rli-head">
                                    <span><i class="fa fa-laptop" aria-hidden="true"></i></span>
                                    <span>
                                        <strong>Dummy Request Name</strong>
                                        <span>Urgency</span>
                                    </span>
                                    <i class="fa fa-ellipsis-v td-icon" style="font-size:24px"></i>
                                </div>
                                <div class="rli-body">
                                    <h5 id="time">4 min ago</h5>
                                    <span><h5 id="address">Sankhamul, Lalitpur</h5></span>
                                    <br>
                                    <a href="#"><button class="view-on-map">View on map <i class="fa fa-map" style="font-size:20px;"></i></button></a>
                                </div>
                            </div>
                        </li>
                        <li class="rli">
                            <div class="rli-root">
                                <div class="rli-head">
                                    <span><i class="fa fa-laptop" aria-hidden="true"></i></span>
                                    <span>
                                        <strong>Dummy Request Name</strong>
                                        <span>Urgency</span>
                                    </span>
                                    <i class="fa fa-ellipsis-v td-icon" style="font-size:24px"></i>
                                </div>
                                <div class="rli-body">
                                    <h5 id="time">4 min ago</h5>
                                    <span><h5 id="address">Sankhamul, Lalitpur</h5></span>
                                    <br>
                                    <a href="#"><button class="view-on-map">View on map <i class="fa fa-map" style="font-size:20px;"></i></button></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html> 
