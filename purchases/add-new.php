<?php
require_once('../config.php');
get_header();
$user_id = $_SESSION['user']['id'];

if (isset($_POST['create'])) {
    $product_id = $_POST['product_id'];
    $manufacture_id = $_POST['manufacture_id'];
    $group_name = $_POST['group_name'];
    $per_item_price = $_POST['price'];
    $per_item_m_price = $_POST['manufacture_price'];
    $quantity = $_POST['quantity'];
    $expire_date = $_POST['expire_date'];


    if (empty($group_name)) {
        $error = 'Group Name is required';
    } elseif (empty($per_item_price)) {
        $error = 'Price is required';
    } elseif (empty($per_item_m_price)) {
        $error = 'Manufacture price is required';
    } elseif (empty($quantity)) {
        $error = 'Quantity is required';
    } elseif (empty($expire_date)) {
        $error = 'Expire date is required';
    } elseif (!is_numeric($per_item_price)) {
        $error = 'Total price must be number';
    } elseif (!is_numeric($per_item_m_price)) {
        $error = 'Total manufacture price must be number';
    } elseif (!is_numeric($quantity)) {
        $error = 'Quantity must be number';
    } else {

        $now = date('Y-m-d H:i:s');
        $total_price = $per_item_price * $quantity;
        $total_m_price = $per_item_m_price * $quantity;

        // Create groups
        $stm = $connection->prepare('INSERT INTO groups (user_id,group_name,product_id,quantity,expire_date,per_item_price,per_item_m_price,total_price,total_m_price,created_at) VALUES(?,?,?,?,?,?,?,?,?,?)');
        $stm->execute(array($user_id, $group_name, $product_id, $quantity, $expire_date, $per_item_price, $per_item_m_price, $total_price, $total_m_price, $now));
        $success = 'Product created successfully';

        // Create purchases
        $stm = $connection->prepare('INSERT INTO purchases (user_id,manufacture_id,product_id,group_name,quantity,per_item_price,per_item_m_price,total_m_price,total_price,created_at) VALUES(?,?,?,?,?,?,?,?,?,?)');
        $stm->execute(array($user_id, $manufacture_id, $product_id, $group_name, $quantity, $per_item_price, $per_item_m_price, $total_m_price, $total_price, $now));
        $success = 'Created successfully';

    }
}

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body col-md-12 my-3">
                    <div>
                        <h4 class="card-title text-center">Create New Purchases</h4>
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
                                <label for="product_id">Product Name</label>
                                <select class="form-control" name="product_id" id="product_id">
                                    <?php
                                    $products = GetTableData('products');
                                    foreach ($products as $product):
                                        ; ?>
                                        <option value="<?php echo $product['id']; ?>">
                                            <?php echo $product['product_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="manufacture_id">Manufacture</label>
                                <select class="form-control" name="manufacture_id" id="manufacture_id">
                                    <?php
                                    $manufactures = GetTableData('manufactures');
                                    foreach ($manufactures as $manufacture):
                                        ; ?>
                                        <option value="<?php echo $manufacture['id']; ?>">
                                            <?php echo $manufacture['name'] . ' - ' . $manufacture['mobile']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="group_name">Group Name</label>
                                <input type="text" name="group_name" class="form-control" id="group_name" />
                            </div>

                            <div class="form-group">
                                <label class="price-label" for="price">Price</label>
                                <input type="text" name="price" class="form-control" id="price" />
                            </div>
                            <div class="form-group">
                                <label class="price-label" for="manufacture_price">Manufacture Price</label>
                                <input type="text" name="manufacture_price" class="form-control"
                                    id="manufacture_price" />
                            </div>
                            <div class="form-group">
                                <label class="price-label" for="quantity">Quantity</label>
                                <input type="text" name="quantity" class="form-control" id="quantity" />
                            </div>
                            <div class="form-group">
                                <label class="price-label" for="expire_date">Expire Date</label>
                                <input type="date" name="expire_date" class="form-control" id="expire_date" />
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="create" class="btn mb-1 btn-primary">Create</button>
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