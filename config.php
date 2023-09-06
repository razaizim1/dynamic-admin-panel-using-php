<?php
$hostname = "localhost";
$database = "our_store";
$username = "root";
$password = "";

try {
    $connection = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

require_once('functions.php');

// function emailPhoneCount($value, $col)
// {
//     global $connection;
//     $stm = $connection->prepare('SELECT $col FROM users WHERE $col =?');
//     $stm->execute(array($value));
//     $rowCount = $stm->rowCount();
//     return $rowCount;
// }

// $stm = $connection->prepare('SELECT * FROM users INNER JOIN students ON users.id = students.user_id');
// $stm->execute();
// $result = $stm->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// print_r($result);



// require_once('functions.php');