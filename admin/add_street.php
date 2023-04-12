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
