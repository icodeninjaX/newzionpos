<?php
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];

$sql = "DELETE FROM products WHERE product_id=" . $id;

if (mysqli_query($conn, $sql)) {
    header("Location: product_management.php");

} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>