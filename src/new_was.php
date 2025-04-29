<?php
    session_start();
    if(isset($_SESSION['username'])){
        header ('location: admin_login.php');
        exit;
    }

    $con = mysqli_connect('localhost', 'root','','top fruit');
    if(!$con){
        die(mysqli_error($con));
    }

    if($_REQUEST['method']=='POST'){
        $ingredient_id = $_POST['ingredient_id'];
        $staff_id = $_POST['staff_id'];
        $quentity = $_POST['quentity'];
        $reason = $_POST['reason'];
        $cost = $_POST['cost'];
        

        $sql = "INSERT INTO wast_log (ingredient_id, staff_id, quentity, reason, cost) VALUES ('$ingredient_id', '$staff_id', '$quentity', '$reason', '$cost')";
        if(mysqli_query($con, $sql)){
            header('location: wastlog.php');
            exit;
        }

    }
    
    $sql= "SELECT id, name FROM ingredients ORDER BY name";
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $ingredients[] = $row;
    }

    $sql1= "SELECT id, name FROM staff ORDER BY name WHERE role = 'barista' or role = 'inventory_manager'";
    $result1 = mysqli_query($con, $sql1);
    while($row = mysqli_fetch_assoc($result1)) {
        $staff[] = $row;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Wast Log</title>
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
                <button type="button" class="cancel-btn" onclick="location.href='wastlog.php'">Cancel</button>
                <button type="submit" class="save-btn">Save</button>
            </div>
        </form>
    </div>
</body>
</html> 
