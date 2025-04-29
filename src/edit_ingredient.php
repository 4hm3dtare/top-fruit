<?php
session_start();
if (!isset($_SESSION['username'])){
    header('Location: login_admin.php');
    exit;
}

$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='top fruit';

$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if (!$con){
    die(mysqli_error($con));
}

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    header('Location: ingredients.php');
    exit;
}

// Fetch item data
$sql = "SELECT * FROM ingredients WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$ingredient = mysqli_fetch_assoc($result);

if (!$ingredient) {
    header('Location: ingredients.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $current_stock = $_POST['current_stock'];
    $reorder_level = $_POST['reorder_level'];
    $price = $_POST['price'];
    $supplier_id = $_POST['supplier_id'];
    
    $sql = "UPDATE ingredients SET name=?, unit=?, current_stock=?, reorder_level=?, price=?, supplier_id=? WHERE id=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssiidii", $name, $unit, $current_stock, $reorder_level, $price, $supplier_id, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: ingredients.php');
        exit;
    } else {
        $error = "Error updating ingredient: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ingredient</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">Edit Ingredient</h1>
    </div>

    <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Ingredient Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($ingredient['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="unit_type">Unit type</label>
                <select id="unit_type" name="unit" value="<?php echo $ingredient['name'];?>" required>
                    <option value="gram">Gram</option>
                    <option value="piece">Piece</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="current_stock">Current Stock</label>
                <input type="number" id="current_stock" name="current_stock" step="1" value="<?php echo htmlspecialchars($ingredient['current_stock']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="reorder_level">Reorder Level</label>
                <input type="number" id="reorder_level" name="reorder_level" step="1" value="<?php echo htmlspecialchars($ingredient['reorder_level']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.5" value="<?php echo htmlspecialchars($ingredient['price']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="supplier">Subblier</label>
                <select id="supplier" name="supplier_id" required>
                    <?php 
                        $sql = "SELECT id , name FROM suppliers ORDER BY name";
                        $result = mysqli_query($con, $sql);
                        if(mysqli_num_rows($result)>0){
                            while($row = mysqli_fetch_assoc($result)){
                                echo '<option value"'.$row['id'].'">'.$row['id'].'</option>';
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="location.href='ingredients.php'">Cancel</button>
                <button type="submit" class="save-btn">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html> 