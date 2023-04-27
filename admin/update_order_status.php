<?php

require_once 'db_connection.php';

if (isset($_POST['order_id'])) {
  $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);

  $sql = "UPDATE orders SET status = 'Delivered' WHERE order_id = '$order_id'";

  if (mysqli_query($conn, $sql)) {
    echo "Order cancelled successfully";
    header("Location:order_management.php");
  } else {
    echo "Error cancelling order: " . mysqli_error($conn);
  }
}

mysqli_close($conn);

?>