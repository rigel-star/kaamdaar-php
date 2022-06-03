<?php 
    session_start();

    require_once "../constants.php";
    require_once "../utils.php";
    require_once "k_auth.php";

    if(already_logged_in())
    {
        $_SESSION['user_phone'] = $_COOKIE['user_phone'];
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        header("location:profile.php");
    }
    else if(isset($_SESSION['user_phone']))
    {
        header("location:profile.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>    
        <title>Kaamdaar - Login</title>
        <link rel="stylesheet" href="../static/css/login.css">
    </head>
    <body>
        <?php 
        require_once ROOT_DIR . "utils.php";
        require_once ROOT_DIR . "controllers/db/kaamdaar_orm.php";

        $kdb = new KaamdaarORM();
        $error = [];

        function validate_login()
        {
            global $error;
            global $kdb;

            if(!isset($_POST['login']))
                return;

            if(!isset($_POST['phone']) || empty(trim($_POST['phone'])))
                $error['phone'] = "Please enter your phone to proceed";

            if(!isset($_POST['password']) || empty(trim($_POST['password'])))
                $error['password'] = "Please enter password to proceed";

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
                        setcookie('user_id', $user->id, $cookie_time, $HOME_URL);
                    }

                    $_SESSION['user_phone'] = $user_phone;
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
            <form class="login-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <h1>Login</h1>
                <input class="input_tag" type="text" placeholder="Enter your phone" name="phone"><br>
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
                <input type="password" class="input_tag" placeholder="Enter your password" name="password">
                <br>
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
                <span id="rm">Remember Me</span>
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
                <hr style="width:85%">
                <div class="ca">
                    <a href="" class="pca">Create Account</a>
                </div>
            </form>
        </div>
    </body>
</html>