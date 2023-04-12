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
