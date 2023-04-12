<?php
require_once 'db_connection.php';

if (isset($_GET['subdivision_id'])) {
  $subdivision_id = $_GET['subdivision_id'];
  $stmt = $conn->prepare("SELECT * FROM streets WHERE subdivision_id = ? ORDER BY street_name");
  $stmt->bind_param("i", $subdivision_id);
  $stmt->execute();
  $result = $stmt->get_result();

  $streets = [];

  while ($row = $result->fetch_assoc()) {
    $streets[] = $row;
  }

  echo json_encode($streets);
}
