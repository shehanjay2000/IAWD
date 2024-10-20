<?php 
if (isset($_GET["id"])){

    $id = $_GET["id"];

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

    $sql = "DELETE FROM inventory WHERE id=$id";
    $conn->query($sql);
}

    header("location: tab-3.php");
    exit;
?>