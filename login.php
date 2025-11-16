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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
    <meta charset="UTF-8">
    <title>Restaurant Ordering Management System</title>
</head>
<body>

<h1>Restaurant Ordering Management System</h1>

<?php
if (isset($message)) {
    echo "<p>$message</p>";
}
?>


<div class = "container">
    <div class = "form-box" id = "login-form">
<form method="POST" action="">
    <p>Log-in</p>
    <input type="text" name="login_id" placeholder="Username Or Email" required>
    <input type="password" name="password" placeholder="Password" required>
   

    <label for = "select">--SELECT--</label>

<select id = "select" name = "choose"> 
    <option value = "Admin"> Admin </option>
    <option value = "User"> User </option>

    </select>
     <input type="submit" name="login" value="Submit">
    <p>Don't have an account? <a href="sign-in.php">Register</a></p>
</form>
    </div>
</div>

</body>
</html>
