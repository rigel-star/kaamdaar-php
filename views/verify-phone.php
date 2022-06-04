<?php 
    session_start();
    if(!isset($_POST['phone'])) header("location:signup.php");
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
            <form action="?" method="POST">
                <h2>Enter security code</h2>
                <hr width="100%">
                <p>Please solve the following captcha and check your phone for a message with your code. Your code is 6 numbers long.</p>
                <div id="captcha-container"></div>
                <input id="code-entry" type="text" placeholder="Enter code">
                <?php 
                $phone = $_POST['phone']; 
                $phone_len = strlen($phone);
                ?>
                <span>We sent your code to: <?php echo $phone[0].$phone[1] . "******" . $phone[$phone_len - 2].$phone[$phone_len - 1]; ?></span>
                <hr width="100%">

                <div class="rfloat">
                    <button class="form-btn cancel"><a href="/">Cancel</a></button>
                    <button class="form-btn continue" type="submit">Continue</button>
                </div>
            </form>
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
                    })
                    .catch(error => {
                        console.log(error);
                    });
            };

            function verifyOTP()
            {
                const otp = document.getElementById("otp").value;
                window.confirmationResult.confirm(otp)
                    .then(() => {
                        window.location = "profile.php";
                    })
                    .catch(() => {
                        window.location = "signup.php";
                    });
            }
        </script>
    </body>
</html>