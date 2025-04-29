<?php
session_start();
if (!isset($_SESSION['username'])){
    header('Location: login_admin.php');
    exit;
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

// Fetch suppliers from database
$sql = "SELECT id, name FROM suppliers ORDER BY name";
$result = mysqli_query($con, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $current_stock = $_POST['current_stock'];
    $reorder_level = $_POST['reorder_level'];
    $price = $_POST['price'];
    $supplier_id = $_POST['supplier_id'];
    
    // Check if ingredient already exists
    $check_sql = "SELECT * FROM ingredients WHERE name = ?";
    $check_stmt = mysqli_prepare($con, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $name);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    
    if(mysqli_stmt_num_rows($check_stmt) > 0) {
        $error = "Ingredient with this name already exists!";
    } else {
        $sql = "INSERT INTO ingredients (name, unit, current_stock, reorder_level, price, supplier_id) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssiidi", $name, $unit, $current_stock, $reorder_level, $price, $supplier_id);
        
        if (mysqli_stmt_execute($stmt)) {
            header('Location: ingredients.php');
            exit;
        } else {
            $error = "Error creating ingredient: " . mysqli_error($con);
        }
    }
    mysqli_stmt_close($check_stmt);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New ingredient</title>
    <link rel="stylesheet" href="admin_styles.css">
    
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">New Ingredient</h1>
    </div>

    <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">            
            <div class="form-group">
                <label for="name">Ingredient Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="unit_type">Unit type</label>
                <select id="unit_type" name="unit" required>
                    <option value="gram">Gram</option>
                    <option value="piece">Piece</option>
                </select>
            </div>

            <div class="form-group">
                <label for="current_stock">Current stock</label>
                <input type="number"  id="current_stock" name="current_stock" required>
            </div>

            <div class="form-group">
                <label for="reorder_level">Reorder level</label>
                <input type="text" id="reorder_level" name="reorder_level">
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" >
            </div>

            <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select name="supplier_id" id="supplier_id">
                    
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="'.$row['id'].'">' . $row['name'] . '</option>';
                    }
                }
                ?>
                </select>
            </div>
            
            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="location.href='ingredients.php'">Cancel</button>
                <button type="submit" class="save-btn">Save</button>
            </div>
        </form>
    </div>
</body>
</html> 