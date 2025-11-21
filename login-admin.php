<?php
session_start();
include("connection_db.php");

$message = "";

// Handle login form submission
if (isset($_POST['login'])) {

    $login_id = trim($_POST['login_id']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM signup_tbl WHERE username = ? OR emailaddress = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $login_id, $login_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $message = "No account found.";
    } else {
        $user = $result->fetch_assoc();

        if ($user['role'] !== "Admin") {
            $message = "This page is for ADMIN ONLY.";
        } else if ($password !== $user['password']) {
            $message = "Incorrect password.";
        } else {
            // success: set sessions expected by crud-admin
            $_SESSION['user_id'] = $user['customer_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: crud-admin.php");
            exit();
        }
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: url("images/brazilian-food-frame-with-copy-space.jpg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.login-container {
    width: 380px;
    background-color: #1c1c1c;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(255, 153, 0, 0.5);
    color: white;
    text-align: center;
}

.login-container img {
    width: 170px;
    height: 170px;
    margin-bottom: 15px;
    border-radius: 50%;
}

.login-container h1 {
    font-size: 24px;
    margin-bottom: 25px;
    font-weight: bold;
    color: #ff9900;
}

.login-container label {
    display: block;
    margin-top: 12px;
    font-size: 14px;
    color: #ccc;
    text-align: left;
}

.login-container input,
.login-container select {
    width: 100%;
    padding: 12px;
    margin: 8px 0 15px 0;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    outline: none;
    background-color: #333;
    color: white;
}

.login-container input[type="submit"] {
    background-color: #ff9900;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.login-container input[type="submit"]:hover {
    background-color: #ff7700;
}

.login-container a {
    color: #ff9900;
    text-decoration: none;
    font-size: 14px;
}

.login-container a:hover {
    text-decoration: underline;
}

.sub-text {
    text-align: center;
    margin-top: 12px;
    font-size: 13px;
}

.msg {
    margin-top: 10px;
    color: #ff9900;
    font-size: 14px;
}
</style>
</head>
<body>

<div class="login-container">
    <img src="ChatGPT Image Sep 20, 2025, 02_28_43 AM.png" alt="Logo">
    <h1>Login as Admin</h1>

    <?php if (!empty($message)) echo "<p class='msg'>$message</p>"; ?>

    <!-- Added autocomplete="off" -->
    <form method="POST" action="" autocomplete="off">
        <label>Username or Email</label>
        <input type="text" name="login_id" placeholder="Enter Username or Email" autocomplete="off" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter Password" autocomplete="new-password" required>

        <label>Account Type</label>
        <select name="choose" id="choose" onchange="redirectUser()">
            <option value="User">User</option>
            <option value="Admin" selected>Admin</option>
        </select>

        <input type="submit" name="login" value="Login">

        <p class="sub-text">
            Don’t have an account? <a href="sign-in.php">Register</a>
        </p>
    </form>
</div>

<script>
function redirectUser() {
    const select = document.getElementById("choose");
    if (select.value === "User") {
        window.location.href = "login-user.php";
    }
}
</script>

</body>
</html>
