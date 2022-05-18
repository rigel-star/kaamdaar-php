<?php 
    session_start();

    require_once "/Applications/XAMPP/htdocs/kaamdaar-php/constants.php";
    require_once ROOT_DIR . "/utils.php";
    require_once ROOT_DIR . "/views/k_auth.php";

    if(already_logged_in())
        header("location:profile.php");
?>

<!DOCTYPE html>
<html>
<head>    
    <title>Kaamdaar - Login</title>
    <link rel="stylesheet" href="">

    <style>
        div {
            position: absolute;
            left: 380px;
            top: 80px;
            width: auto;
        }

        div h1 {
            text-align: center;
        }

        div label {
            display: inline-block;
            margin: 22px;
            width: 60px;
        }

        form last-child {
            position: relative;
            height: 100px;
        }

        #btn_l {

            position: relative;
            margin: 10px;
            left: 175px;
            border-radius: 5px;
            height: 30px;
            width: 60px;
            color: white;
            background-color: #2196f3;
        }

        .rem_me {
            position: relative;
            display: inline-block;
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

        #btn_l:hover {
            background-color: green;
        }

        .error{
            color: red;
        }

        #login_failed {
            text-align: center;
            color: red;
        }

        form p {
            display:inline-block ;
            position:relative ;
            left: 23px;
            padding: 2px;
        }

        form a {
            text-decoration: none;
        }

        a:visited {
            color: blue;
        }

        a:hover {
            color: green;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <?php 

    require_once ROOT_DIR . "/utils.php";
    require_once ROOT_DIR . "/controllers/db/kaamdaar_orm.php";

    $kdb = new KaamdaarORM();
    $error = [];

    function validate_login()
    {
        global $error;
        global $kdb;

        if(!isset($_POST['login']))
            return;

        if(!isset($_POST['phone']) || empty(trim($_POST['phone'])))
            $error['phone'] = "Enter your phone";

        if(!isset($_POST['password']) || empty(trim($_POST['password'])))
            $error['password'] = "Enter your password";

        if(!count($error))
        {
            $user_phone = $_POST['phone'];
            $user_pass = $_POST['password'];

            $user = $kdb->getUserByPhone($user_phone);
            if($user)
            {
                if(md5($user_pass) != md5($user->password))
                {
                    $error['password'] = "Invalid password";
                    return;
                }

                if(isset($_POST['remember-me']))
                {
                    $cookie_time = time() + (86400 * 30 * 12);

                    $HOME_URL = "/";
                    setcookie('user_phone', $user_phone, $cookie_time, $HOME_URL);
                    setcookie('user_pass', $user_pass, $cookie_time, $HOME_URL);
                    setcookie('user_id', $user->id, $cookie_time, $HOME_URL);
                }

                $_SESSION['user_phone'] = $user_phone;
                $_SESSION['user_pass'] = $user_pass;
                $_SESSION['user_id'] = $user->id;

                header("location:profile.php");
            }
            else
            {
                $error['other'] = "Phone number is not registered.";
                return;
            }
        }
    }

    validate_login();

    ?>

    <div class="container">
        <fieldset>
        <form class="login-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" 
            method="POST">
            <h1>Login</h1>
            <label for="phone">Phone:</label>
                <input class="input_tag" type="text" placeholder="Phone" name="phone">
                <?php 
                    if(isset($error['phone'])) { 
                ?>
                        <span class="error"> 
                            <?php echo $error['phone']; ?>
                        </span>
                <?php 
                    } 
                ?>
                <br>
                <label for="password">Password:</label>
                <input type="password" class="input_tag" placeholder="Password" name="password">
                <?php 
                    if(isset($error['password'])) { 
                ?>
                        <span class="error"> 
                            <?php echo $error['password']; ?>
                        </span>
                <?php 
                    } 
                ?>
                <br>
                <input class="rem_me" type="checkbox" name="remember-me">
                Remember Me
                <br>
                <?php 
                    if(isset($error['other'])) { 
                ?>
                        <span class="error"> 
                            <?php echo $error['other']; ?>
                        </span>
                        <br>
                <?php 
                    } 
                ?>
                <input type="submit" name="login" value="Login" id="btn_l">
        </form>
        <a href="signup.php">Create an account</a>
        </fieldset>
    </div>
</body>
</html>