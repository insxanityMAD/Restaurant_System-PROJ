<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    session_start();

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "restaurant_db";

// Connect to database

$conn = mysqli_connect($server, $user, $pass, $db_name);

$sql = "DELETE FROM menu_tbl WHERE id = $id;";
    $conn->query($sql);    
}

header("location: /SYSTEM/crud-admin.php");
exit;


?>