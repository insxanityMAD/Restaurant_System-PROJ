
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

if (isset($_POST['clicked'])) {

  
  $nusername = $_POST['username'];
  $npassword = PASSWORD_HASH($_POST['password'], PASSWORD_BCRYPT);
  $eaddress = $_POST['email'];
  $cnumber = $_POST['contactnumber'];

  
if (strlen($npassword) <= 12) {
  $message1 = "not valid";
  exit();
}else {
  $message1 = "valid";

}


  $stmt = $conn -> prepare("INSERT INTO signup_tbl (username, password, emailaddress, contactnumber) 
  VALUES (?, ?, ?, ?)");

  $stmt -> bind_param("ssss",  $nusername, $npassword, $eaddress,  $cnumber);

  if ($stmt -> execute()) {
  $message = "inserted successfully";
}else {
  echo "error" . $stmt -> error;
}}




?>




<!DOCTYPE html>

<head>

</head>

<body >
<h1> Create Account </h1>

<?php 


if ($message1) echo "<p style = 'color:red;'> $message1 </p>"


?>

<form method = "POST" action ="">



<label>new username </label>
<input type = text name = "username">



<label> new password </label>
<input type = password name = "password"




<label> email address </label>
<input type = "text" name = "email">

<labe> contact number </label>
<input type = "text" name = "contactnumber">

<input  type = "submit" name = "clicked" > submit </input>

</form>








</html>


