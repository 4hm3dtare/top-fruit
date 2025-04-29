<?php 
// Database connection
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'top fruit';

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to generate menu cards for a specific category
function generateMenuCards($category, $con) {
    $sql = "SELECT * FROM items WHERE category = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($con));
    }
    
    mysqli_stmt_bind_param($stmt, "s", $category);
    if (!mysqli_stmt_execute($stmt)) {
        die("Execute failed: " . mysqli_stmt_error($stmt));
    }
    
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        die("Get result failed: " . mysqli_error($con));
    }
    
    $output = '';
    while($row = mysqli_fetch_assoc($result)) {
        // Set default values if fields are missing
        $image_url = isset($row['image_url']) ? $row['image_url'] : 'default-image.jpg';
        $L_price = isset($row['L_price']) ? $row['L_price'] : '0.00';
        $M_price = isset($row['M_price']) ? $row['M_price'] : '0.00';
        $S_price = isset($row['S_price']) ? $row['S_price'] : '0.00';

        $output .= '
        <div class="menu-card">
            <div class="image-container">
                <img src="' . htmlspecialchars($image_url) . '" alt="' . htmlspecialchars($row['name']) . '" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="info-container">
                <div class="name-container">' . htmlspecialchars($row['name']) . '</div>
                <div class="price-container">
                    <div class="size-price">
                        <div class="size-indicator l">L</div>
                        <span class="price">' . htmlspecialchars($L_price) . '$</span>
                    </div>
                    <div class="divider"></div>
                    <div class="size-price">
                        <div class="size-indicator m">M</div>
                        <span class="price">' . htmlspecialchars($M_price) . '$</span>
                    </div>
                    <div class="divider"></div>
                    <div class="size-price">
                        <div class="size-indicator s">S</div>
                        <span class="price">' . htmlspecialchars($S_price) . '$</span>
                    </div>
                </div>
            </div>
            <div class="item-number size-l" style="display: none;">
                <span>large number:</span>
                <input type="number" min="0" value="0" class="quantity-input">
            </div>
            <div class="item-number size-m" style="display: none;">
                <span>medium number:</span>
                <input type="number" min="0" value="0" class="quantity-input">
            </div>
            <div class="item-number size-s" style="display: none;">
                <span>small number:</span>
                <input type="number" min="0" value="0" class="quantity-input">
            </div>
        </div>';
    }
    return $output;
}

// Get categories
$sql = "SELECT id, name FROM categories";
$result = mysqli_query($con, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <title>Top Fruit</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="styles.css" />
    <script src="script.js" defer></script>

    <style>
        /* Dynamic width styles */
        .menu-content {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            padding: 15px;
            box-sizing: border-box;
        }
        
        .category-sector {
            display: none;
            width: 100%;
        }
        
        .category-sector.active {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            width: 100%;
        }
        
        .menu-card {
            width: 100%;
            max-width: 300px;
            min-width: 0; 
        }

        .name-container {
        font-size: 20px;
        line-height: 1.2;
        height: 2.4em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        transition: font-size 0.2s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .category-sector.active {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
        
        @media (max-width: 480px) {
            .category-sector.active {
                grid-template-columns: 1fr;
            }
        }
    </style>

</head>
<body>
<div class="menu-board">
    <div class="fixed-header">
        <header class="menu-header">
            <div class="header-container">
                <div class="header-buttons">
                    <div class="header-button new-order">new order</div>
                    <a href="login_admin.php" class="header-button admin">
                        admin
                    </a>
                </div>
                <div class="logo">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='red'%3E%3Ccircle cx='12' cy='12' r='10'/%3E%3C/svg%3E" alt="" class="fruit-icon" />
                    <h1>top fruit</h1>
                </div>
            </div>
            <div class="categories">
                <?php foreach ($categories as $category) { ?>
                    <span class="category" data-category="<?= htmlspecialchars($category['name']) ?>"><?= htmlspecialchars($category['name']) ?></span>
                <?php } ?>
            </div>
        </header>
    </div>

    <div class="menu-content">
        <?php foreach ($categories as $category) { ?>
            <div class="category-sector <?= $category['name'] === 'top-fruit' ? 'active' : '' ?>" data-category="<?= htmlspecialchars($category['name']) ?>">
                <?= generateMenuCards($category['name'], $con) ?>
            </div>
        <?php } ?>
    </div>
</div>

<div class="footer-bar">
    <div class="total-section">
        <span class="total-label">:Total Price </span>
        <span class="total-amount">00$</span>
    </div>
    <div class="action-buttons">
        <button class="cancel-btn">Cancel</button>
        <button class="done-btn">Done</button>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>




