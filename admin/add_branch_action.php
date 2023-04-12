<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert branch
$branch_name = mysqli_real_escape_string($conn, $_POST['branch_name']);
$contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$sql = "INSERT INTO branches (branch_name, contact_number, address) VALUES ('$branch_name', '$contact_number', '$address')";

if (mysqli_query($conn, $sql)) {
    header("Location: registered_branch.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>