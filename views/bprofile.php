<?php 
    require_once "k_auth.php";

    if(!already_logged_in())
        header("location:login.php");

    require_once "../controllers/db/db_kaamdaar.php";
    require_once "../models/business.php";

    const business_icons = array(
        'plumber' => '../static/icons/business/plumber.png',
        'carpenter' => '../static/icons/business/carpenter.png'
    );

    $kdb = new KaamdaarDBHandler();
    $bp = $kdb->getBusinessProfile($_COOKIE["user_id"]);
?>

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

        <style>
			.nav-link-active
			{
				color: blue;
				background-color: #E1EDFF;
				display: block;
                width: 100%;
				height: 40px;
				border-radius: 0 8px 8px 0;
				margin-left: 0px;
				transform: translateX(-20px);
				padding: 10px 0 0 20px;
			}
		</style>

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
                    <a href="#" class="nav-link"><span class="nav-link-active"><i class="fa fa-briefcase" style="font-size:24px"></i> Business Profile</span></a>
                    <a href="requests.php" class="nav-link"><i class="fa fa-send" style="font-size:24px"></i> Your requests</a>
                    <a href="#" class="nav-link"><i class="fa fa-bell" style="font-size:24px"></i> Notifications</a>
                    <hr>
                    <a href="add-request.php" class="nav-link">Add new request</a>
                    <a href="add-business.php" class="nav-link">Add new business</a>
                    <hr>
                    <a href="logout.php" class="nav-link"><i class="fa fa-sign-out" style="font-size:24px"></i>Logout</a>
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

                    <div class="business-profile">
                        <img style="border-radius: 50%; width: 150px; height: 150px;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnYxsipAyyKYPxVJ957_YTNY7U3biCPc6NKA&usqp=CAU" alt="Profile">
                        <div>
                            <div>
                                <span><?php echo $bp->name; ?></span>
                            </div>
                            <div>
                                <span>Pragati Karmacharya</span>
                            </div>
                        </div>
                    </div>

                    <ul class="bl">
                    <?php 
                    $businesses = $kdb->getAllBusinesses($bp->bid);
                    foreach($businesses as $bus)
                    {
                    ?>
                        <li class="bli">
                            <div class="bli-root">
                                <div class="bli-head">
                                    <img src="<?php echo business_icons[$bus->category]; ?>" alt="Icon">
                                    <span>
                                        <strong><?php echo ucwords($bus->category); ?></strong>
                                    </span>
                                    <i class="fa fa-ellipsis-v td-icon" style="font-size:24px"></i>
                                </div>
                                <div class="bli-stat">
                                    <div class="bli-st-i bli-total">
                                        <p>Total served</p>
                                        <p><strong><?php echo $bus->total_served; ?></strong></p>
                                        <p>On last 30 days</p>
                                    </div>
                                    <div class="bli-st-i bli-rev">
                                        <p>Gross revenue</p>
                                        <p><strong><?php echo $bus->gross_revenue; ?></strong></p>
                                    </div>
                                    <div class="bli-st-i bli-rating">
                                        <p>Rating</p>
                                        <p><strong><?php echo $bus->rating; ?></strong></p>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php
                        }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>