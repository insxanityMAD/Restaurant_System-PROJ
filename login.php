<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "restaurant_db";

// Connect to database

$conn = mysqli_connect($server, $user, $pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if (isset($_POST['login'])) {
    $log = $_POST['login_id'];
    $username = $_POST['login_id'];
    $password = $_POST['password']; 
    $option = $_POST['choose'];


    $sql = "SELECT * FROM signup_tbl WHERE emailaddress = ? OR username = ?";

    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("ss", $log, $log); 
    $stmt -> execute();
    $result = $stmt -> get_result();

    if ($result -> num_rows > 0) {
        $user = $result -> fetch_assoc();

        if (password_verify($password, $user['password'])) {

            if ($user['AccOption'] == $option) {
                 $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['AccOption'] = $user['AccOption'];

            if ($user['AccOption'] == "User") {
                    header("Location: user-header.php");
                    exit();
            }else if ($user['AccOption'] == "Admin") {
                header("Location: admin-header.php");
                exit();
            }
            
            }else {
                echo "incorrect account type";
            }

           

        }else {
            echo "invalid password!";
        }
    }else {
        echo "No user found with that username or email";
    }




    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Restaurant Ordering Management System</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

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

    .login-container {
        width: 420px;
        background: #2c2c2c;
        padding: 35px;
        border-radius: 15px;
        color: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .login-container h1 {
        text-align: center;
        font-size: 22px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .login-container label {
        display: block;
        margin-top: 10px;
        font-size: 15px;
    }

    .login-container input,
    .login-container select {
        width: 100%;
        padding: 12px;
        margin: 8px 0 15px 0;
        font-size: 15px;
        border: none;
        border-radius: 8px;
        outline: none;
        background: #e6e6e6;
    }

    .login-container input[type="submit"] {
        background: #ffb92e;
        color: black;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .login-container input[type="submit"]:hover {
        background: #ff9900;
    }

    .login-container a {
        color: #ffd27a;
        text-decoration: none;
    }

    .login-container a:hover {
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

<div class="login-container">
    
    <h1>Restaurant Ordering Management System</h1>

    <form method="POST" action="">
        
        <label>Username or Email</label>
        <input type="text" name="login_id" placeholder="Enter Username or Email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter Password" required>

        <label>Account Type</label>
        <select name="choose" required>
            <option value="Admin">Admin</option>
            <option value="User">User</option>
        </select>

        <input type="submit" name="login" value="Login">

        <p class="sub-text">
            Don't have an account? <a href="sign-in.php">Register</a>
        </p>

    </form>
</div>

</body>
</html>
