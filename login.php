<?php

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "restaurant_db";
$conn = "";

$conn = mysqli_connect($server, $user, $pass, $db_name);


if ($conn) {
    echo "You are connected.";

}else {
    echo "error";
}

if (isset($_POST['clicked'])) {

$user = $_POST['uname'];
$pass = $_POST['pword'];

$sql = "INSERT INTO login_tbl (username, password)
VALUES ('$user', '$pass')";

if (mysqli_query($conn, $sql)) {

echo "inserted successfully";
}else {
    echo "error_inserting" . mysqli_error($conn);
}

}




?>

<!DOCTYPE html>
<html lang = "en">

<head>
    
</head>


<body>

<h1> Restaurant Ordering Management System </h1>

<form method = "POST" action = "">


<p1> Log-in </p1>
<input type = "text" name = "uname"> 
<input type = "password" name = "pword">
<input type ="submit" name = "clicked" > 
<p2> Already have an account? </p2> <a href = "sign-in.php"> Click this to sign-up.</a>

//this is a comment....
//tngina mo mark!! HAHHAHAHA sample rani ha

</form>
</body>








</html>