<?php

require_once('../config.php');
session_start();
$id = $_REQUEST['id'];

// $stm = $connection->prepare('DELETE FROM categories WHERE id=?');
// $delete = $stm->execute(array($id));
DeleteTableData('categories', $_REQUEST['id']);
$url = GET_APP_URL() . '/categories/categories.php?success=Category Delete Successfully';
header("location:$url");


?>