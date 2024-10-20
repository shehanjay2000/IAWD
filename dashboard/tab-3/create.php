<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'textiledb');

// Function to establish database connection
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Initialize variables
$errorMessage = "";
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data and sanitize
    $productID = isset($_POST["product_id"]) ? trim($_POST["product_id"]) : '';
    $item = isset($_POST["Item"]) ? trim($_POST["Item"]) : '';
    $quantity = isset($_POST["Quantity"]) ? trim($_POST["Quantity"]) : '';
    $price = isset($_POST["Price"]) ? trim($_POST["Price"]) : '';
    $location = isset($_POST["Location"]) ? trim($_POST["Location"]) : '';
    $date = isset($_POST["Date"]) ? trim($_POST["Date"]) : '';

    // Validate input
    if (empty($productID) || empty($item) || empty($quantity) || empty($price) || empty($location) || empty($date)) {
        $errorMessage = "All fields are required.";
    } elseif (!is_numeric($quantity) || !is_numeric($price)) {
        $errorMessage = "Quantity and Price must be numbers.";
    } else {
        // Check if product_id exists
        $conn = getDBConnection();
        $checkProductStmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
        $checkProductStmt->bind_param("s", $productID);
        $checkProductStmt->execute();
        $result = $checkProductStmt->get_result();

        if ($result->num_rows === 0) {
            $errorMessage = "Product ID does not exist.";
        } else {
            // Prepare the SQL statement
            $stmt = $conn->prepare("INSERT INTO inventory (product_id, Item, quantity_in_stock, price, location, date_added) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssisss", $productID, $item, $quantity, $price, $location, $date);
                // Execute the statement
                if ($stmt->execute()) {
                    $successMessage = "Item added successfully!";
                    // Clear the input fields
                    $productID = $item = $quantity = $price = $location = $date = "";
                } else {
                    $errorMessage = "Error adding item: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $errorMessage = "Error preparing statement: " . $conn->error;
            }
        }
        $checkProductStmt->close();
        $conn->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Edit Inventory</title>
    
</head>
<body>
    <div class="container my-5">
        <h2>Edit Inventory</h2>

        <!-- Error message -->
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?php echo $errorMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Success message -->
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?php echo $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label for="product_id" class="form-label">Product ID</label>
                <input type="text" class="form-control" name="product_id" id="product_id" value="<?php echo isset($productID) ? htmlspecialchars($productID) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Item" class="form-label">Item</label>
                <input type="text" class="form-control" name="Item" id="Item" value="<?php echo isset($item) ? htmlspecialchars($item) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" name="Quantity" id="Quantity" value="<?php echo isset($quantity) ? htmlspecialchars($quantity) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="Price" id="Price" value="<?php echo isset($price) ? htmlspecialchars($price) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Location" class="form-label">Location</label>
                <input type="text" class="form-control" name="Location" id="Location" value="<?php echo isset($location) ? htmlspecialchars($location) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="Date" class="form-label">Date</label>
                <input type="date" class="form-control" name="Date" id="Date" value="<?php echo isset($date) ? htmlspecialchars($date) : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="tab-3.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
