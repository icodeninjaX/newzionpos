<?php
// Database connection
require_once 'db_connection.php';

// Update branch
$id = intval($_POST['id']);
$branch_name = mysqli_real_escape_string($conn, $_POST['branch_name']);
$contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$sql = "UPDATE branches SET branch_name = '$branch_name', contact_number = '$contact_number', address = '$address' WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: registered_branch.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>