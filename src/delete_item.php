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

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    header('Location: admin.php');
    exit;
}

// Check if the item exists and get image path
$check_sql = "SELECT * FROM items WHERE id = ?";
$check_stmt = mysqli_prepare($con, $check_sql);
mysqli_stmt_bind_param($check_stmt, "i", $id);
mysqli_stmt_execute($check_stmt);
$result = mysqli_stmt_get_result($check_stmt);
$item = mysqli_fetch_assoc($result);

if(!$item) {
    header('Location: admin.php');
    exit;
}

// Begin transaction
mysqli_begin_transaction($con);

try {
    // First delete related ingredients
    $sql = "DELETE FROM item_ingredient WHERE item_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    // Then delete the item
    $sql = "DELETE FROM items WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    // Delete the image file if it exists
    if (!empty($item['img_url']) && file_exists($item['img_url'])) {
        unlink($item['img_url']);
    }
    
    // Commit transaction
    mysqli_commit($con);
    
    header('Location: admin.php');
    exit;
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($con);
    echo "Error deleting item: " . $e->getMessage();
}

mysqli_close($con);
?>