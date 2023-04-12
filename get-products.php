<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");

// Retrieve the data from the "product" table
$result = $conn->query("SELECT * FROM products");

// Return the data as a JSON string
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
?>