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

// Get categories for dropdown
$sql = "SELECT id, name FROM categories";
$result = mysqli_query($con, $sql);
$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Get ingredients for dropdown
$sql = "SELECT id, name FROM ingredients";
$result = mysqli_query($con, $sql);
$ingredients = [];
while ($row = mysqli_fetch_assoc($result)) {
    $ingredients[] = $row;
}

$error = null;
$success = null;

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    header('Location: admin.php');
    exit;
}

// Fetch item data
$sql = "SELECT * FROM items WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($result);

if (!$item) {
    header('Location: admin.php');
    exit;
}

// Fetch item ingredients
$sql = "SELECT i.id, i.name, ii.quantity 
        FROM ingredients i 
        JOIN item_ingredient ii ON i.id = ii.ingredient_id 
        WHERE ii.item_id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$item_ingredients = [];
while ($row = mysqli_fetch_assoc($result)) {
    $item_ingredients[] = $row;
}

// Handle form submission
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $price_l = floatval($_POST['price_l'] ?? 0);
    $price_m = floatval($_POST['price_m'] ?? 0);
    $price_s = floatval($_POST['price_s'] ?? 0);
    
    // Check if a new image was uploaded
    if (!empty($_FILES['image']['name'])) {
        // Upload configuration
        $uploadDir = 'brand_images/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        
        // File upload handling
        $file = $_FILES['image'];
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
                // Delete old image if it exists
                if (!empty($item['img_url']) && file_exists($item['img_url'])) {
                    unlink($item['img_url']);
                }
                
                // Update item with new image
                $sql = "UPDATE items SET name = ?, category = ?, L_price = ?, M_price = ?, S_price = ?, img_url = ? WHERE id = ?";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "ssdddsi", $name, $category, $price_l, $price_m, $price_s, $uploadPath, $id);
            } else {
                $error = "Failed to move uploaded file";
            }
        }
    } else {
        // Update item without changing image
        $sql = "UPDATE items SET name = ?, category = ?, L_price = ?, M_price = ?, S_price = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssdddi", $name, $category, $price_l, $price_m, $price_s, $id);
    }
    
    if (!$error) {
        if (mysqli_stmt_execute($stmt)) {
            // Delete existing ingredients
            $sql = "DELETE FROM item_ingredient WHERE item_id = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            
            // Add ingredients if provided
            if (!empty($_POST['ingredients']) && !empty($_POST['ingredient_quantities'])) {
                $ingredients_ids = $_POST['ingredients'];
                $ingredients_quantities = $_POST['ingredient_quantities'];
                
                foreach ($ingredients_ids as $index => $ingredient_id) {
                    if (isset($ingredients_quantities[$index])) {
                        $quantity = intval($ingredients_quantities[$index]);
                        $sql = "INSERT INTO item_ingredient (item_id, ingredient_id, quantity) VALUES (?, ?, ?)";
                        $stmt = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($stmt, "iii", $id, $ingredient_id, $quantity);
                        mysqli_stmt_execute($stmt);
                    }
                }
            }
            
            $success = "Item updated successfully!";
            
            // Refresh item data
            $sql = "SELECT * FROM items WHERE id = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $item = mysqli_fetch_assoc($result);
            
            // Refresh item ingredients
            $sql = "SELECT i.id, i.name, ii.quantity 
                    FROM ingredients i 
                    JOIN item_ingredient ii ON i.id = ii.ingredient_id 
                    WHERE ii.item_id = ?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $item_ingredients = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $item_ingredients[] = $row;
            }
            header('Location: admin.php');
            exit;
        } else {
            $error = "Error updating item: " . mysqli_error($con);
        }
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
                <label for="name">Item Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>" <?= $item['category'] === $category['name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Current Image:</label>
                <?php if (!empty($item['img_url'])): ?>
                    <img src="<?= htmlspecialchars($item['img_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="current-image">
                <?php else: ?>
                    <p>No image available</p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="image">Change Image (leave empty to keep current):</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <div class="ingredient-container">
                <h3>Ingredients</h3>
                <div id="ingredients_list">
                    <?php foreach ($item_ingredients as $index => $ingredient): ?>
                        <div class="ingredient-row">
                            <select name="ingredients[]" required>
                                <?php foreach ($ingredients as $ing): ?>
                                    <option value="<?= htmlspecialchars($ing['id']) ?>" <?= $ing['id'] === $ingredient['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($ing['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="number" name="ingredient_quantities[]" min="0" value="<?= htmlspecialchars($ingredient['quantity']) ?>" required placeholder="Quantity">
                            <button type="button" class="remove-ingredient-btn" onclick="removeIngredient(this)">Remove</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="add-ingredient-btn" onclick="addIngredient()">Add Ingredient</button>
            </div>

            <div class="form-group">
                <label for="price_l">Large Price:</label>
                <input type="number" id="price_l" name="price_l" step="1" min="0" value="<?= htmlspecialchars($item['L_price']) ?>">
            </div>
            
            <div class="form-group">
                <label for="price_m">Medium Price:</label>
                <input type="number" id="price_m" name="price_m" step="1" min="0" value="<?= htmlspecialchars($item['M_price']) ?>">
            </div>
            
            <div class="form-group">
                <label for="price_s">Small Price:</label>
                <input type="number" id="price_s" name="price_s" step="1" min="0" value="<?= htmlspecialchars($item['S_price']) ?>">
            </div>
            

            <div class="form-buttons">
                <button type="button" class="cancel-btn" onclick="location.href='admin.php'">Cancel</button>
                <button type="submit" class="save-btn">Save Changes</button>
            </div>
        </form>
    </div>
    <script>
        function addIngredient() {
            const container = document.getElementById('ingredients_list');
            const row = document.createElement('div');
            row.className = 'ingredient-row';
            
            const select = document.createElement('select');
            select.name = 'ingredients[]';
            select.required = true;
            
            // Add options from PHP
            const ingredients = <?= json_encode($ingredients) ?>;
            ingredients.forEach(ingredient => {
                const option = document.createElement('option');
                option.value = ingredient.id;
                option.textContent = ingredient.name;
                select.appendChild(option);
            });
            
            const input = document.createElement('input');
            input.type = 'number';
            input.name = 'ingredient_quantities[]';
            input.min = '0';
            input.required = true;
            input.placeholder = 'Quantity';
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-ingredient-btn';
            removeBtn.textContent = 'Remove';
            removeBtn.onclick = function() { removeIngredient(this); };
            
            row.appendChild(select);
            row.appendChild(input);
            row.appendChild(removeBtn);
            container.appendChild(row);
        }
        
        function removeIngredient(button) {
            const row = button.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>
</body>
</html> 