<?php
require_once 'admin_auth_check.php';
requireAdmin();

// Check if the required parameters are set
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("Missing required parameters.");
}

require_once 'db_connection.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);
$type = mysqli_real_escape_string($conn, $_GET['type']);

if ($type === "city") {
    $sql = "DELETE FROM cities WHERE id='$id'";
} else {
    die("Invalid type.");
}

if (mysqli_query($conn, $sql)) {
    header("Location: location_management.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
