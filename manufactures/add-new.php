<?php
require_once('../config.php');
get_header();
$user_id = $_SESSION['user']['id'];

if (isset($_POST['create_category'])) {
    $manufacture_name = $_POST['manufacture_name'];
    $manufacture_address = $_POST['manufacture_address'];
    $manufacture_mobile = $_POST['manufacture_mobile'];

    $stm = $connection->prepare("SELECT mobile FROM manufactures WHERE user_id=?");
    $stm->execute(array($_SESSION['user']['id']));
    $mboileCount = $stm->rowCount();

    if (empty($manufacture_name)) {
        $error = 'Name is required';
    } elseif (empty($manufacture_address)) {
        $error = 'Address is required';
    } elseif (empty($manufacture_mobile)) {
        $error = 'Mobile is required';
    } elseif (!is_numeric($manufacture_mobile)) {
        $error = 'Mobile number must be a number';
    } elseif (strlen($manufacture_mobile) != 11) {
        $error = 'Mobile number must be 11 digits';
    } elseif ($mboileCount != 0) {
        $error = 'Mobile number already exists';
    } else {
        $now = date('Y-m-d H:i:s');

        $stm = $connection->prepare('INSERT INTO manufactures (user_id,name,address,mobile,created_at) VALUES(?,?,?,?,?)');
        $stm->execute(array($user_id, ucwords($manufacture_name), $manufacture_address, $manufacture_mobile, $now));
        $success = 'Category created successfully';
    }
}

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body col-md-10 mx-auto my-3">
                    <div>
                        <h4 class="card-title text-center">Create New Manufacture</h4>
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
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="cat_name">Manufacture Name</label>

                                <input type="text" id="cat_name" <?php if (isset($_POST['create_manufacture'])): ?>
                                        value="<?php echo $manufacture_name; ?>" <?php endif; ?> class="form-control"
                                    name="manufacture_name" placeholder="Manufacture Name">
                            </div>
                            <div class="form-group">
                                <label for="manufacture_address">Manufacture Address</label>

                                <input type="text" id="manufacture_address" <?php if (isset($_POST['create_manufacture'])): ?>
                                        value="<?php echo $manufacture_address; ?>" <?php endif; ?> class="form-control"
                                    name="manufacture_address" placeholder="Manufacture Address">
                            </div>
                            <div class="form-group">
                                <label for="manufacture_mobile">Manufacture Mobile</label>

                                <input type="text" id="manufacture_mobile" <?php if (isset($_POST['create_manufacture'])): ?> value="<?php echo $manufacture_mobile; ?>"
                                    <?php endif; ?> class="form-control" name="manufacture_mobile"
                                    placeholder="Manufacture Mobile">
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="create_category"
                                    class="btn mb-1 btn-primary">Create</button>
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