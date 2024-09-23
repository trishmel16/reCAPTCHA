<?php
    session_start();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // reCAPTCHA verification
        $recaptcha_secret = "6LcR2kwqAAAAAE6ZPELzTtxtYD7gQ5JBV3Dykfll";
        $recaptcha_response = $_POST['g-recaptcha-response'];
        
        $verify_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $response_data = json_decode($verify_response);

        if ($response_data->success) {

            //sanitize data inputs from form
            $admin_username = htmlspecialchars($_POST['admin_admin_username']);
            $admin_pass = htmlspecialchars($_POST['admin_pass']);

            $_SESSION['admin_username'] = $admin_username;
            echo "<script>alert('Successfully login!'); window.location.href = 'admin.php';</script>";
        } else {
            // message if reCAPTCHA failed
            echo "<script>alert('reCAPTCHA verification failed. Please try again.'); window.location.href = 'login.php';</script>";
            exit();
        }
    } 
    ?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>reCAPTCHA Implementation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css">

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <div class="container">
            <h1>Login</h1>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="admin_username">Username:</label>
                    <input type="text" id="admin_username" name="admin_username" required>
                </div>
                <div class="form-group">
                    <label for="admin_pass">Password:</label>
                    <input type="password" id="admin_pass" name="admin_pass" required>
                </div>
                <div class="g-recaptcha" data-sitekey="6LcR2kwqAAAAAGqB5pV8sGTWIHvkCutYQqNqDV31"></div>
                <center><input type="submit" value="Submit" class="submit"></center>
            </form>
            <center><a href="index.php" class="box">Back</a></center>
        </div>
        
    </body>
</html>