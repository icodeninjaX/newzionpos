<?php
// Database connection
require_once 'db_connection.php';

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