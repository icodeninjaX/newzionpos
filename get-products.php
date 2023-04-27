<?php
require_once 'db_connection.php';

// Retrieve the data from the "product" table
$result = $conn->query("SELECT * FROM products");

// Return the data as a JSON string
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
?>