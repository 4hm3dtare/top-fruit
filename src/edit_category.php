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
    header('Location: categories.php');
    exit;
}

// Fetch category data
$sql = "SELECT * FROM categories WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$category = mysqli_fetch_assoc($result);

if (!$category) {
    header('Location: categories.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    
    $sql = "UPDATE categories SET name=? WHERE id=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $name, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: categories.php');
        exit;
    } else {
        $error = "Error updating category: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">Edit Item</h1>
    </div>

    <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
            </div>

            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="location.href='admin.php'">Cancel</button>
                <button type="submit" class="save-btn">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html> 