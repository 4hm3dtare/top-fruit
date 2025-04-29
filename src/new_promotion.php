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
    $code = $_POST['code'];
    $discount_type = $_POST['type'];
    $discount_value = $_POST['value'];
    $valid_from = $_POST['valid_from'];
    $valid_to = $_POST['valid_to'];
    
    // Insert the new promotion
    $sql = "INSERT INTO promotions (code, discount_type, discount_value, valid_from, valid_to) VALUES ( ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssdss", $code, $discount_type, $discount_value, $valid_from, $valid_to);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: promotions.php');
        exit;
    } else {
        $error = "Error creating promotion: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Promotion</title>
    <link rel="stylesheet" href="admin_styles.css">
    
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">New promotions</h1>
    </div>

    <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
                <div class="form-group">
                    <label for="code">Promotion Code</label>
                    <input type="text" id="code" name="code" required>
                    <button type="button" onclick="generateCode()" class="generate-btn">Generate Code</button>
                    <script>
                        <?php
                        // PHP function to generate random code
                        function generateRandomCode($length = 10) {
                            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            $code = '';
                            for ($i = 0; $i < $length; $i++) {
                                $code .= $chars[rand(0, strlen($chars) - 1)];
                            }
                            return $code;
                        }
                        ?>
                        
                        function generateCode() {
                            // Call the PHP function via AJAX or use a pre-generated code
                            const randomCode = '<?php echo generateRandomCode(); ?>';
                            document.getElementById('code').value = randomCode;
                        }
                    </script>
                </div>

                <div class="form-group">
                    <label for="type">Discount Type</label>
                    <select id="type" name="type" required>
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed Amount</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="value">Discount Value</label>
                    <input type="number" step="0.5" id="value" name="value" required>
                </div>

                <div class="form-group">
                    <label for="valid_from">Valid From</label>
                    <input type="date" id="valid_from" name="valid_from" required value="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label for="valid_to">Valid To</label>
                    <input type="date" id="valid_to" name="valid_to" >
                </div>

                <div class="form-buttons">
                    <button type="button" class="cancel-btn" onclick="location.href='promotions.php'">Cancel</button>
                    <button type="submit" class="save-btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>