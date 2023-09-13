<?php
// session_start();

// User input data count
function InputCount($col, $value)
{
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM users WHERE $col=?");
    $stm->execute(array($value));
    $count = $stm->rowCount();

    return $count;
}

// Table Data Count
function tblDataCount($col, $tbl, $value)
{
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM $tbl WHERE $col=?");
    $stm->execute(array($value));
    $count = $stm->rowCount();

    return $count;
}

// Get userdata
function userdata($id)
{
    global $connection;
    $stm = $connection->prepare('SELECT name,username,mobile,business_name,address,gender,date_of_birth,status,photo FROM users WHERE id=?');
    $stm->execute(array($id));
    $userData = $stm->fetch(PDO::FETCH_ASSOC);
    return $userData;
}

// Get Table Data
function GetTableData($tbl)
{
    global $connection;
    $stm = $connection->prepare("SELECT * FROM $tbl WHERE user_id=?");
    $stm->execute(array($_SESSION['user']['id']));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
// Get Table Single Data
function GetSingleData($tbl, $value)
{
    global $connection;
    $stm = $connection->prepare("SELECT * FROM $tbl WHERE user_id=? AND id=?");
    $stm->execute(array($_SESSION['user']['id'], $value));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Delete Table Data
function DeleteTableData($tbl, $id)
{
    global $connection;
    $stm = $connection->prepare("DELETE FROM $tbl WHERE user_id=? AND id=?");
    $delete = $stm->execute(array($_SESSION['user']['id'], $id));
    return $delete;
}

// App Url
function APP_URL()
{
    echo 'http://localhost/store';
}

function GET_APP_URL()
{
    return 'http://localhost/store';
}

function get_header()
{
    require_once('includes/header.php');
}
function get_footer()
{
    require_once('includes/footer.php');
}