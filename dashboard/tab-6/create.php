<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "textiledb";

//create connection 
$connection = new mysqli($servername, $username, $password, $database);

$supplier_name = "";
$contact_info = "";
$address = "";
$product_supplied = [];
$email = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim input values to avoid spaces causing issues
    $supplier_name = trim($_POST["supplier_name"]);
    $contact_info = trim($_POST["contact_info"]);
    $address = trim($_POST["address"]);
    // For checkboxes, we store selected values in an array
    $product_supplied = isset($_POST["product_supplied"]) ? $_POST["product_supplied"] : [];
    $email = trim($_POST["email"]);

    do {
        // Check if any field is empty after trimming spaces
        if (empty($supplier_name) || empty($contact_info) || empty($address) || empty($product_supplied) || empty($email)) {
            $errorMessage = "All the fields are required";
            break;
        }

        // Convert the array of selected products into a comma-separated string
        $product_supplied_str = implode(", ", $product_supplied);

        // Add new supplier to the database
        $sql = "INSERT INTO suppliers (supplier_name, contact_info, address, product_supplied, email) " .
            "VALUES ('$supplier_name', '$contact_info', '$address', '$product_supplied_str', '$email')";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid Query: " . $connection->error;
            break;
        }

        // Reset the form fields
        $supplier_name = "";
        $contact_info = "";
        $address = "";
        $product_supplied = [];
        $email = "";

        // Success message
        $successMessage = "Supplier added successfully";

        // Redirect to another page
        header("location: /IAWD/dashboard/tab-6");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>textiledb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6fb;
        }

        .container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 900px;
        }

        h2 {
            color: #3a0ca3; /* Dark purple */
            font-weight: bold;
        }

        .btn-primary {
            background-color: #5e60ce; /* Purple shade */
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #4a40b5; /* Darker purple */
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        th {
            color: #3a0ca3;
            font-weight: bold;
            text-align: center;
        }

        td {
            background-color: #f8f9fc;
            border-radius: 10px;
            padding: 15x 10px;
            text-align: center;
        }

        td a.btn {
            border-radius: 20px;
        }

        .btn-sm {
            padding: 5px 15px;
        }

        .btn-danger {
            background-color: #ff6b6b;
            border: none;
        }

        .btn-danger:hover {
            background-color: #e85d5d;
        }

        /* Rounded input fields */
        input[type="text"], input[type="email"], select {
            border-radius: 25px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            width: 100%;
        }

        /* Styling links for a flat look */
        a {
            color: #3a0ca3;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .table thead th {
            background-color: #5e60ce;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2>New Supplier</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button>
            </div>
            ";
        }
        ?>
        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Supplier Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="supplier_name" value="<?php echo $supplier_name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contact Info</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contact_info" value="<?php echo $contact_info; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <select class="form-select" name="address" id="address">
                        <option value="">Select Address</option>
                        <option value="Matara" <?php if ($address == "Matara") echo "selected"; ?>>Matara</option>
                        <option value="Galle" <?php if ($address == "Galle") echo "selected"; ?>>Galle</option>
                        <option value="Colombo" <?php if ($address == "Colombo") echo "selected"; ?>>Colombo</option>
                        <option value="Gampaha" <?php if ($address == "Gampaha") echo "selected"; ?>>Gampaha</option>
                        <option value="Jaffna" <?php if ($address == "Jaffna") echo "selected"; ?>>Jaffna</option>
                        <option value="Kalutara" <?php if ($address == "Kalutara") echo "selected"; ?>>Kalutara</option>
                        <option value="Kegalle" <?php if ($address == "Kegalle") echo "selected"; ?>>Kegalle</option>
                        <option value="Ampara" <?php if ($address == "Ampara") echo "selected"; ?>>Ampara</option>
                        <option value="Kandy" <?php if ($address == "Kandy") echo "selected"; ?>>Kandy</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Product Supplied</label>
                <div class="col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="product_supplied[]" value="Trousers" <?php if (in_array("Trousers", $product_supplied)) echo "checked"; ?>>
                        <label class="form-check-label">Trousers</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="product_supplied[]" value="Shirts" <?php if (in_array("Shirts", $product_supplied)) echo "checked"; ?>>
                        <label class="form-check-label">Shirts</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="product_supplied[]" value="T-shirts" <?php if (in_array("T-shirts", $product_supplied)) echo "checked"; ?>>
                        <label class="form-check-label">T-shirts</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="product_supplied[]" value="Sarongs" <?php if (in_array("Sarongs", $product_supplied)) echo "checked"; ?>>
                        <label class="form-check-label">Sarongs</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="product_supplied[]" value="Frocks" <?php if (in_array("Frocks", $product_supplied)) echo "checked"; ?>>
                        <label class="form-check-label">Frocks</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="product_supplied[]" value="Socks" <?php if (in_array("Socks", $product_supplied)) echo "checked"; ?>>
                        <label class="form-check-label">Socks</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="product_supplied[]" value="Undergarments" <?php if (in_array("Undergarments", $product_supplied)) echo "checked"; ?>>
                        <label class="form-check-label">Undergarments</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="product_supplied[]" value="Jackets" <?php if (in_array("Jackets", $product_supplied)) echo "checked"; ?>>
                        <label class="form-check-label">Jackets</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>

            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/textiledb/tab-7.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
