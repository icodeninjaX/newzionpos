<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ziondatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['city_id'])) {
  $city_id = $_GET['city_id'];
  $stmt = $conn->prepare("SELECT id, barangay_name FROM barangays WHERE city_id = ? ORDER BY barangay_name");
  $stmt->bind_param("i", $city_id);
  $stmt->execute();
  $result = $stmt->get_result();

  $barangays = [];

  while ($row = $result->fetch_assoc()) {
    $barangays[] = $row;
  }

  echo json_encode($barangays);
}
