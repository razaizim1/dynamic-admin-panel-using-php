<?php

require_once('config.php');
require_once('functions.php');
session_start();


if (isset($_POST['login_form'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $error = 'Username must be provided';
    } elseif (empty($password)) {
        $error = 'Password must be provided';
    } else {
        $password = sha1($password);

        $stm = $connection->prepare('SELECT * FROM users WHERE username = ? AND password=?');
        $stm->execute(array($username, $password));
        $result = $stm->rowCount();
        echo $result;

        if ($result != 0) {
            // Get all table
            $userData = $stm->fetch(PDO::FETCH_ASSOC);
            print_r($userData);

            if ($userData['email_status'] == 1 and $userData['mobile_status'] == 1) {
                // Update verification codes and status
                $stm = $connection->prepare('UPDATE users SET email_code = ?,mobile_code =?,status=? WHERE email=?');
                $stm->execute(array('null', 'null', 'verified', $userData['email']));

                // create a session
                $_SESSION['user'] = $userData;

                // Redirection
                header('location:index.php');
            } else {

                // Generate random verification code again
                $getEmailCode = rand(11111, 99999);
                $getMobileCode = rand(11111, 99999);

                // Update verificatio codes
                $stm = $connection->prepare('UPDATE users SET email_code = ?,mobile_code =? WHERE email=?');
                $stm->execute(array($getEmailCode, $getMobileCode, $userData['email']));

                // Mail Message
                $message = 'Your verification code is :' . $emailCode;
                mail($userData['email'], 'Verification Code', $message);


                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['user_email'] = $userData['email'];
                $_SESSION['user_mobile'] = $userData['mobile'];

                header('location:verification.php');
            }
        } else {
            $error = 'Invalid password';
        }
    }

}
if (isset($_SESSION['user'])) {
    header('location:index.php');
}

; ?>

<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Our Store - Login</title>
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
                                <a class="text-center" href="index.php">
                                    <h2>Login</h2>
                                </a>
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($success)): ?>
                                    <div class="alert alert-success">
                                        <?php echo $success; ?>
                                    </div>
                                <?php endif; ?>
                                <form method="POST" action="" class="mt-5 mb-5 login-input">
                                    <div class="form-group">
                                        <input type="text" name="username" value="<?php if (isset($_POST['login_form'])) {
                                            echo $_POST['username'];
                                        }
                                        ; ?>" class="form-control" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" value="<?php if (isset($_POST['login_form'])) {
                                            echo $_POST['password'];
                                        }
                                        ; ?>" class="form-control" placeholder="Password">
                                    </div>
                                    <button type="submit" name="login_form"
                                        class="btn login-form__btn submit w-100">Login</button>
                                </form>
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
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>

</html>