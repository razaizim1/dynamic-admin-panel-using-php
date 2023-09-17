<?php

require_once('../config.php');
session_start();
$id = $_REQUEST['id'];

DeleteTableData('manufactures', $_REQUEST['id']);
$url = GET_APP_URL() . '/manufactures?success=Manufacture Delete Successfully';
header("location:$url");


?>