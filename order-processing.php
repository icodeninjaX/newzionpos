<?php

require_once 'db_connection.php';

if (isset($_POST['customer_code']) && isset($_POST['order_date']) && isset($_POST['product_code']) && isset($_POST['quantity'])) {
  $customer_code = $_POST['customer_code'];
  $order_date = $_POST['order_date'];
  $product_code = $_POST['product_code'];
  $quantity = $_POST['quantity'];


  // Insert the order into the database
  $sql = "INSERT INTO order_history (customer_id, order_date, product_id, qty)
          VALUES ('$customer_code', '$order_date', '$product_code', '$quantity')";
  $result = mysqli_query($conn, $sql);

  // Check if the order was successfully inserted
  if ($result) {
    echo "<script>alert('Order created successfully.');</script>";
  } else {
    echo "<script>alert('Error: Could not create order.');</script>";
  }

  // Close the connection
  mysqli_close($conn);
}
?>