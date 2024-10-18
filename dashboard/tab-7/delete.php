<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "textiledb";

    // Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . htmlspecialchars($connection->connect_error));
    }

    // Prepare the SQL DELETE statement
    $sql = "DELETE FROM customers WHERE id = ?";
    $stmt = $connection->prepare($sql);

    // Check if prepare() failed
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($connection->error));
    }

    // Bind the ID parameter
    $stmt->bind_param("i", $id); // "i" means the parameter is an integer

    // Execute the statement
    if ($stmt->execute()) {
        // Optionally, you can provide a success message
        // echo "Record deleted successfully.";
    } else {
        // Handle query error
        echo "Error deleting record: " . htmlspecialchars($stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $connection->close();
}

// Redirect to the specified location after deletion
header("Location: /IAWD/dashboard/tab-7/tab-7.php");
exit;
?>
