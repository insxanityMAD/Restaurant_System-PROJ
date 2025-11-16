
<?php 

$message1 = "";

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "restaurant_db";
$conn = "";

$conn = mysqli_connect($server, $user, $pass, $db_name);

if ($conn) {
 
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
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Create Account</title><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Create Account</title>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #141414; /* dark background */
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .signup-container {
        width: 380px;
        background-color: #1c1c1c; /* dark box */
        padding: 40px;
        border-radius: 8px;
        color: white;
        box-shadow: 0 0 20px rgba(255, 153, 0, 0.5); /* orange glow */
        text-align: center; /* center content */
    }

    /* Logo image styling */
    .signup-container img {
        width: 170px;
        height: 170px;
        margin-bottom: 15px;
        border-radius: 50%; /* optional round logo */
    }

    .signup-container h2 {
        margin-bottom: 25px;
        font-weight: bold;
        color: #ff9900; /* bright orange */
    }

    .signup-container label {
        display: block;
        margin-top: 12px;
        font-size: 14px;
        color: #ccc;
        text-align: left; /* keep labels left-aligned */
    }

    .signup-container input,
    .signup-container select {
        width: 100%;
        padding: 12px;
        margin: 8px 0 15px 0;
        font-size: 14px;
        border: none;
        border-radius: 4px;
        outline: none;
        background-color: #333; /* dark input */
        color: white;
    }

    .signup-container input::placeholder {
        color: #aaa;
    }

    .signup-container input[type="submit"] {
        background-color: #ff9900; /* orange button */
        color: black;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .signup-container input[type="submit"]:hover {
        background-color: #ff7700;
    }

    .signup-container a {
        color: #ff9900;
        text-decoration: none;
        font-size: 14px;
    }

    .signup-container a:hover {
        text-decoration: underline;
    }

    .sub-text {
        text-align: center;
        margin-top: 12px;
        font-size: 13px;
    }
</style>
</head>
<body>

<div class="signup-container">
    <!-- Logo inside the container -->
    <img src="ChatGPT Image Sep 20, 2025, 02_28_43 AM.png" alt="Logo">

    <h2>Create Account</h2>

    <form method="POST" action="">
        <label>New Username</label>
        <input type="text" name="username" placeholder="Enter Username" required>

        <label>New Password</label>
        <input type="password" name="password" placeholder="Enter Password" required>

        <label>Email Address</label>
        <input type="email" name="email" placeholder="Enter Email" required>

        <label>Contact Number</label>
        <input type="text" name="contactnumber" placeholder="Enter Contact Number" required>

        <label>Signup as:</label>
        <select name="choose" required>
            <option value="Admin">Admin</option>
            <option value="User">User</option>
        </select>

        <input type="submit" name="clicked" value="Create Account">

        <p class="sub-text">
            Already signed up? <a href="login.php">Go to Login</a>
        </p>
    </form>
</div>

</body>
</html>
