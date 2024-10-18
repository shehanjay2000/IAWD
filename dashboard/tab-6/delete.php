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

// Check if ID is set in the URL
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Prepare the SQL DELETE statement
    $sql = "DELETE FROM suppliers WHERE id = ?";
    $stmt = $connection->prepare($sql);

    // Check if prepare() failed
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($connection->error));
    }

    // Bind the ID parameter
    $stmt->bind_param("i", $id); // "i" means the parameter is an integer

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect after successful deletion
        header("Location: /IAWD/dashboard/tab-6");
        exit;
    } else {
        // Handle query error
        echo "Error deleting record: " . htmlspecialchars($stmt->error);
    }

    $stmt->close(); // Close the statement
} else {
    // Redirect if no ID is provided
    header("Location: /IAWD/dashboard/tab-6");
    exit;
}

$connection->close(); // Close the database connection
?>
