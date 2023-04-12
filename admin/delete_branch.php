<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Delete branch
$id = intval($_GET['id']);
$sql = "DELETE FROM branches WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: registered_branch.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>