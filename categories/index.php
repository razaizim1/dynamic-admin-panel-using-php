<?php
require_once('../config.php');
get_header();
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
                                            <?php echo $category['category_name']; ?>
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
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
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