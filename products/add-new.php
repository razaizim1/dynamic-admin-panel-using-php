<?php
require_once('../config.php');
get_header();
$user_id = $_SESSION['user']['id'];

if (isset($_POST['create_product'])) {
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_description = $_POST['product_description'];
    $photo = $_FILES['photo'];

    $target_dir = "../uploads/products/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $photoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    if (empty($product_name)) {
        $error = 'Product Name is required';
    } elseif (empty($product_category)) {
        $error = 'Product Category is required';
    } elseif (empty($product_description)) {
        $error = 'Product Description is required';
    } elseif (empty($photo['name'])) {
        $error = 'Photo is required';
    } elseif ($photoFileType != 'jpg' && $photoFileType != 'png' && $photoFileType != 'jpeg') {
        $error = 'Photo must be JPG or PNG or JPEG';
    } else {

        $now = date('Y-m-d H:i:s');
        $photoName = $user_id . '-' . rand(1111, 9999) . '-' . time() . '.' . $photoFileType;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir . $photoName);

        $stm = $connection->prepare('INSERT INTO products (user_id,product_name,product_category,product_description,photo,created_at) VALUES(?,?,?,?,?,?)');
        $stm->execute(array($user_id, $product_name, $product_category, $product_description, $photoName, $now));
        $success = 'Product created successfully';

    }
}

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body col-md-12 my-3">
                    <div>
                        <h4 class="card-title text-center">Create New Product</h4>
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
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="product_name">Product Name</label>

                                <input type="text" id="product_name" <?php if (isset($_POST['create_product'])): ?>
                                        value="<?php echo $product_name; ?>" <?php endif; ?> class="form-control"
                                    name="product_name" placeholder="Product Name">
                            </div>

                            <div class="form-group">
                                <label for="prodcut_category">Product Category:</label>

                                <select class="form-control" name="product_category" id="product_category">
                                    <?php
                                    $categories = GetTableData('categories');
                                    foreach ($categories as $category):
                                        ; ?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
                                    <?php endforeach; ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea name="product_description" class="summernote" id="product_description"
                                    cols="20" rows="10"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="photo">Photo Upload</label>
                                <input type="file" name="photo" class="form-control" id="photo" />
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" name="create_product" class="btn mb-1 btn-primary">Create</button>
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