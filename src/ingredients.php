<?php
session_start();
if (!isset($_SESSION['username'])){
    header('Location: login_admin.php');
}

// Database connection
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='top fruit';

$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if (!$con){
    die(mysqli_error($con));
}

// Fetch ingredients from database
$sql = "SELECT id, name FROM ingredients ORDER BY id";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_styles.css">
    <link rel="stylesheet" href="admin_styles1.css">
    <link rel="stylesheet" href="sidenav_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Button styles for edit and delete actions */
        .edit-btn, .delete-btn {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .edit-btn {
            background-color: #007bff;
        }

        .delete-btn {
            background-color: #ff4d4d;
        }

        /* Align action buttons in the table with center padding */
        .table-row > div:last-child {
            display: flex;
            justify-content: center; /* Center the items horizontally */
            align-items: center;     /* Center the items vertically */
            gap: 10px;               /* Add equal spacing between items */
            padding: 10px;           /* Add padding around the buttons */
        }

        /* For the table header */
        .table-header > div:last-child {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;           /* Add padding around the header */
        }
    </style>
</head>
<body>
    <div class="sidenav">
        <div class="logo">
            <img src="logo.png" alt="Top Fruit Logo">
            <h2>Top Fruit Admin</h2>
        </div>
        <a href="admin.php" ><i class="fas fa-list"></i> Items</a>
        <a href="categories.php" ><i class="fas fa-tags"></i> Categories</a>
        <a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
        <a href="staff.php"><i class="fas fa-users"></i> Staff</a>
        <a href="suppliers.php"><i class="fas fa-truck"></i> Suppliers</a>
        <a href="promotions.php"><i class="fas fa-percent"></i> Promotions</a>
        <a href="ingredients.php" class="active"><i class="fas fa-ice-cream"></i> Ingredients</a>
        <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
        <a href="index.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="admin-header">
            <h1 class="admin-title">Ingredinents</h1>
            <div class="header-buttons">
                <button class="new-btn" onclick="location.href='new_ingredient.php'">New</button>
                <button class="refresh-btn" onclick="location.reload()">↻</button>
            </div>
        </div>

        <div class="items-table">
            <div class="table-header">
                <div>Id ↑</div>
                <div>Title</div>
                <div>Actions</div>
            </div>

            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="table-row">
                        <div>' . $row['id'] . '</div>
                        <div>' . $row['name'] . '</div>
                        <div>
                            <a href="edit_ingredient.php?id=' . $row['id'] . '" class="edit-btn">EDIT</a>
                            <a href="delete_ingredient.php?id=' . $row['id'] . '" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this ingredient?\')">DELETE</a>
                        </div>
                    </div>';
                }
            }
            ?>
        </div>

        
    </div>

   
</body>
</html>
