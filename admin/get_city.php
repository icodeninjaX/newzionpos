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
$result = $conn->query("SELECT id, city_name FROM cities ORDER BY city_name");

$cities = [];

while ($row = $result->fetch_assoc()) {
  $cities[] = $row;
}

echo json_encode($cities);

