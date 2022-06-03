<html>
    <body>
        <input type="text" id="otp" name="otp">

        <div id="captcha-container"></div>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/firebase/7.14.1-0/firebase.js">
        </script>

        <script>
            const firebaseConfig = {
                apiKey: process.env.FIREBASE_AUTH_TOKEN, //"AIzaSyD9-kR5IW-5shei47uNPaWXbVs8wM8X40A",
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

        <button id="submit" onclick="verifyOTP()">Verify</button>
    </body>
</html>