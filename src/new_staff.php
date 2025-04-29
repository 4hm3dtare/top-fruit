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
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    $email = $_POST['email'];
    $role = $_POST['role'];
    $tele = $_POST['tele'];
    $salary_rate = $_POST['salary_rate'];
    
    // Changed from UPDATE to INSERT since this is for new staff
    $sql = "INSERT INTO staff (username, password, name, email, role, tele, salary_rate) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssd", $username, $password, $name, $email, $role, $tele, $salary_rate);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: staff.php');
        exit;
    } else {
        $error = "Error creating staff: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New staff</title>
    <link rel="stylesheet" href="admin_styles.css">
    
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">New staff</h1>
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
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="barista">Barista</option>
                    <option value="inventory_manager">Inventory Manager</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tele">Telephone</label>
                <input type="tel" id="tele" name="tele" required>
            </div>

            <div class="form-group">
                <label for="salary_rate">Salary Rate</label>
                <input type="number" step="1" id="salary_rate" name="salary_rate" required>
            </div>

            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="location.href='staff.php'">Cancel</button>
                <button type="submit" class="save-btn">Save</button>
            </div>
        </form>
    </div>
</body>
</html> 