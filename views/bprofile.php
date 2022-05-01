<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		
        <link rel="stylesheet" href="../static/css/nav.css">
		<link rel="stylesheet" href="../static/css/business.css">

		<title>Business Profile</title>
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
            <div class="page-body">
                <div id="nav-bar" class="nav-bar">
                    <a href="profile.php" class="nav-link"><i class="fa fa-user" style="font-size:24px"></i> Profile</a>
                    <a href="#" class="nav-link"><i class="fa fa-briefcase" style="font-size:24px"></i> Business Profile</a>
                    <a href="#" class="nav-link"><i class="fa fa-send" style="font-size:24px"></i> Your requests</a>
                    <a href="#" class="nav-link"><i class="fa fa-bell" style="font-size:24px"></i> Notifications</a>
                    <hr>
                    <a href="addreq.php" class="nav-link">Add new request</a>
                    <a href="#" class="nav-link">Add new business</a>
                    <hr>
                    <a href="#" class="nav-link"><i class="fa fa-sign-out" style="font-size:24px"></i>Logout</a>
                    <a href="#" class="nav-link"><i class="fa fa-cog" style="font-size:24px"></i> Settings</a>
                    <a href="#" class="nav-link"><i class="fa fa-print" style="font-size:24px"></i> Privacy policy</a>
                </div>
                <div class="page-content">
                    <div class="pc-title">
                        <div class="pct-1">
                            <div class="pc-main-title">
                                <h2>All businesses</h2>
                            </div>
                            <div class="pc-sub-title">
                                <h4>View all the businesses you own</h4>
                            </div>
                        </div>
                        <div class="pct-2">
                            <button class="new-b-btn">Start new</button>
                        </div>
                    </div>
                    <ul class="bl">
                        <li class="bli">
                            <div class="bli-root">
                                <div class="bli-head">
                                    <span><i class="fa fa-car" aria-hidden="true"></i></span>
                                    <span>
                                        <strong>Dummy Business Name</strong>
                                    </span>
                                    <i class="fa fa-ellipsis-v td-icon" style="font-size:24px"></i>
                                </div>
                                <div class="bli-stat">
                                    <div class="bli-st-i bli-total">
                                        <p>Total served</p>
                                        <strong>?</strong>
                                        <p>On last 30 days</p>
                                    </div>
                                    <div class="bli-st-i bli-rev">
                                        <p>Gross revenue</p>
                                        <strong>?</strong>
                                    </div>
                                    <div class="bli-st-i bli-rating">
                                        <p>Rating</p>
                                        <strong>?</strong>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>