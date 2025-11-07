<?php
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
if (isset($_POST['clicked'])) {
    $username = $_POST['uname'];
    $password = $_POST['pword'];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO login_tbl (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $message = "Inserted successfully!";
    } else {
        $message = "Error inserting: " . $stmt->error;
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

<form method="POST" action="">
    <p>Log-in</p>
    <input type="text" name="uname" placeholder="Username" required>
    <input type="password" name="pword" placeholder="Password" required>
    <input type="submit" name="clicked" value="Submit">
    <p>Already have an account? <a href="sign-in.php">Click here to sign-up.</a></p>
</form>

</body>
</html>
