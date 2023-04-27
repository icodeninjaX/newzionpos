<?php


if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    require_once 'db_connection.php';

    // First, delete any rows in the order_items table that reference the order_id
    $delete_order_items_sql = "DELETE FROM order_items WHERE order_id = $order_id";
    if (!mysqli_query($conn, $delete_order_items_sql)) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Then, delete the row from the orders table
    $delete_order_sql = "DELETE FROM orders WHERE order_id = $order_id";
    if (!mysqli_query($conn, $delete_order_sql)) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Redirect back to the add-test.php page
    header("Location: add-test.php");
} else {
    die("No order_id provided");
}
?>