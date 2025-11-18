
<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "restaurant_db";

$conn = mysqli_connect($server, $user, $pass, $db_name);

$id = "";
$name = "";
$price = "";
$type = "";

$errorMessage = "";
$successMessage = "";

/* -----------------------
   HANDLE GET REQUEST
------------------------ */
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET['id'])) {
        header("location: /SYSTEM/crud-admin.php");
        exit;
    }

    $id = $_GET['id'];

    $sql = "SELECT * FROM menu_tbl WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        header("location: /SYSTEM/crud-admin.php");
        exit;
    }

    // Fill form
    $id = $row['id'];
    $name = $row['Dish_Info'];
    $price = $row['Price'];
    $type = $row['Food_Type'];
}

/* -----------------------
   HANDLE POST REQUEST
------------------------ */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $type = trim($_POST['dish_type']);

    if ($id === "" || $name === "" || $price === "" || $type === "") {
        $errorMessage = "All fields are required.";
    } else {

        $sql = "UPDATE menu_tbl 
                SET Dish_Info = '$name',
                    Price = '$price',
                    Food_Type = '$type'
                WHERE id = $id";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $errorMessage = "Update failed: " . mysqli_error($conn);
        } else {
            header("location: /SYSTEM/crud-admin.php");
            exit;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Dish</title>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #141414;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.dish-container {
    width: 400px;
    background-color: #1c1c1c;
    padding: 40px;
    border-radius: 8px;
    color: white;
    box-shadow: 0 0 20px rgba(255, 153, 0, 0.5);
}

.dish-container h2 {
    text-align: center;
    margin-bottom: 25px;
    font-weight: bold;
    color: #ff9900;
}

.dish-container label {
    display: block;
    margin-top: 12px;
    font-size: 14px;
    color: #ccc;
}

.dish-container input,
.dish-container select {
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

.dish-container input::placeholder {
    color: #aaa;
}

/* Styled submit and cancel buttons */
.dish-container input[type="submit"],
.dish-container a.btn-cancel {
    width: 48%;
    display: inline-block;
    padding: 10px;
    margin-top: 10px;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
}

.dish-container input[type="submit"] {
    background-color: #ff9900;
    color: black;
    transition: 0.3s;
}

.dish-container input[type="submit"]:hover {
    background-color: #ff7700;
}

.dish-container a.btn-cancel {
    background-color: #333;
    color: #ff9900;
    margin-left: 4%;
    transition: 0.3s;
}

.dish-container a.btn-cancel:hover {
    background-color: #444;
    color: #ff7700;
}

/* Alert message style */
.alert {
    font-size: 14px;
    margin-bottom: 15px;
}

/* Styled select with drawer arrow */
.dish-container select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg fill="white" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px;
    padding-right: 40px; /* space for arrow */
}
</style>
</head>
<body>

<div class="dish-container">
    <h2>New Dish</h2>

    <?php if (!empty($errorMessage)) { ?>
        <div class="alert alert-warning"><?php echo $errorMessage; ?></div>
    <?php } ?>

    <?php if (!empty($successMessage)) { ?>
        <div class="alert alert-success"><?php echo $successMessage; ?></div>
    <?php } ?>

    <form method="POST">
        <label>Dish ID</label>
        <input type="text" name="id" value="<?php echo $id; ?>" placeholder="Enter Dish ID">

        <label>Dish Name</label>
        <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Enter Dish Name">

        <label>Dish Price</label>
        <input type="text" name="price" value="<?php echo $price; ?>" placeholder="Enter Price">

        <label>Dish Type</label>
        <select name="dish_type">
            <option value="Starter" <?php if($type=="Starter") echo "selected"; ?>>Starter</option>
            <option value="Main Course" <?php if($type=="Main Course") echo "selected"; ?>>Main Course</option>
            <option value="Dessert" <?php if($type=="Dessert") echo "selected"; ?>>Dessert</option>
        </select>

        <input type="submit" value="Submit">
        <a href="crud-admin.php" class="btn-cancel">Cancel</a>
    </form>
</div>

</body>
</html>