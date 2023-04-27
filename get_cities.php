<?php
require_once 'db_connection.php';

$result = $conn->query("SELECT id, city_name FROM cities ORDER BY city_name");

$cities = [];

while ($row = $result->fetch_assoc()) {
  $cities[] = $row;
}

echo json_encode($cities);
