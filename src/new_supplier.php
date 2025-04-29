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
    $email = $_POST['email'];
    $telephone = $_POST['tele'];
    
    $sql = "INSERT INTO suppliers (name, email, telephone) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $telephone);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: suppliers.php');
        exit;
    } else {
        $error = "Error creating supplier: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Supplier</title>
    <link rel="stylesheet" href="admin_styles.css">
    <link rel="stylesheet" href="admin_styles1.css">
    <link rel="stylesheet" href="sidenav_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">New supplier</h1>
    </div>

    <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="tele">Telephone</label>
                <input type="tel" id="tele" name="tele" required>
            </div>

            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="location.href='suppliers.php'">Cancel</button>
                <button type="submit" class="save-btn">Save</button>
            </div>
        </form>
    </div>
</body>
</html> 