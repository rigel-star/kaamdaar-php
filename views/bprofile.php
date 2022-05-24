<?php 
    require_once "k_auth.php";

    if(!already_logged_in())
        header("location:login.php");

    require_once "../controllers/db/kaamdaar_orm.php";
    require_once "../models/business-profile.php";

    const business_icons = array(
        'plumber' => '../static/icons/business/plumber.png',
        'Auto Mobile Repair' => '../static/icons/business/carpenter.png'
    );

    $kdb = new KaamdaarORM();
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

                    <?php 
                        if(!$bp)
                        {
                            echo "You haven't set up your business profile.";
                            die('');
                        }
                    ?>

                    <div class="business-profile">
                        <div class="profile-top pdiv">
                            <div class="pt-1"></div>
                            <div class="pt-2">
                                <img class="profile-pic" src="../static/images/profile.jpg" alt="Profile pic">
                                <div class="pt-2-1">
                                    <h2 class="profile-name"><?php echo $bp->b_profile_name; ?></h2>
                                    <button class="profile-edit-btn">Edit your profile</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        var businessTypes = [];
                        var totalServed = [];
                        var rating = [];
                        var revenue = [];
                    </script>

                    <ul class="bl">
                    <?php 
                    $businesses = $kdb->getAllBusinessInfo($bp->b_profile_id);

                    if(count($businesses) < 1)
                    {
                        echo "You don't own any business. Start by creating one.";
                        die('');
                    }

                    foreach($businesses as $bus)
                    {
                    ?>
                        <li class="bli">
                            <div class="bli-root">
                                <div class="bli-head">
                                    <?php $type = $bus->business_type; ?>
                                    <img src="<?php echo business_icons[$type]; ?>" alt="Icon">
                                    <script>businessTypes.push("<?php echo $type; ?>");</script>
                                    <span>
                                        <strong><?php echo ucwords($type); ?></strong>
                                    </span>
                                    <i class="fa fa-ellipsis-v td-icon" style="font-size:24px"></i>
                                </div>
                                <div class="bli-stat">
                                    <div class="bli-st-i bli-total">
                                        <p>Total served</p>
                                        <p><strong><?php echo $bus->business_total; ?></strong></p>
                                        <script>totalServed.push(Number("<?php echo $bus->business_total;?>"));</script>
                                        <p>On last 30 days</p>
                                    </div>
                                    <div class="bli-st-i bli-rev">
                                        <p>Gross revenue</p>
                                        <p><strong><?php echo $bus->business_revenue; ?></strong></p>
                                        <script>revenue.push(Number("<?php echo $bus->business_revenue;?>"));</script>
                                    </div>
                                    <div class="bli-st-i bli-rating">
                                        <p>Rating</p>
                                        <p><strong><?php echo $bus->business_rating; ?></strong></p>
                                        <script>rating.push(parseFloat("<?php echo $bus->business_total;?>"));</script>
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

                    <div class="business-analytics">
                        <div>
                            <select name="chart-options" id="chart-options">
                                <option value="rev">
                                    Revenue
                                </option>
                                <option value="rat">
                                    Rating
                                </option>
                                <option value="tot" selected>
                                    Total Served
                                </option>
                            </select>
                        </div>
                        <canvas id="business-analytics-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
        <script src="business-chart.js"></script>
        <script>
            let label = "Total Served";
            let data = totalServed;
            const context = document.getElementById("business-analytics-chart").getContext("2d");
            let chart = generateChart(context, label, businessTypes, data);

            var businessAnalyticsOptions = document.getElementById("chart-options");
            businessAnalyticsOptions.addEventListener("change", function() {
                let chosen = this.value;
                if(chosen === "rat")
                {
                    label = "Rating";
                    data = rating;
                }
                else if(chosen === "tot")
                {
                    label = "Total";
                    data = totalServed;
                }
                else if(chosen == "rev")
                {
                    label = "Revenue";
                    data = revenue;
                }
                updateChart(chart, data, label);
            });
        </script>
    </body>
</html>