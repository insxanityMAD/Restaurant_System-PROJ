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
    $email = $_POST['email'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM signup_tbl WHERE emailaddress = ?";

    $stmt = $conn -> prepare($sql);
    $stmt -> bind_param("s", $email); 
    $stmt -> execute();
    $result = $stmt -> get_result();

    if ($result -> num_rows > 0) {
        $user = $result -> fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "login succesful! Welcome, " . $user['username'];


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
    <input type="text" name="email" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" name="login" value="Submit">
    <p>Don't have an account? <a href="sign-in.php">Register</a></p>
</form>
    </div>
</div>

</body>
</html>
