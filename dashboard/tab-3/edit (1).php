<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "textiledb";  // Ensure the correct database name is specified

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$id = "";
$Item = "";
$Quantity = "";
$Price = "";
$Location = "";
$Date = "";

$errorMessage = "";
$successMessage = "";

// Check request method
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Retrieve the item data to display in the form

    if (!isset($_GET["id"])) {
        header("location: tab-3.php");
        exit;
    }

    $id = $_GET["id"];

    // Read the row of the selected inventory item
    $sql = "SELECT * FROM inventory WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        $Item = $row["item"];  // Ensure field names match the database
        $Quantity = $row["quantity_in_stock"];
        $Price = $row["price"];
        $Location = $row["location"];
        $Date = $row["date_added"];
    } else {
        header("location: tab-3.php");
        exit;
    }
} else {
    // POST method: Update the item in the database

    $id = $_POST["id"];
    $Item = $_POST["item"];
    $Quantity = $_POST["Quantity"];
    $Price = $_POST["Price"];
    $Location = $_POST["Location"];
    $Date = $_POST["Date"];

    do {
        // Validate input fields
        if (empty($id) || empty($Item) || empty($Quantity) || empty($Price) || empty($Location) || empty($Date)) {
            $errorMessage = "All fields are required";
            break;
        }

        // Update query
        $sql = "UPDATE inventory 
                SET item = '$Item', 
                    quantity_in_stock = '$Quantity', 
                    price = '$Price', 
                    location = '$Location', 
                    date_added = '$Date' 
                WHERE id = $id";

        $result = $conn->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }

        $successMessage = "Item updated successfully";

        // Redirect to the inventory list
        header("Location: tab-3.php");
        exit;

    } while (true);
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

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $errorMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Item</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="item" value="<?php echo $Item; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Quantity</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Quantity" value="<?php echo $Quantity; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Price</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Price" value="<?php echo $Price; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Location</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Location" value="<?php echo $Location; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Date" value="<?php echo $Date; ?>">
                </div>
            </div>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?php echo $successMessage; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="tab-3.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
