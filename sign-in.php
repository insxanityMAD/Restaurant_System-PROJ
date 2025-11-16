
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Create Account</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #242424, #3a3a3a);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .signup-container {
        width: 420px;
        background: #2c2c2c; /* solid dark background */
        padding: 35px;
        border-radius: 15px;
        color: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .signup-container h2 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: 600;
    }

    .signup-container label {
        margin-top: 10px;
        display: block;
        font-size: 15px;
    }

    .signup-container input,
    .signup-container select {
        width: 100%;
        padding: 12px;
        margin: 8px 0 15px 0;
        border-radius: 8px;
        border: none;
        outline: none;
        font-size: 15px;
        background: #e6e6e6;
        color: #000;
    }

    .signup-container input[type="submit"] {
        background: #ffb92e;
        color: black;
        font-weight: 600;
        cursor: pointer;
        margin-top: 5px;
        transition: 0.3s;
    }

    .signup-container input[type="submit"]:hover {
        background: #ff9900;
    }

    .signup-container a {
        color: #ffd27a;
        font-size: 14px;
        text-decoration: none;
    }

    .signup-container a:hover {
        text-decoration: underline;
    }

    .sub-text {
        text-align: center;
        margin-top: 12px;
        font-size: 14px;
    }
</style>
</head>
<body>

<div class="signup-container">
    <h2>Create Account</h2>

    <form method="POST" action="">

        <label>New Username</label>
        <input type="text" name="username" placeholder="Enter Username" required>

        <label>New Password</label>
        <input type="password" name="password" placeholder="Enter Password" required>

        <label>Email Address</label>
        <input type="text" name="email" placeholder="Enter Email" required>

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

