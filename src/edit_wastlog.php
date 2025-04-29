<?php
session_start();
if (!isset($_SESSION['username'])){
    header('Location: wastlog.php');
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
    header('Location: wastlog.php');
    exit;
}

// Fetch wastlog data
$sql = "SELECT * FROM wast_log WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$wastlog = mysqli_fetch_assoc($result);

if (!$wastlog) {
    header('Location: wastlog.php');
    exit;
}

$sql = "SELECT id, name from ingredients";
$result = mysqli_query($con, $sql);
$ingredients = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT id, name from staff where role != 'admin'";
$result = mysqli_query($con, $sql);
$staff = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ingredient_id = $_POST['ingredient_id'];
    $staff_id = $_POST['staff_id'];
    $quentity = $_POST['quentity'];
    $reason = $_POST['reason'];
    $cost = $_POST['cost'];
    
    $sql = "UPDATE wast_log SET ingredient_id = ?, staff_id = ?, quentity = ?, reason = ?, cost = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "iiisii", $ingredient_id, $staff_id, $quentity, $reason, $cost, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: wastlog.php');
        exit;
    } else {
        $error = "Error updating wastlog: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wast Log</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">Edit Wast Log</h1>
    </div>

    <form method="POST">            
            <div class="form-group">
                <label for="name">Ingredient</label>
                <select id="name" name="name" required>
                    <?php foreach($ingredients as $ingredient): ?>
                        <option value="<?php echo $ingredient['id']; ?>"><?php echo $ingredient['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="staff_id">Staff</label>
                <select id="staff_id" name="staff_id" required>
                    <?php foreach($staff as $member): ?>
                        <option value="<?php echo $member['id']; ?>"><?php echo $member['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number"  id="quantity" name="quantity" required>
            </div>

            <div class="form-group">
                <label for="reason">Reason</label>
                <input type="text" id="reorder_level" name="reorder_level">
            </div>

            <div class="form-group">
                <label for="cost">cost</label>
                <input type="number" id="cost" name="cost" required>
            </div>

            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="location.href='staff.php'">Cancel</button>
                <button type="submit" class="save-btn">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html> 