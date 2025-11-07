
<?php 
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

  $fname = $_POST['firstname'];
  $lname = $_POST['lastname'];
  $nusername = $_POST['username'];
  $npassword = $_POST['password'];
  $Gender = $_POST['gender'];
  $faddress = $_POST['fulladdress'];
  $eaddress = $_POST['email'];
  $cnumber = $_POST['contactnumber'];

  $stmt = $conn -> prepare("INSERT INTO signup_tbl (firstname, lastname, username, password, gender, fulladdress, emailaddress, contactnumber) 
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

  $stmt -> bind_param("ssssssss", $fname, $lname, $nusername, $npassword, $Gender, $faddress, $eaddress,  $cnumber);

  if ($stmt -> execute()) {
  $message = "inserted successfully";
}else {
  echo "error" . $stmt -> error;
}
}



?>


<!DOCTYPE html>

<head>

</head>

<body >
<h1> Create Account </h1>

<form method = "POST" action ="">

<label> first name </label>
<input type = text name = "firstname">



<label> last name </label>
<input type = text name = "lastname">

<label>new username </label>
<input type = text name = "username">



<label> new password </label>
<input type = password name = "password">


<p1> gender </p1>
<input type="radio" name="gender" value="Male" onclick="uncheckRadio(this)"> Male
<input type="radio" name="gender" value="Female" onclick="uncheckRadio(this)"> Female
<input type="radio" name="gender" value="Other" onclick="uncheckRadio(this)"> Other


<label> full address </label>
<input type = "text" name = "fulladdress">

<label> email address </label>
<input type = "text" name = "email">

<labe> contact number </label>
<input type = "text" name = "contactnumber">

<input  type = "submit" name = "clicked" > submit </input>

</form>








</html>

<script>
let lastChecked = null;

function uncheckRadio(radio) {
  if (radio === lastChecked) {
    radio.checked = false; // uncheck if clicked again
    lastChecked = null;
  } else {
    lastChecked = radio; // remember which was clicked
  }
}
</script>
