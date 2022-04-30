<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../static/css/business.css">
        <style>
            * {
                padding: 0;
                margin: 0;
            }

            body {
                font-family: "Lato", sans-serif;
                margin-top: 10px;
            }

            .nav-bar {
                background-color: white;
                transition: width 0.15s;
                padding-right: 20px;
            }

            .nav-bar a {
                padding: 16px 8px 8px 10px;
                text-decoration: none;
                font-size: 20px;
                color: black;
                display: block;

            }

            .nav-bar a:hover {
                color: blue;
            }

            .body-header {
                cursor: pointer;
                font-size: 30px;
                margin: 20px 0 0 10px;
                vertical-align: top;
            }

            .page-head {
                display: grid;
                grid-template-columns: 20% 80%;
            }

            .page-head h2 {
                display: inline-block;
            }

            .search-bar {
                display: inline-block;
                width: 50%;
                height: 40px;
            }
        </style>
    </head>

    <body>
        <div class="root">
            <div class="page-head">
                <div>
                    <span class="nav-bar-toggler" onclick="toggleNavbar()">&#9776;</span><h2>Kaamdaar</h2>
                </div>
                <div>
                    <input type="text" class="search-bar" placeholder="Search">
                </div>
            </div>
            <div class="page-body">
                <div id="nav-bar" class="nav-bar">
                    <a href="#" class="nav-link"><i class="fa fa-user" style="font-size:24px"></i> Profile</a>
                    <a href="#" class="nav-link"><i class="fa fa-briefcase" style="font-size:24px"></i> Business Profile</a>
                    <a href="#" class="nav-link"><i class="fa fa-send" style="font-size:24px"></i> Your requests</a>
                    <a href="#" class="nav-link"><i class="fa fa-bell" style="font-size:24px"></i> Notifications</a>
                    <hr>
                    <a href="#" class="nav-link">Add new request</a>
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
                                        <strong>Auto mobile repair</strong>
                                    </span>
                                    <i class="fa fa-ellipsis-v td-icon" style="font-size:24px"></i>
                                </div>
                                <div class="bli-stat">
                                    <div class="bli-st-i bli-total">
                                        <p>Total served</p>
                                        <strong>5</strong>
                                        <p>On last 30 days</p>
                                    </div>
                                    <div class="bli-st-i bli-rev">
                                        <p>Gross revenue</p>
                                        <strong>0.0</strong>
                                    </div>
                                    <div class="bli-st-i bli-rating">
                                        <p>Rating</p>
                                        <strong>4.5</strong>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="bli">
                            <div class="bli-root">
                                <div class="bli-head">
                                    <span><i class="fa fa-paw" aria-hidden="true"></i></span>
                                    <span>
                                        <strong>Vet</strong>
                                    </span>
                                    <i class="fa fa-ellipsis-v td-icon" style="font-size:24px"></i>
                                </div>
                                <div class="bli-stat">
                                    <div class="bli-st-i bli-total">
                                        <p>Total served</p>
                                        <strong>1</strong>
                                        <p>On last 30 days</p>
                                    </div>
                                    <div class="bli-st-i bli-rev">
                                        <p>Gross revenue</p>
                                        <strong>0.0</strong>
                                    </div>
                                    <div class="bli-st-i bli-rating">
                                        <p>Rating</p>
                                        <strong>4</strong>
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