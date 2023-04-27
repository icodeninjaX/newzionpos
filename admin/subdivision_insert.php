<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db_connection.php';

    // Check if the form type is Subdivision
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'Subdivision') {
        $subdivision_name = mysqli_real_escape_string($conn, $_POST['subdivision_name']);

        // Insert the subdivision into the database
        $sql_insert = "INSERT INTO subdivisions (subdivision_name) VALUES ('$subdivision_name')";
        if (mysqli_query($conn, $sql_insert)) {
            // Redirect to the main page after successful insertion
            header('Location: subdivision_management');
            exit();
        } else {
            echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Invalid form type.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect to the main page if the request method is not POST
    header('Location: subdivision_management');
    exit();
}
?>
