<?php
require_once('../config.php');
get_header();

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All Products</h4>
                    <?php if (isset($_REQUEST['success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_REQUEST['success']; ?>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive products">

                        <table class="table table-bordered table-striped verticle-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $products = GetTableData('products');
                                $i = 1;
                                foreach ($products as $product):
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i++; ?>
                                        </td>
                                        <td>
                                            <?php echo ucwords($product['product_name']); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $category_name = tblSingleData('category_name', 'categories', $product['product_category']);
                                            echo $category_name['category_name'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $product['product_description']; ?>
                                        </td>
                                        <td>
                                            <img src="../uploads/products/<?php echo $product['photo']; ?>"
                                                alt="<?php echo $product['product_category']; ?>">
                                        </td>
                                        <td>
                                            <?php echo date('F j, Y', strtotime($product['created_at'])); ?>
                                        </td>
                                        <td><span><a href="<?php APP_URL(); ?>/products/edit.php?id=<?php echo $product['id']; ?>"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-pencil color-muted m-r-5"></i> </a><a
                                                    onclick="return confirm('Are you sure');"
                                                    href="<?php APP_URL(); ?>/products/delete.php?id=<?php echo $product['id']; ?>"
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