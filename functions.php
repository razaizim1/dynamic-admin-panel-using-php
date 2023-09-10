<?php
function InputCount($col, $value)
{
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM users WHERE $col=?");
    $stm->execute(array($value));
    $count = $stm->rowCount();

    return $count;
}

// Get userdata
function userdata($id)
{
    global $connection;
    $stm = $connection->prepare('SELECT name,username,mobile,business_name,address,gender,date_of_birth,status,photos FROM users WHERE id=?');
    $stm->execute(array($id));
    $userData = $stm->fetch(PDO::FETCH_ASSOC);
    return $userData;
}