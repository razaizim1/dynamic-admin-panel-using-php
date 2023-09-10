<?php
require_once('config.php');
session_start();


if (isset($_POST['register_form'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $business_name = $_POST['business_name'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $password = $_POST['password'];

    $phoneCount = InputCount('mobile', $mobile);
    $emailCount = InputCount('email', $email);
    echo $emailCount;

    if (empty($name)) {
        $error = 'Name is required';
    } elseif ($phoneCount != 0) {
        $error = 'Phone Number Already Exists';
    } elseif ($emailCount != 0) {
        $error = 'Email Already Exists';
    } elseif (empty($email)) {
        $error = 'Email is required';
    } elseif (empty($mobile)) {
        $error = 'Mobile is required';
    } elseif (empty($gender)) {
    } elseif (strlen($mobile <= 11)) {
        $error = 'Mobile must be at least 11 characters';
    } elseif (empty($gender)) {
        $error = 'Gender is required';
    } elseif (empty($date_of_birth)) {
        $error = 'Date of Birth is required';
    } elseif (empty($password)) {
        $error = 'Password is required';
    } else {
        $created_at = date('Y-m-d H:i:s');
        $date_of_birth = date('Y-m-d H:i:s');
        $emailCode = rand(11111, 99999);
        $mobileCode = rand(11111, 99999);
        $password = sha1($password);
        $username = strtolower($username);


        $stm = $connection->prepare("INSERT INTO users(name,username,email,mobile,password,business_name,address,gender,created_at,date_of_birth,email_code,mobile_code,status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?) ");
        $result = $stm->execute(array($name, $username, $email, $mobile, $password, $business_name, $address, $gender, $created_at, $date_of_birth, $emailCode, $mobileCode, 'pending'));
        print_r($result);

        if ($result == true) {
            // Success Message
            $success = 'Data inserted';

            // Mail Message
            $message = 'Your verification code is :' . $emailCode;
            mail($email, 'Verification Code', $message);

            // Create Session
            $_SESSION['user_email'] = $email;
            $_SESSION['user_mobile'] = $mobile;

            // Redirection
            header('location:verification.php');
        } else {
            $error = 'Error inserting';
        }

    }
}



; ?>


<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Our Store - Registration</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
        integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
                        <div class="card login-form mb-0 registration-card">
                            <div class="card-body pt-5 registration-body">
                                <a class="text-center" href="index.php">
                                    <h2>Registration</h2>

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
                                        <input type="text" name="name" value="<?php if (isset($_POST['register_form'])) {
                                            echo $_POST['name'];
                                        }
                                        ; ?>" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="username" value="<?php if (isset($_POST['register_form'])) {
                                            echo $_POST['username'];
                                        }
                                        ; ?>" class="form-control" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" value="<?php if (isset($_POST['register_form'])) {
                                            echo $_POST['email'];
                                        }
                                        ; ?>" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="mobile" value="<?php if (isset($_POST['register_form'])) {
                                            echo $_POST['mobile'];
                                        }
                                        ; ?>" class="form-control" placeholder="Mobile Number">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="business_name" value="<?php if (isset($_POST['register_form'])) {
                                            echo $_POST['business_name'];
                                        }
                                        ; ?>" class="form-control" placeholder="Business Name">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="address" value="<?php if (isset($_POST['register_form'])) {
                                            echo $_POST['address'];
                                        }
                                        ; ?>" placeholder="Address" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group radio">
                                        <label>Gender</label>
                                        <br>
                                        <label><input type="radio" value="Male" checked name="gender">Male</label>
                                        <br>
                                        <label><input type="radio" value="Female" name="gender">Female</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="date" name="date_of_birth" value="<?php if (isset($_POST['register_form'])) {
                                            echo $_POST['date_of_birth'];
                                        }
                                        ; ?>" class="form-control" placeholder="Date of Birth">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" value="<?php if (isset($_POST['register_form'])) {
                                            echo $_POST['password'];
                                        }
                                        ; ?>" class="form-control" placeholder="Password">
                                    </div>
                                    <button type="submit" name="register_form"
                                        class="btn login-form__btn submit w-100">Registration</button>
                                </form>
                                <p class="mt-5 login-form__footer">Have account <a href="login.php"
                                        class="text-primary">Login </a> now</p>
                                </p>
                            </div>
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