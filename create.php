<?php
session_start();
include("connection_db.php");

// Only allow admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== "Admin") {
    header("Location: login-admin.php");
    exit();
}

// Initialize variables
$id = "";
$name = "";
$price = "";
$type = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $type = $_POST['dish_type'];

    if (empty($id) || empty($name) || empty($price) || empty($type)) {
        $errorMessage = "All the fields are required!";
    } else {
        // Handle image upload
        $imageName = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $imageName = time() . "_" . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $imageName;

            $allowedTypes = ['jpg','jpeg','png','gif'];
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            if (!in_array($fileType, $allowedTypes)) {
                $errorMessage = "Only JPG, JPEG, PNG, GIF files are allowed.";
            } else {
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $errorMessage = "Failed to upload image.";
                }
            }
        }

       if (empty($errorMessage)) {
    // Check duplicate Dish_Info
    $checkSql = "SELECT * FROM menu_tbl WHERE Dish_Info = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $name);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $errorMessage = "Dish name already exists. Please choose a different name.";
    } else {
        // Insert new dish
        $sql = "INSERT INTO menu_tbl (dish_id, Dish_Info, Price, Food_Type, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdss", $id, $name, $price, $type, $imageName);

        if ($stmt->execute()) {
            $successMessage = "Dish Added Successfully!";
            $id = $name = $price = $type = "";
        } else {
            $errorMessage = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }

    $checkStmt->close();
}
    }
}
$conn->close();
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
    min-height: 100vh;
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

.alert {
    font-size: 14px;
    margin-bottom: 15px;
    text-align: center;
}
</style>
</head>
<body>

<div class="dish-container">
    <h2>New Dish</h2>

    <?php if (!empty($errorMessage)) { ?>
        <div class="alert" style="color:#ff3300;"><?php echo $errorMessage; ?></div>
    <?php } ?>

    <?php if (!empty($successMessage)) { ?>
        <div class="alert" style="color:#00cc44;"><?php echo $successMessage; ?></div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <label>Dish ID</label>
        <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" placeholder="Enter Dish ID" >

        <label>Dish Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Enter Dish Name">

        <label>Dish Price</label>
        <input type="text" name="price" value="<?php echo htmlspecialchars($price); ?>" placeholder="Enter Price">

        <label>Dish Type</label>
        <select name="dish_type">
            <option value="">-- Select Type --</option>
            <option value="Starter" <?php if($type=="Starter") echo "selected"; ?>>Starter</option>
            <option value="Main Course" <?php if($type=="Main Course") echo "selected"; ?>>Main Course</option>
            <option value="Dessert" <?php if($type=="Dessert") echo "selected"; ?>>Dessert</option>
        </select>

        <label>Dish Image</label>
        <input type="file" name="image" accept="image/*">

        <input type="submit" value="Submit">
        <a href="crud-admin.php" class="btn-cancel">Cancel</a>
    </form>
</div>

</body>
</html>
