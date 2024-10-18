<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "textiledb";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Initialize variables
$id = "";
$supplier_name = "";
$contact_info = "";
$address = "";
$product_supplied = "";
$email = "";

$errorMessage = "";
$successMessage = "";

// Check if the request method is GET (when the edit page is first loaded)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Ensure the 'id' parameter is set in the URL
    if (!isset($_GET["id"])) {
        header("Location: /IAWD/dashboard/tab-6");
        exit;
    }

    // Get the supplier ID from the URL
    $id = $_GET["id"];

    // Fetch supplier data from the database
    $sql = "SELECT * FROM suppliers WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);  // Bind the 'id' as an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // If no supplier is found, redirect back
    if (!$row) {
        header("Location: /IAWD/dashboard/tab-6");
        exit;
    }

    // Fill the form fields with the existing data
    $supplier_name = $row["supplier_name"];
    $contact_info = $row["contact_info"];
    $address = $row["address"];
    $product_supplied = $row["product_supplied"];
    $email = $row["email"];
} else {
    // POST METHOD: This happens when the form is submitted
    $id = $_POST["id"];
    $supplier_name = $_POST["supplier_name"];
    $contact_info = $_POST["contact_info"];
    $address = $_POST["address"];
    $product_supplied = $_POST["product_supplied"];
    $email = $_POST["email"];

    // Validate all required fields
    if (empty($supplier_name) || empty($contact_info) || empty($address) || empty($product_supplied) || empty($email)) {
        $errorMessage = "All fields are required!";
    } else {
        // Prepare the SQL query for updating the supplier's data
        $sql = "UPDATE suppliers 
                SET supplier_name = ?, contact_info = ?, address = ?, product_supplied = ?, email = ?
                WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssssi", $supplier_name, $contact_info, $address, $product_supplied, $email, $id);

        // Execute the query
        if ($stmt->execute()) {
            // On success, redirect to the list page
            $successMessage = "Supplier updated successfully!";
           

            header("Location: /IAWD/dashboard/tab-6");
            exit;
        } else {
            $errorMessage = "Error updating record: " . $connection->error;
            echo $connection->error;

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Edit Supplier</h2>

        <!-- Display error message if any -->
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="mb-3">
                <label for="supplier_name" class="form-label">Supplier Name</label>
                <input type="text" class="form-control" name="supplier_name" value="<?= $supplier_name ?>" required>
            </div>

            <div class="mb-3">
                <label for="contact_info" class="form-label">Contact Info</label>
                <input type="text" class="form-control" name="contact_info" value="<?= $contact_info ?>" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" value="<?= $address ?>" required>
            </div>

            <div class="mb-3">
                <label for="product_supplied" class="form-label">Product Supplied</label>
                <input type="text" class="form-control" name="product_supplied" value="<?= $product_supplied ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= $email ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/IAWD/dashboard/tab-6" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
