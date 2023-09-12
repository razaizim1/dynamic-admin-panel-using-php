<?php
require_once('../config.php');
get_header();
$category = GetTableData('categories');
$id = $_REQUEST['id'];
echo $id;
$catData = GetCatData('categories', $id);

if (isset($_POST['edit_category'])) {
    $cat_name = $_POST['cat_name'];
    $cat_slug = $_POST['cat_slug'];
    $getCatSlug = tblDataCount('category_slug', 'categories', $cat_slug);
    $pattern = "/^[a-z-0-9]+$/";



    if (empty($cat_name)) {
        $error = 'Name is required';
    } elseif (empty($cat_slug)) {
        $error = 'Slug is required';
    } elseif ($getCatSlug != 0) {
        $error = 'Slug already exists';
    } elseif (!preg_match($pattern, $cat_slug)) {
        $error = "Don't use any special and upperchase characters and white space";
    } else {

        $stm = $connection->prepare('UPDATE categories SET category_name = ?,category_slug =? WHERE id=?');
        $stm->execute(array($cat_name, $cat_slug, $id));

        $success = 'Category Update Successfully';
    }
}

?>
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-5">Edit Category</h4>
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
                                <label>Category Name</label>
                                <input type="text" class="form-control" name="cat_name"
                                    value="<?php echo $catData['category_name']; ?>" placeholder="Category Name">
                            </div>
                            <div class="form-group col-md-8 mx-auto">
                                <label>Business Name</label>
                                <input type="text" class="form-control" name="cat_slug"
                                    value="<?php echo $catData['category_slug']; ?>" placeholder="Business Name">
                            </div>

                            <div class="text-center">
                                <button type="submit" name="edit_category" class="btn mb-1 btn-primary">Update
                                    Category</button>

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