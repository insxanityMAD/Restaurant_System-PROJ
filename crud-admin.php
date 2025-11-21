<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>List of Dishes</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #141414;
    }

    .container-my5 {
        max-width: 900px;
        margin: 50px auto;
        background-color: #1c1c1c;
        padding: 30px;
        border-radius: 8px;
        color: white;
        box-shadow: 0 0 20px rgba(255, 153, 0, 0.5);
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: bold;
        color: #ff9900;
    }

    .btn-add {
        background-color: #ff9900;
        color: black;
        font-weight: bold;
        margin-bottom: 20px;
        transition: 0.3s;
    }

    .btn-add:hover {
        background-color: #ff7700;
        color: white;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #f5f5f5; /* soft off-white background */
        border-radius: 6px;
        overflow: hidden;
    }

    thead th {
        background-color: #e0e0e0; /* light gray header */
        color: #333; /* dark text */
        padding: 12px;
        text-align: center;
    }

    tbody td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd; /* subtle row borders */
        color: #333; /* dark text */
    }

    tbody tr:hover {
        background-color: #f0f0f0; /* subtle hover effect */
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-primary {
        background-color: #ff9900;
        border: none;
        color: black;
    }

    .btn-primary:hover {
        background-color: #ff7700;
        color: white;
    }

    .btn-danger {
        background-color: #ff3300;
        border: none;
        color: white;
    }

    .btn-danger:hover {
        background-color: #cc0000;
        color: white;
    }
</style>
</head>
<body>

<div class="container-my5">
    <h2>List of Dishes</h2>
    <a class="btn btn-add" href="/SYSTEM/create.php" role="button">+ Add New Dish</a>

    <table class="table">
        <thead>
            <tr>
                <th>Dish ID</th>
                <th>Dish Name</th>
                <th>Price</th>
                <th>Dish Type</th>
                <th>Edit/Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                session_start();

                $server = "localhost";
                $user = "root";
                $pass = "";
                $db_name = "restaurant_db";

                $conn = mysqli_connect($server, $user, $pass, $db_name);
                
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT * FROM menu_tbl";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Invalid query: " . $conn->error);
                }

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['dish_id']}</td>
                        <td>{$row['Dish_Info']}</td>
                        <td>₱{$row['Price']}</td>
                        <td>{$row['Food_Type']}</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/SYSTEM/edit.php?id={$row['dish_id']}'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/SYSTEM/delete.php?id={$row['dish_id']}'>Delete</a>
                        </td>
                    </tr>";
                }

                $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
