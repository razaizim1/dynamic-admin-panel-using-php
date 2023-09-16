<?php
require_once('../config.php');
get_header();
$category = GetTableData('categories');
// Get id from link
$id = $_REQUEST['id'];
// Get category single data
$catData = GetSingleData('categories', $id);

if (isset($_POST['edit_product'])) {
    $prodcut_name = $_POST['prodcut_name'];
    $product_description = $_POST['product_description'];
    // $photo = $_FILES['product_photo'];

    if (empty($prodcut_name)) {
        $error = 'Name is required';
    } else {

        // Category update
        $stm = $connection->prepare('UPDATE products SET product_name = ?,product_description=? WHERE user_id=? AND id=?');
        $stm->execute(array($prodcut_name, $product_description, $_SESSION['user']['id'], $id));

        // Success message
        $success = 'Category Update Successfully';
    }
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-5">Edit Product</h4>
                    <div class="basic-form">
                        <form action="" method="POST" enctype="multipart/form-data">
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

                                <?php
                                $products = GetTableData('products');
                                ; ?>

                                <label>Product Name</label>
                                <input type="text" class="form-control" name="prodcut_name"
                                    value="<?php echo $products[0]['product_name']; ?>" placeholder="Product Name">
                            </div>
                            <div class="form-group col-md-8 mx-auto">
                                <label for="prodcut_category">Product Category:</label>

                                <select disabled class="form-control" name="product_category" id="product_category">
                                    <?php
                                    $categories = GetTableData('categories');
                                    foreach ($products as $product):
                                        ; ?>
                                        <option value="<?php echo $products[0]['product_category']; ?>"><?php $category = tblSingleData('category_name', 'categories', $products[0]['product_category']);
                                           echo $category['category_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-8 mx-auto">
                                <input type="text" name="product_description" class="form-control"
                                    placeholder="Product Description">
                            </div>
                            <!-- <div class="form-group col-md-8 mx-auto">
                                <label for="product_photo">Change Product Photo</label>
                                <input type="file" name="product_photo" id="product_photo" class="form-control">
                            </div> -->

                            <div class="text-center">
                                <button type="submit" name="edit_product" class="btn mb-1 btn-primary">Update
                                    Product</button>
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