<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ziondatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add a new barangay
$city_id = $_POST['city_id'];
$barangay_name = $_POST['barangay_name'];
$sql = "INSERT INTO barangays (city_id, barangay_name) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $city_id, $barangay_name);
$result = $stmt->execute();

if ($result) {
    echo "Barangay added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
