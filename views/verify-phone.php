<?php 
    session_start();

    $route = '';
    if(isset($_GET['redirect']))
        $route = $_GET['redirect'];
    else 
    {
        echo "<h1>Cant't access this page.</h1>";
        die();
    }

    if(!isset($_SESSION['phone'])) header("location:$route");
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../static/css/verify-phone.css">
    </head>
    <body>
        <div class="header">
            <h1>Kaamdaar</h1>
        </div>

        <div class="container">
            <h2>Enter security code</h2>
            <hr width="100%">
            <p>Please solve the following captcha and check your phone for a message with your code. Your code is 6 numbers long.</p>
            <div id="captcha-container"></div>
            <input id="code-entry" type="text" placeholder="Enter code">
            <?php 
            $phone = $_SESSION['phone']; 
            $phone_len = strlen($phone);
            ?>
            <span>We will send your code to: <?php echo $phone[0].$phone[1] . "******" . $phone[$phone_len - 2].$phone[$phone_len - 1]; ?></span>

            <div class="error-field">
                <p id="error-head"></p>
                <p id="error-body"></p>
            </div>

            <hr width="100%">

            <div class="rfloat">
                <button class="form-btn cancel" onclick="location.href = '/';">Cancel</button>
                <button class="form-btn continue" onclick="verifyOTP();">Continue</button>
            </div>
        </div>

        <div class="footer">
            <span>Kaamdaar 2022</span>
        </div>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/firebase/7.14.1-0/firebase.js">
        </script>

        <script>
            const firebaseConfig = {
                apiKey: "AIzaSyD9-kR5IW-5shei47uNPaWXbVs8wM8X40A",
                authDomain: "kaamdaar-9e5b8.firebaseapp.com",
                projectId: "kaamdaar-9e5b8",
                storageBucket: "kaamdaar-9e5b8.appspot.com",
                messagingSenderId: "541123316972",
                appId: "1:541123316972:web:2c97cc389be21791e229c9",
                measurementId: "G-MKRPJLWD2H"
            };

            firebase.initializeApp(firebaseConfig);

            (function renderreCaptcha()
            {
                window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('captcha-container', {
                    size: "normal",
                    callback: sendOTP
                });
                window.recaptchaVerifier.render();
            })();

            function sendOTP()
            {
                const phone = "+9779803993178";
                console.log(`Sending OTP to ${phone}`);
                firebase.auth().signInWithPhoneNumber(phone, window.recaptchaVerifier)
                    .then(confirmationResult => {
                        window.confirmationResult = confirmationResult;
                        document.getElementsByClassName("error-field")[0].style.display = "none";
                    })
                    .catch(error => {
                        document.getElementsByClassName("error-field")[0].style.display = "block";
                        let errorHead = document.getElementById('error-head');
                        let errorBody = document.getElementById('error-body');

                        errorHead.innerHTML = error.code;
                        errorBody.innerHTML = error.message;
                    });
            };

            function verifyOTP()
            {
                const otp = document.getElementById("code-entry").value;
                window.confirmationResult.confirm(otp)
                    .then(() => {
                        location.href = '<?php echo $route . '?verified=1'; ?>';
                    })
                    .catch(() => {
                        document.getElementById('error-msg').innerHTML = "<p style='color: red;'>Couldn't verify phone. <b>Resend</b>";
                    });
            }
        </script>
    </body>
</html>