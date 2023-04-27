<?php
// Database connection
require_once 'db_connection.php';

// Add a new street/subdivision
$subdivision_id = $_POST['subdivision_id'];
$street_name = $_POST['street_name'];
$sql = "INSERT INTO streets (subdivision_id, street_name) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $subdivision_id, $street_name);
$result = $stmt->execute();

if ($result) {
    echo "Street/subdivision added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>