

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

$sql = "SELECT Food_Type, COUNT(*) AS COUNT_id FROM menu_tbl GROUP BY Food_Type";

$result = $conn ->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row["Food_Type"] . " " . $row["COUNT_id"] . "<br>";
  }
}else {
  echo "0 result";
}

$conn -> close();
?>
