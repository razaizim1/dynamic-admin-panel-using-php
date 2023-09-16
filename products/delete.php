<?php

// require_once('../config.php');
// session_start();
// $id = $_REQUEST['id'];

// DeleteTableData('categories', $_REQUEST['id']);
// $url = GET_APP_URL() . '/categories?success=Category Delete Successfully';
// header("location:$url");

require_once('../config.php');
session_start();

$id = $_REQUEST['id'];

$stm = $connection->prepare("DELETE FROM products WHERE user_id =? AND id=?");
$stm->execute(array($_SESSION['user']['id'], $id));
header('location:' . GET_APP_URL() . '/products?success=Product delete successfully');


?>