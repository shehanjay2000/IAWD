<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'textiledb'); // Update with your database credentials

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

// Prepare and bind
$stmt = $conn->prepare("DELETE FROM payments WHERE id = ?");
$stmt->bind_param("i", $id);

// Execute the statement
$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = $stmt->error;
}

$stmt->close();
$conn->close();

// Return the response
header('Content-Type: application/json');
echo json_encode($response);
