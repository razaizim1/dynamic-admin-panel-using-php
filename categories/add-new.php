<?php
require_once('../config.php');
get_header();
$user_id = $_SESSION['user']['id'];

if (isset($_POST['create_category'])) {
    $cat_name = $_POST['cat_name'];
    $cat_slug = $_POST['cat_slug'];
    $slug_count = tblDataCount('category_slug', 'categories', $cat_slug);
    $pattern = "/^[a-z-0-9]+$/";

    if (empty($cat_name)) {
        $error = 'Name is required';
    } elseif (empty($cat_slug)) {
        $error = 'Slug is required';
    } elseif ($slug_count != 0) {
        $error = 'Slug already exists in category';
    } elseif (!preg_match($pattern, $cat_slug)) {
        $error = "Don't use any special and upperchase characters and white space";
    } else {
        $now = date('Y-m-d H:i:s');

        $stm = $connection->prepare('INSERT INTO categories (user_id,category_name,category_slug,created_at) VALUES(?,?,?,?)');
        $stm->execute(array($user_id, ucwords($cat_name), $cat_slug, $now));
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
                        <h4 class="card-title text-center">Create New Category</h4>
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
                                <label for="cat_name">Category Name</label>

                                <input type="text" id="cat_name" <?php if (isset($_POST['create_category'])): ?>
                                        value="<?php echo $cat_name; ?>" <?php endif; ?> class="form-control"
                                    name="cat_name" placeholder="Category Name">
                            </div>
                            <div class="form-group">
                                <label for="cat_slug">Category Slug</label>

                                <input type="text" id="cat_slug" <?php if (isset($_POST['create_category'])): ?>
                                        value="<?php echo $cat_slug; ?>" <?php endif; ?> class="form-control"
                                    name="cat_slug" placeholder="Category Slug">
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="create_category" class="btn mb-1 btn-primary">Create</button>
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