<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "restaurant_db";

$conn = mysqli_connect($server, $user, $pass, $db_name);
if (!$conn) {
    die("Database connection error");
}

$id = "";
$name = "";
$price = "";
$type = "";
$currentImage = "";

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

    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM menu_tbl WHERE dish_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        header("location: /SYSTEM/crud-admin.php");
        exit;
    }

    // Fill form
    $name = $row['Dish_Info'];
    $price = $row['Price'];
    $type = $row['Food_Type'];
    $currentImage = $row['image'];
}

/* -----------------------
   HANDLE POST REQUEST
------------------------ */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $type = trim($_POST['dish_type']);

    // Get current image from database in case POST does not include it
    $stmt = $conn->prepare("SELECT image FROM menu_tbl WHERE dish_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $currentImage = $row['image'];
    $stmt->close();

    if ($id === "" || $name === "" || $price === "" || $type === "") {
        $errorMessage = "All fields are required.";
    } else {
        // Handle image upload
        $imageFileName = $currentImage; // default to current image

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $allowedExtensions = array('jpg','jpeg','png','gif');
            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = uniqid() . '.' . $fileExtension;
                $uploadFileDir = './uploads/';
                if (!is_dir($uploadFileDir)) mkdir($uploadFileDir, 0755, true);
                $dest_path = $uploadFileDir . $newFileName;
                if(move_uploaded_file($fileTmpPath, $dest_path)) {
                    $imageFileName = $newFileName;
                } else {
                    $errorMessage = "Error uploading image.";
                }
            } else {
                $errorMessage = "Allowed image types: jpg, jpeg, png, gif.";
            }
        }

        if(empty($errorMessage)){
            // Use prepared statement for update
            $stmt = $conn->prepare("UPDATE menu_tbl SET Dish_Info=?, Price=?, Food_Type=?, image=? WHERE dish_id=?");
            $stmt->bind_param("sdssi", $name, $price, $type, $imageFileName, $id);
            if ($stmt->execute()) {
                header("location: /SYSTEM/crud-admin.php");
                exit;
            } else {
                $errorMessage = "Update failed: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Dish</title>
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
}
</style>
</head>
<body>

<div class="dish-container">
    <h2>Edit Dish For ID "<?php echo $id; ?>" </h2>

    <?php if (!empty($errorMessage)) { ?>
        <div class="alert alert-warning"><?php echo $errorMessage; ?></div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label>Dish Name</label>
        <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Enter Dish Name" required>

        <label>Dish Price</label>
        <input type="text" name="price" value="<?php echo $price; ?>" placeholder="Enter Price" required>

        <label>Dish Type</label>
        <select name="dish_type" required>
            <option value="Starter" <?php if($type=="Starter") echo "selected"; ?>>Starter</option>
            <option value="Main Course" <?php if($type=="Main Course") echo "selected"; ?>>Main Course</option>
            <option value="Dessert" <?php if($type=="Dessert") echo "selected"; ?>>Dessert</option>
        </select>

        <label>Current Image</label>
        <?php if($currentImage): ?>
            <img src="uploads/<?php echo $currentImage; ?>" alt="Current Image" style="width:150px; display:block; margin-bottom:10px; border-radius:8px;">
        <?php endif; ?>

        <label>Change Image</label>
        <input type="file" name="image" accept="image/*">

        <input type="submit" value="Update">
        <a href="crud-admin.php" class="btn-cancel">Cancel</a>
    </form>
</div>

</body>
</html>
