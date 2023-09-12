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
        $stm->execute(array($user_id, $cat_name, $cat_slug, $now));
        $success = 'Category created successfully';
    }
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All Categories</h4>
                    <?php if (isset($_REQUEST['success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_REQUEST['success']; ?>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">

                        <table class="table table-bordered table-striped verticle-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Category Slug</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $categories = GetTableData('categories');
                                $i = 1;
                                foreach ($categories as $category):
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i++; ?>
                                        </td>
                                        <td>
                                            <?php echo ucwords($category['category_name']); ?>
                                        </td>
                                        <td>
                                            <?php echo $category['category_slug']; ?>
                                        </td>
                                        <td>
                                            <?php echo date('F j, Y', strtotime($category['created_at'])); ?>
                                        </td>
                                        <td><span><a href="<?php APP_URL(); ?>/categories/edit-category.php?id=<?php echo $category['id']; ?>"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-pencil color-muted m-r-5"></i> </a><a
                                                    onclick="return confirm('Are you sure');"
                                                    href="<?php APP_URL(); ?>/categories/delete-category.php?id=<?php echo $category['id']; ?>"
                                                    data-toggle="tooltip" data-placement="top" title="Close"><i
                                                        class="fa fa-close color-danger"></i></a></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <tbody>
                        </table>
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