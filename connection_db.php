<?php
// db_connection.php

$server = "localhost";  // your server name
$username = "root";     // your DB username
$password = "";         // your DB password
$database = "restaurant_db"; // your database name

// Create connection
$conn = mysqli_connect($server, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully"; // optional for testing
?>
