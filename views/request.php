<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../static/css/request.css">
</head>
<body>
    <span class="nav-bar-top" style="font-size:30px;cursor:pointer" onclick="toggleNavbar()">&#9776;</span><h1>Kaamdaar</h1>
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

    <div id="body">
        <input id="search" type="text" name="search" placeholder="Search here" >
        <span><a href="#"><input id="add" type="button" name="submit" value="Add new"></a></span>
        <h2>All requests</h2>
        <h5>View all request you have made</h5>
        <hr>
        <select name="View" id="view">
            <option  selected disabled>Sort by</option>
            <option value="date">By date</option>
            <option value="urgency">By urgency</option>
        </select>

        <div id="request">
            <h2><i class="fa fa-laptop" style="font-size:30px"></i>Computer repair</h2> 
            <span style="color:red;" id="urgency">Uregent</span>
            <br>
            <h5 id="time">4 min ago</h5>
            <span><h5 id="address">Sankhamul,Lalitpur</h5></span>
            <br>
            <a href="#"><button id="view_on_map">View on map <i class="fa fa-map" style="font-size:20px;"></i></button></a>
        </div>

    </div>

    <script>
        var navbarOpen = true;
        function toggleNavbar()
        {
            if(navbarOpen){
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("body").style.marginleft = "0";

            }else{
                document.getElementById("mySidenav").style.width = "300px";
                document.getElementById("body").style.marginleft = "300px";
                
            }
            navbarOpen = !navbarOpen;
        }
    </script>

</body>
</html> 
