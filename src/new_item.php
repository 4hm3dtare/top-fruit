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


// fetch all categories
$sql = "SELECT id, name FROM categories";
$result = mysqli_query($con, $sql);
$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Fetch all ingredients for the dropdown
$sql = "SELECT id, name FROM ingredients";
$result = mysqli_query($con, $sql);
$ingredients = [];
while ($row = mysqli_fetch_assoc($result)) {
    $ingredients[] = $row;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (empty($_POST['name'])) {
        $error = "Item name is required";
    } elseif (empty($_POST['category'])) {
        $error = "Category is required";
    } elseif (empty($_FILES['image_url']['name'])) {
        $error = "Image is required";
    } else {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $category = mysqli_real_escape_string($con, $_POST['category']);
        $price_l = floatval($_POST['price_l'] ?? 0);
        $price_m = floatval($_POST['price_m'] ?? 0);
        $price_s = floatval($_POST['price_s'] ?? 0);
        
        // Upload configuration
        $uploadDir = 'brand_images/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        
        // File upload handling
        $file = $_FILES['image_url'];
        $fileName = basename($file['name']);
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileType = mime_content_type($fileTmp);
        $fileError = $file['error'];
        
        // Validate file
        if ($fileError !== UPLOAD_ERR_OK) {
            $error = "File upload error: " . $fileError;
        } elseif (!in_array($fileType, $allowedTypes)) {
            $error = "Only JPG, PNG, and GIF images are allowed";
        } elseif ($fileSize > $maxFileSize) {
            $error = "File size exceeds 2MB limit";
        } else {
            // Create upload directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Generate unique filename
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $name) . '.' . $fileExt;
            $uploadPath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($fileTmp, $uploadPath)) {
                // Insert item into database
                $sql = "INSERT INTO items (name, category, L_price, M_price, S_price, img_url) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "ssddds", $name, $category, $price_l, $price_m, $price_s, $uploadPath);
                
                if (mysqli_stmt_execute($stmt)) {
                    $item_id = mysqli_insert_id($con);
                    
                    // Add ingredients if provided
                    if (!empty($_POST['ingredients']) && !empty($_POST['ingredient_quantities'])) {
                        $ingredients_ids = $_POST['ingredients'];
                        $ingredients_quantities = $_POST['ingredient_quantities'];
                        
                        foreach ($ingredients_ids as $index => $ingredient_id) {
                            if (isset($ingredients_quantities[$index])) {
                                $quantity = intval($ingredients_quantities[$index]);
                                $sql = "INSERT INTO item_ingredient (item_id, ingredient_id, quantity) VALUES (?, ?, ?)";
                                $stmt = mysqli_prepare($con, $sql);
                                mysqli_stmt_bind_param($stmt, "iii", $item_id, $ingredient_id, $quantity);
                                mysqli_stmt_execute($stmt);
                            }
                        }
                    }
                    
                    header('Location: admin.php');
                    exit;
                } else {
                    $error = "Error creating item: " . mysqli_error($con);
                    // Delete the uploaded file if database insert failed
                    if (file_exists($uploadPath)) {
                        unlink($uploadPath);
                    }
                }
            } else {
                $error = "Failed to move uploaded file";
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Item</title>
    <link rel="stylesheet" href="admin_styles.css">
    
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">New Item</h1>
    </div>

    <div class="form-container">
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" style="width: 100%;padding: 8px;border: 1px solid #ddd;border-radius: 4px;">
                    <?php
                    foreach ($categories as $category) {
                        echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="image_url">image</label>
                <input type="file" id="image_url" name="image_url" required>
            </div>

            <div class="form-group">
                <label for="ingredients_number">Ingredients Number</label>
                <input type="number" id="ingredients_number" name="ingredients_number" min="0" required onchange="updateIngredients()">
            </div>
            <div class="form-group">
                <label>Ingredients</label>
                <div id="ingredients_container" class="ingredients-list">
                    <!-- Ingredients will be added here dynamically -->
                </div>
            </div>
            
            <div class="form-group">
                <label for="price_l">Large Size Price</label>
                <input type="number" id="price_l" min="10" name="price_l" step="1" >
            </div>
            
            <div class="form-group">
                <label for="price_m">Medium Size Price</label>
                <input type="number" id="price_m" min="10" name="price_m" step="1" >
            </div>
            
            <div class="form-group">
                <label for="price_s">Small Size Price</label>
                <input type="number" id="price_s" min="10" name="price_s" step="1" >
            </div>

            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="location.href='admin.php'">Cancel</button>
                <button type="submit" class="save-btn">Save</button>
            </div>
        </form>
    </div>

    <style>
        .category {
            width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
        }
        .ingredients-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .ingredient-row {
            display: flex;
            gap: 10px;
        }
        .ingredient-row input[type="text"] {
            flex: 2;
        }
        .ingredient-row input[type="number"] {
            flex: 1;
        }
    </style>
    <script>
        const ingredientsIds = {};

function updateIngredients() {
    const container = document.getElementById('ingredients_container');
    const number = parseInt(document.getElementById('ingredients_number').value) || 0;
    container.innerHTML = ''; // Reset container
    
    for (let i = 0; i < number; i++) {
        const row = document.createElement('div');
        row.className = 'ingredient-row';
        
        const nameSelect = document.createElement('select');
        nameSelect.name = 'ingredients[]';
        nameSelect.required = true;
        
        // Add a default empty option
        const defaultOpt = document.createElement('option');
        defaultOpt.value = '';
        defaultOpt.innerText = 'Select ingredient';
        defaultOpt.disabled = true;
        defaultOpt.selected = true;
        nameSelect.appendChild(defaultOpt);
        
        // Add all ingredients from PHP
        const options = <?= json_encode($ingredients) ?>;
        if (Array.isArray(options)) {
            for (const option of options) {
                const opt = document.createElement('option');
                opt.value = option.id;
                opt.innerText = option.name;
                nameSelect.appendChild(opt);
            }
        } else {
            console.error('Ingredients data is not an array:', options);
        }
        
        // Add quantity input
        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.name = 'ingredient_quantities[]';
        quantityInput.min = '0';
        quantityInput.required = true;
        quantityInput.placeholder = 'Quantity';
        
        row.appendChild(nameSelect);
        row.appendChild(quantityInput);
        container.appendChild(row);
    }
}
    </script>
</body>
</html>