<?php
require_once('../config.php');
get_header();
$currentPass = $_SESSION['user']['password'];

if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    $current_password = sha1($current_password);
    $new_pass = sha1($new_pass);
    $confirm_new_password = sha1($confirm_new_password);


    if (empty($current_password)) {
        $error = 'Please enter current password';
    } elseif (empty($new_pass)) {
        $error = 'Please enter a new password';
    } elseif (empty($confirm_new_password)) {
        $error = 'Please re-type the new password';
    } elseif ($new_pass != $confirm_new_password) {
        $error = 'New password & confirm password must be same';
    } elseif ($currentPass != $current_password) {
        $error = "Current password dosen't match";
    } elseif ($currentPass == $new_pass && $currentPass != $confirm_new_password) {
        $error = 'This is your old password';
    } else {
        $stm = $connection->prepare('UPDATE users SET password=? WHERE id=?');
        $stm->execute(array($new_pass, $_SESSION['user']['id']));
        $success = 'Password changed successfully';
    }
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto my-5">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h4 class="card-title text-center">Change Password</h4>
                    </div>
                    <div class="basic-form">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success">
                                <?php echo $success; ?>
                            </div>
                            <script>
                                setTimeout(() => {
                                    window.location.href = "logout.php";
                                }, 2000);
                            </script>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" class="form-control" name="current_password"
                                    placeholder="Current Password">
                            </div>
                            <div class="form-group">
                                <label>New password</label>
                                <input type="password" name="new_password" class="form-control"
                                    placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <label>Confirm new password</label>
                                <input type="password" name="confirm_new_password" class="form-control"
                                    placeholder="Confirm new password">
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="change_password" class="btn btn-dark">Change
                                    Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #/ container -->
</div>
<!--**********************************
            Content body end
        ***********************************-->
<?php get_footer(); ?>