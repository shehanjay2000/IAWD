<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "textiledb";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

    $id = "";
    $product_name = "";
    $description = "";
    $price ="";
    $category = "";
    $date_added ="";

    $errorMessage = "";
    $successMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        //GET METHOD-SHOW DATA OF THE CLIENT
        if(!isset($_GET['id'])){
            header("location: tab-5.php");
            exit;
        }

        $id = $_GET["id"];

        //post method - update the data of the client
        $sql = "SELECT * FROM products WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        if(!$row){
            header("location: tab-5.php");
            exit;
        }

        $product_name = $row["product_name"];
        $description = $row["description"];
        $price = $row["price"];
        $category = $row["category"];
        $date_added = $row["date_added"];
    
    }
    
    
    else {

        $id = $_POST["id"];
        $product_name = $_POST["product_name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $category = $_POST["category"];
        $date_added = $_POST["date_added"];

        do {
            if ( empty($id) || empty($product_name) || empty($description) || empty($price) || empty($category) || empty($date_added) ) {
                $errorMessage = "All the fields are required";
                break;
            }

            $sql = "UPDATE products
                    SET product_name ='$product_name' , description = '$description' , price = '$price' , category = '$category' , date_added ='$date_added'
                    WHERE id = $id";

            $result = $conn->query($sql);

            if(!$result){
                $errorMessage = "Invalid query: ".$conn->error;
                break;
            }

            $successMessage = "Client updated successfully";

            header("location: tab-5.php");
            exit;

        }while (true);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>New Product</h2>

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
            <input type="hidden"name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Product Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="product_name" value="<?php echo $product_name; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="description" value="<?php echo $description; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Price</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="price" value="<?php echo $price; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Category</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="category" value="<?php echo $category; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Date Added</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="date_added" value="">
                </div>
            </div>

            <?php 
                if (!empty($successMessage)){
                    echo "
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>$successMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
                }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-6 d-flex justify-content-between gap-3">
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                    <button type="button" class="btn btn-secondary w-100" onclick="window.location.href='tab-5.php'">Cancel</button>
                </div>
            </div>
        </form>
    </div>
    
</body>
</html>