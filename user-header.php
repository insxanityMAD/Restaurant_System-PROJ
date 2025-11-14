

<?php 

$message1 = "";

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "restaurant_db";
$conn = "";

$conn = mysqli_connect($server, $user, $pass, $db_name);

if ($conn) {
  echo "connected successfully";
}else {
  echo "error";
}

    $sql = "SELECT * FROM signup_tbl WHERE emailaddress = ?";

    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("s", $email); 
    $stmt -> execute();
    $result = $stmt -> get_result();
     $user = $result -> fetch_assoc();
$_SESSION['username'] = $user['username'];

    echo "Hi, " . $user['username'];




?>
