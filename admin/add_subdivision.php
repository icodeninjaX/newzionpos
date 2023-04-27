<?php
// Database connection
require_once 'db_connection.php';

if (isset($_POST['barangay_id']) && isset($_POST['subdivision_name'])) {
    $barangay_id = $_POST['barangay_id'];
    $subdivision_name = $_POST['subdivision_name'];

    // Insert new subdivision into the database
    $sql = "INSERT INTO subdivisions (barangay_id, subdivision_name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $barangay_id, $subdivision_name);
    $result = $stmt->execute();

    if ($result) {
        echo "Subdivision added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
