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
    header('Location: suppliers.php');
    exit;
}

// Fetch suppliers data
$sql = "SELECT * FROM suppliers WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$supplier = mysqli_fetch_assoc($result);

if (!$supplier) {
    header('Location: suppliers.php');
    exit;
}
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $tele = $_POST['tele'];
    $salary_rate = $_POST['salary_rate'];
    
    // Check if password field is filled
    if (!empty($_POST['password'])) {
        // Password field is filled, update password
        $password = sha1($_POST['password']);
        $sql = "UPDATE suppliers SET username = ?, password = ?, name = ?, email = ?, role = ?, tele = ?, salary_rate = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssdi", $username, $password, $name, $email, $role, $tele, $salary_rate, $id);
    } else {
        $sql = "UPDATE suppliers SET username = ?, name = ?, email = ?, role = ?, tele = ?, salary_rate = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sssssdi", $username, $name, $email, $role, $tele, $salary_rate, $id);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: suppliers.php');
        exit;
    } else {
        $error = "Error updating supplier: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">Edit Supplier</h1>
    </div>

    <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($supplier['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($supplier['username']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Leave empty to keep current password">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($supplier['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="admin" <?php echo $supplier['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="barista" <?php echo $supplier['role'] === 'barista' ? 'selected' : ''; ?>>barista</option>
                    <option value="inventory_manager" <?php echo $supplier['role'] === 'inventor_manager' ? 'selected' : ''; ?>>inventory manager</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tele">Telephone</label>
                <input type="tel" id="tele" name="tele" value="<?php echo htmlspecialchars($supplier['tele']); ?>" required>
            </div>

            <div class="form-group">
                <label for="salary_rate">Salary Rate</label>
                <input type="number" step="1" id="salary_rate" name="salary_rate" value="<?php echo htmlspecialchars($supplier['salary_rate']); ?>" required>
            </div>

            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="location.href='suppliers.php'">Cancel</button>
                <button type="submit" class="save-btn">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html> 