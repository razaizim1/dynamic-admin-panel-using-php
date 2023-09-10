<?php
require_once('config.php');
session_start();
// echo $_SESSION['email_verify'];
// echo $_SESSION['mobile_verify'];
// unset($_SESSION['user_email']);



if (!isset($_SESSION['user_email']) and !isset($_SESSION['user_mobile'])) {
    header('location:login.php');

} else {

    // Email Verification
    if (isset($_POST['email_verification_form'])) {
        // $email_code = $_POST['email_code'];

        // Get email code from database
        $stm = $connection->prepare('SELECT email_code FROM users WHERE email=?');
        $stm->execute(array($_SESSION['user_email']));
        $getCode = $stm->fetch(PDO::FETCH_ASSOC);

        if (empty($_POST['email_code'])) {
            $error = 'Please enter a valid email code';

        } elseif ($getCode['email_code'] != $_POST['email_code']) {
            $error = "Code dosen't match";
        } else {
            // Verify email code and update status
            $stm = $connection->prepare('UPDATE users SET email_code=?,email_status=? WHERE email=?');
            $stm->execute(array('null', 1, $_SESSION['user_email']));

            // Suppose we create a session that contains value 1
            $_SESSION['email_verify'] = 1;

            //Success Message
            $success = 'Email verification successful';
        }
    }

    // Mobile Verification
    if (isset($_POST['mobile_verification_form'])) {
        $mobileCode = $_POST['mobile_code'];

        // Get mobile code from database
        $stm = $connection->prepare('SELECT mobile_code FROM users WHERE mobile=?');
        $stm->execute(array($_SESSION['user_mobile']));
        $getCode = $stm->fetch(PDO::FETCH_ASSOC);
        // print_r($getCode);

        if (empty($_POST['mobile_code'])) {
            $error = 'Please enter a valid mobile code';
        } elseif ($getCode['mobile_code'] != $_POST['mobile_code']) {
            $error = "Code dosen't match";
        } else {
            // Verify mobile code and update status
            $stm = $connection->prepare('UPDATE users SET mobile_code=?,mobile_status=? WHERE mobile=?');
            $stm->execute(array('null', 1, $_SESSION['user_mobile']));

            // Suppose we create a session that contains value 1
            $_SESSION['mobile_verify'] = 1;

            //Success Message
            $success = 'Mobile verification successful';
        }
    }
    // session_destroy();


}
?>

<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Our Store - User Verification</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="h-100">

    <!--*******************
    Preloader start
********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
    Preloader end
********************-->

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="verification.php">
                                    <h2>User Verification</h2>
                                </a>
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>


                                <!-- Email verification form -->
                                <?php if (isset($_SESSION['email_verify'])): ?>
                                    <div class="alert alert-success">
                                        Your email verification success!
                                    </div>
                                <?php else: ?>
                                    <form method="POST" action="" class="mt-5 mb-5 login-input">
                                        <?php if (!isset($_POST['email_verification_form'])): ?>
                                            <div class="alert alert-success">
                                                Please check your email:
                                                <?php echo $_SESSION['user_email']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <input type="text" name="email_code" class="form-control"
                                                placeholder="Email Code">
                                        </div>
                                        <button type="submit" name="email_verification_form"
                                            class="btn login-form__btn submit w-100">Vefiy Email</button>
                                    </form>
                                <?php endif; ?>


                                <!-- Mobile Verification Form -->
                                <?php if (isset($_SESSION['mobile_verify'])): ?>
                                    <div class="alert alert-success">
                                        Your mobile verification success!
                                    </div>
                                <?php else: ?>
                                    <form method="POST" action="" class="mt-5 mb-5 login-input">
                                        <?php if (!isset($_POST['mobile_verification_form'])): ?>
                                            <div class="alert alert-success">
                                                Please check your mobile number:
                                                <?php echo $_SESSION['user_mobile']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <input type="text" name="mobile_code" class="form-control"
                                                placeholder="Mobile Code">
                                        </div>
                                        <button type="submit" name="mobile_verification_form"
                                            class="btn login-form__btn submit w-100">Verify Mobile</button>
                                    </form>
                                <?php endif; ?>
                                <p class="mt-5 login-form__footer">Dont have account? <a href="registration.php"
                                        class="text-primary">Registration</a> now</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
    Scripts
***********************************-->
    <?php

    if (isset($_SESSION['email_verify']) and isset($_SESSION['mobile_verify'])) {
        $stm = $connection->prepare("UPDATE users SET status=? WHERE email_status=? AND mobile_status=? AND email=? AND mobile=?");
        $stm->execute(array("Active", 1, 1, $_SESSION['user_email'], $_SESSION['user_mobile']));
        unset($_SESSION['user_email']);
        unset($_SESSION['user_mobile']);
        unset($_SESSION['email_verify']);
        unset($_SESSION['mobile_verify']);
        ?>
        <script>
            setTimeout(function () {
                window.location.href = 'login.php';
            }, 2000);
        </script>
        <?php
    }
    ?>
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>

</html>