<?php
// Database connection
require_once 'db_connection.php';

// Add a new city
$city_name = $_POST['city_name'];
$sql = "INSERT INTO cities (city_name) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $city_name);
$result = $stmt->execute();

if ($result) {
    echo "City added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>