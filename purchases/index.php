<?php
require_once('../config.php');
get_header();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All Purchases</h4>
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
                                    <th scope="col">Manufacture Name</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $purchases = GetTableData('purchases');
                                $i = 1;
                                foreach ($purchases as $purchase):
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i++; ?>
                                        </td>
                                        <td>
                                            <?php
                                            // echo $purchase['manufacture_id'];
                                            echo $manufactureData = GetManufacturesData('name', $purchase['manufacture_id']);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            // echo $purchase['product_id'];
                                            echo $productData = GetProductsData('product_name', $purchase['product_id']);
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $purchase['group_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $purchase['quantity']; ?>
                                        </td>
                                        <td>
                                            <?php echo $purchase['total_price']; ?>
                                        </td>
                                        <td>
                                            <?php echo date('F j, Y', strtotime($purchase['created_at'])); ?>
                                        </td>
                                        <td>
                                            <span>
                                                <a href="<?php APP_URL(); ?>/purchases/edit.php?id=<?php echo $purchase['id']; ?>"
                                                    data-toggle="tooltip" data-placement="top" title="View"><i
                                                        class="fa fa-eye color-muted m-r-5"></i>
                                                </a> &nbsp;&nbsp;

                                                <a href="<?php APP_URL(); ?>/purchases/edit.php?id=<?php echo $purchase['id']; ?>"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-pencil color-muted m-r-5"></i>
                                                </a>&nbsp;&nbsp;

                                                <a onclick="return confirm('Are you sure');"
                                                    href="<?php APP_URL(); ?>/purchases/delete.php?id=<?php echo $purchase['id']; ?>"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-close color-danger"></i>
                                                </a>
                                            </span>
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