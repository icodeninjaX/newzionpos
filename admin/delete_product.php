<?php
require_once 'db_connection.php';

$id = $_GET['id'];

$sql = "DELETE FROM products WHERE product_id=" . $id;

if (mysqli_query($conn, $sql)) {
    header("Location: product_management.php");

} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>