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
    header('Location: wastlog.php');
    exit;
}

// Check if the wastlog exists
$check_sql = "SELECT * FROM wast_log WHERE id = ?";
$check_stmt = mysqli_prepare($con, $check_sql);
mysqli_stmt_bind_param($check_stmt, "i", $id);
mysqli_stmt_execute($check_stmt);
mysqli_stmt_store_result($check_stmt);

if(mysqli_stmt_num_rows($check_stmt) == 0) {
    header('Location: wastlog.php');
    exit;
}

// Delete the supplier
$sql = "DELETE FROM waste_log WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    $update_inventory = "UPDATE ingredients SET stock = stock + {$wastlog['quantity']} WHERE id = '{$wastlog['ingredient_id']}'";
    mysqli_query($conn, $update_inventory);

    header('Location: wastlog.php');
    exit;
} else {
    echo "Error deleting wastlog: " . mysqli_error($con);
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>