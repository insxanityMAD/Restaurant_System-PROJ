
<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['acc_type'] !== "User") {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>

<h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

</body>
</html>






<?php 

$message1 = "";

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "restaurant_db";
$conn = "";

$conn = mysqli_connect($server, $user, $pass, $db_name);


if ($conn -> connect_error) {
  die ("Connection Failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM menu_tbl";

$result = $conn ->query($sql);



if ($result->num_rows > 0) {

  
  while ($row = $result->fetch_assoc()) {
    echo  $row["id"] . " " . $row["Dish_Info"] . $row["Price"] . $row["Price"] . $row["Food_Type"] . "<br>";
  }
}else {
  echo "0 result";
}


$conn -> close();
?>
