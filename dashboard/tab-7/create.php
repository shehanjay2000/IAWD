<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "textiledb";

// Create connection 
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Initialize variables
$customer_name = "";
$email = "";
$phone = "";
$address = "";
$country = "";
$gender = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $country = $_POST["country"];
    $gender = $_POST["gender"];
    
    // Check if terms are accepted
    if (!isset($_POST['terms'])) {
        $errorMessage = "You must agree to the terms and conditions";
    }

    // Validate inputs
    if (empty($customer_name) || empty($email) || empty($phone) || empty($address) || empty($country) || empty($gender)) {
        $errorMessage = "All fields are required";
    } else {
        // Prepare an insert statement
        $sql = "INSERT INTO customers (customer_name, email, phone, address, country, gender) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssss", $customer_name, $email, $phone, $address, $country, $gender);

        if (!$stmt->execute()) {
            $errorMessage = "Invalid Query: " . $connection->error;
        } else {
            $successMessage = "Customer added successfully";
            header("location: /IAWD/dashboard/tab-7/tab-7.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IAWD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Add New Customer</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>
        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($customer_name); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Country</label>
                <div class="col-sm-6">
                    <select class="form-select" name="country" required>
                        <option value="">Select Country</option>
                        <option value="USA" <?php if ($country == "USA") echo "selected"; ?>>USA</option>
                        <option value="Canada" <?php if ($country == "Canada") echo "selected"; ?>>Canada</option>
                        <option value="UK" <?php if ($country == "UK") echo "selected"; ?>>UK</option>
                        <option value="Australia" <?php if ($country == "Australia") echo "selected"; ?>>Australia</option>
                        <option value="India" <?php if ($country == "India") echo "selected"; ?>>India</option>
                        <!-- Add more countries as needed -->
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-6">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" <?php if ($gender == "Male") echo "checked"; ?>>
                        <label class="form-check-label" for="genderMale">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" <?php if ($gender == "Female") echo "checked"; ?>>
                        <label class="form-check-label" for="genderFemale">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="genderOther" value="Other" <?php if ($gender == "Other") echo "checked"; ?>>
                        <label class="form-check-label" for="genderOther">Other</label>
                    </div>
                </div>
            </div>

            <!-- Terms and Conditions Checkbox -->
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="/IAWD/dashboard/tab-7/terms.php" target="_blank">terms and conditions</a>.
                        </label>
                    </div>
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
                    <a class="btn btn-outline-primary" href="/IAWD/dashboard/tab-7/tab-7.php" role="button">Cancel</a>    
                </div>
            </div>
        </form>
    </div>
</body>
</html>
