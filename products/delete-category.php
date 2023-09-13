<?php

require_once('../config.php');
session_start();
$id = $_REQUEST['id'];

DeleteTableData('categories', $_REQUEST['id']);
$url = GET_APP_URL() . '/categories?success=Category Delete Successfully';
header("location:$url");


?>