<?php
require_once('../config.php');
get_header();
// Get id from link
$id = $_REQUEST['id'];
// Get manufacture single data
$manufactureData = GetSingleData('manufactures', $id);

if (isset($_POST['edit_manufacture'])) {
    $manufacture_name = $_POST['manufacture_name'];
    $manufacture_address = $_POST['manufacture_address'];
    $manufacture_mobile = $_POST['manufacture_mobile'];

    // Own manufacture slug count
    $stm = $connection->prepare('SELECT mobile FROM manufactures WHERE mobile=?');
    $stm->execute(array($manufacture_mobile));
    $mobileCount = $stm->rowCount();

    // Own mobile count
    $stm = $connection->prepare("SELECT mobile FROM manufactures WHERE mobile=? AND id=?");
    $stm->execute(array($manufacture_mobile, $id));
    $ownMobileCount = $stm->rowCount();


    if (empty($manufacture_name)) {
        $error = 'Name is required';
    } elseif (empty($manufacture_address)) {
        $error = 'Address is required';
    } elseif (empty($manufacture_mobile)) {
        $error = 'Mobile is required';
    } elseif (strlen($manufacture_mobile) != 11) {
        $error = 'Mobile must be 11 digits';
    } elseif ($mobileCount != 0 && $ownMobileCount != 1) {
        $error = 'Mobile already exists';
    } else {

        // Manufacture update
        $stm = $connection->prepare('UPDATE manufactures SET name = ?,address =?,mobile=? WHERE user_id=? AND id=?');
        $stm->execute(array($manufacture_name, $manufacture_address, $manufacture_mobile, $_SESSION['user']['id'], $id));

        // Success message
        $success = 'Manufacture Update Successfully';
    }
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-5">Edit Manufacture</h4>
                    <div class="basic-form">
                        <form action="" method="POST">
                            <div class="form-group col-md-8 mx-auto">
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
                                <label for="manufacture_name">Manufacture Name</label>
                                <input type="text" class="form-control" name="manufacture_name"
                                    value="<?php echo $manufactureData['name']; ?>" id="manufacture_name"
                                    placeholder="Manufacture Name">
                            </div>
                            <div class="form-group col-md-8 mx-auto">
                                <label for="manufacture_address">Manufacture Address</label>
                                <input type="text" class="form-control" name="manufacture_address"
                                    value="<?php echo $manufactureData['address']; ?>" id="manufacture_address"
                                    placeholder="Manufacture Address">
                            </div>
                            <div class="form-group col-md-8 mx-auto">
                                <label for="manufacture_mobile">Manufacture Mobile</label>
                                <input type="text" class="form-control" name="manufacture_mobile"
                                    value="<?php echo $manufactureData['mobile']; ?>" id="manufacture_mobile"
                                    placeholder="Manufacture Mobile">
                            </div>

                            <div class="text-center">
                                <button type="submit" name="edit_manufacture" class="btn mb-1 btn-primary">Update
                                    Manufacture</button>

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