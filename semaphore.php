<?php
session_start();
require_once 'db_connection.php';

if (isset($_POST['submit'])) {
    $customer_id = $_POST['customer_id'];
    $product_names = $_POST['product_name'];
    $quantities = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $cashier = $_POST['cashier'];
    $remarks = $_POST['remarks'];

    mysqli_autocommit($conn, false);

    // Insert the order data into the orders table
    $order_created = date('Y-m-d H:i:s');
    $stmt = mysqli_prepare($conn, "INSERT INTO orders (customer_id, total_price, cashier, order_created) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "idss", $customer_id, $total_price, $cashier, $order_created);
    $result = mysqli_stmt_execute($stmt);


    $order_id = mysqli_insert_id($conn);


    // Fetch the customer's address
    $address_query = "SELECT cus_address, street, subdivision, barangay, city, first_name, last_name, tel_num, landmark FROM customers WHERE id=?";
    $stmt = mysqli_prepare($conn, $address_query);
    mysqli_stmt_bind_param($stmt, "i", $customer_id);
    mysqli_stmt_execute($stmt);
    $address_result = mysqli_stmt_get_result($stmt);
    $address_row = mysqli_fetch_assoc($address_result);
    $customer_address = $address_row['cus_address'] . " " . $address_row['street'] . " " . $address_row['subdivision'] . " " . $address_row['barangay'] . " " . $address_row['city'];
    $customer_name = $address_row['first_name'] . " " . $address_row['last_name'];
    $landmark = $address_row['landmark'];
    $customer_tel_num = $address_row['tel_num'];




    // Insert the order items data into the order_items table
    $stmt = mysqli_prepare($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    for ($i = 0; $i < count($product_names); $i++) {

        // Get the product_id and individual price

        list($product_name, $item_price) = explode("|", $product_names[$i]);
        $query = "SELECT product_id, price FROM products WHERE product_name=?";
        $stmt_product = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt_product, "s", $product_name);
        mysqli_stmt_execute($stmt_product);
        $result = mysqli_stmt_get_result($stmt_product);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $product_id = $row['product_id'];
            $price = $row['price'];
        } else {
            // Handle the case when the product is not found
            echo "Product not found: " . $product_name;
            exit;
        }

        // Insert the order item with the individual price
        $quantity = $quantities[$i];
        mysqli_stmt_bind_param($stmt, "iiid", $order_id, $product_id, $quantity, $price);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo "Error inserting order item: " . mysqli_stmt_error($stmt);
            exit;
        }
    }
    mysqli_stmt_close($stmt);

    mysqli_commit($conn);


    // Prepare the order information for the SMS
    // ... (Same as in your original code)

    $order_information = "Order details\n";
    if (isset($_POST['product_name']) && isset($_POST['quantity'])) {
        foreach ($_POST['product_name'] as $index => $product) {
            $order_information .= $product . ', Quantity' . $_POST['quantity'][$index] . "\n";
        }
    }
    $order_information .= $_POST['total_price'] . "\n";
    $order_information .= $customer_name . "\n";
    $order_information .= $customer_address . "\n";
    $order_information .= $customer_tel_num . "\n";
    $order_information .= $landmark . "\n";
    $order_information .= $remarks . "\n";

    // Send the SMS using Semaphore
    $branch_phone_number = $_POST['branch_phone_number'];
    $semaphore_api_key = '5a28645a2b23128ca79ed7c64c0c5ae9'; // Replace with your Semaphore API key

    $ch = curl_init();
    $parameters = array(
        'apikey' => $semaphore_api_key,
        'number' => $branch_phone_number,
        'message' => $order_information,
        'sendername' => 'SEMAPHORE' // Replace with your desired sender name
    );
    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/priority');
    curl_setopt($ch, CURLOPT_POST, 1);

    // Send the parameters set above with the request
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

    // Receive response from server
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);

    // Close the connection
    mysqli_close($conn);

    $_SESSION['order_success'] = "Order added successfully!";
    exit;


} else {
    header("Location: index.php");
    exit;
}



?>