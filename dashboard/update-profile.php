<?php
require_once('../config.php');
get_header();
$userData = $_SESSION['user'];

if (isset($_POST['updateProfile'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $business_name = $_POST['business_name'];
    $address = $_POST['address'];
    $get_username = tblDataCount('username', 'users', $username);



    if (empty($name)) {
        $error = 'Name is required';
    } elseif (empty($username)) {
        $error = 'Username is required';
    } elseif (empty($business_name)) {
        $error = 'Business name is required';
    } elseif (empty($address)) {
        $error = 'Address is required';
    } elseif ($get_username != 0) {
        $error = 'Username is already in use';
    }
}

?>
<div class="container-fluid">
    <div class="row">

    <div class="col-lg-12 mx-auto my-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-5">Update Profile</h4>
                    <div class="basic-form">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="<?php echo $userData['name']; ?>" placeholder="Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Business Name</label>
                                    <input type="text" class="form-control" name="business_name"
                                        value="<?php echo $userData['business_name']; ?>" placeholder="Business Name">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">

                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username"
                                        value="<?php echo $userData['username']; ?>" placeholder="1234 Main St">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address"
                                        value="<?php echo $userData['address']; ?>" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="photo">Photo Upload</label>
                                    <input type="file" name="photoUpload" class="form-control" id="photo" />
                                </div>
                            </div>
                            <div class="text-center">
                            <button type="submit" name="updateProfile" class="btn btn-dark">Update Profile</button>

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