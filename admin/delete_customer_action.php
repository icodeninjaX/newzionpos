<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the customer ID from the URL
$customer_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete customer from the database
$sql = "DELETE FROM customers WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $customer_id);
mysqli_stmt_execute($stmt);

// Redirect to the registered customers page after successful deletion
header("Location: customer.php");
exit();
?>