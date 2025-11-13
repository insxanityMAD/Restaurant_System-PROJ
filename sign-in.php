
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
  $option = $_POST['choose'];
  
if (strlen($npassword) <= 12) {
  $message1 = "not valid";
  exit();
}else {
  $message1 = "valid";

}


  $stmt = $conn -> prepare("INSERT INTO signup_tbl (username, password, emailaddress, contactnumber, AccOption) 
  VALUES (?, ?, ?, ?, ?)");

  $stmt -> bind_param("sssss",  $nusername, $npassword, $eaddress,  $cnumber, $option);

  if ($stmt -> execute()) {
  $message = "inserted successfully";

}else {
  echo "error" . $stmt -> error;
}}




?>




<!DOCTYPE html>

<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
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




<label for = "eaddress" > email address </label>
<input type = "text" id = "eaddress" name = "email">

<labe> contact number </label>
<input type = "text" name = "contactnumber">




<label for = "select"> Signup as: </label>
<select id = "select" name = "choose"> 
<option value = "Admin"> Admin </option>
<option value = "User"> User </option>
<input  type = "submit" name = "clicked" > </input>
<a href = "login.php"> already signup? click to redirect to login page </a>

</select>
</form>








</html>


