<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();

require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barangay_name = $_POST["barangay_name"];

    $sql = "INSERT INTO barangays (barangay_name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $barangay_name);
    mysqli_stmt_execute($stmt);

    $_SESSION['barangay_added'] = true;
    header("Location: barangay_management.php");
    exit;
}
?>
