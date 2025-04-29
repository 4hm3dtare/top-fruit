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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    
    // Check if category already exists
    $check_sql = "SELECT * FROM categories WHERE name = ?";
    $check_stmt = mysqli_prepare($con, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $name);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    
    if(mysqli_stmt_num_rows($check_stmt) > 0) {
        $error = "Category with this name already exists!";
    } else {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $name);
        
        if (mysqli_stmt_execute($stmt)) {
            header('Location: categories.php');
            exit;
        } else {
            $error = "Error creating category: " . mysqli_error($con);
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
    <title>New Category</title>
    <link rel="stylesheet" href="admin_styles.css">
    
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">New Category</h1>
    </div>

    <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            
            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="location.href='categories.php'">Cancel</button>
                <button type="submit" class="save-btn">Save</button>
            </div>
        </form>
    </div>
</body>
</html> 