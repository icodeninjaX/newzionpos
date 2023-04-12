<?php
session_start();

if (isset($_POST['submit'])) {
    $customer_id = $_POST['customer_id'];
    $product_names = $_POST['product_name'];
    $quantities = $_POST['quantity'];
    $total_price = $_POST['total_price'];
    $cashier = $_POST['cashier'];
    $remarks = $_POST['remarks'];

    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "ziondatabase");

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    mysqli_autocommit($conn, false);

    // Insert the order data into the orders table
    $stmt = mysqli_prepare($conn, "INSERT INTO orders (customer_id, total_price, cashier) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ids", $customer_id, $total_price, $cashier);
    $result = mysqli_stmt_execute($stmt);

    $order_id = mysqli_insert_id($conn);


    // Fetch the customer's address
    $address_query = "SELECT cus_address, first_name, last_name, tel_num,
     landmark FROM customers WHERE id='$customer_id'";
    $address_result = mysqli_query($conn, $address_query);
    $address_row = mysqli_fetch_assoc($address_result);
    $customer_address = $address_row['cus_address'];
    $customer_name = $address_row['first_name'] . " " . $address_row['last_name'];
    $landmark = $address_row['landmark'];
    $customer_tel_num = $address_row['tel_num'];




    // Insert the order items data into the order_items table
    $stmt = mysqli_prepare($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    for ($i = 0; $i < count($product_names); $i++) {
        // Get the product_id and individual price
        $product_name = $product_names[$i];
        $query = "SELECT product_id, price FROM products WHERE product_name='$product_name'";
        $result = mysqli_query($conn, $query);
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


    // Prepare the ITEXMO SMS API credentials and endpoint
    $email = 'itexmoclient@gmail.com';
    $password = '123456789ABCD';
    $api_code = 'PR-SAMPL123456_ABCDE';
    $endpoint = 'https://api.itexmo.com/api/broadcast';

    $branch_phone_number = $_POST['branch_phone_number'];

    $order_information = "Order details:\n";
    if (isset($_POST['product_name']) && isset($_POST['quantity'])) {
        foreach ($_POST['product_name'] as $index => $product) {
            $order_information .= $product . ', Quantity: ' . $_POST['quantity'][$index] . "\n";
        }
    }
    $order_information .= 'Total Price: ' . $_POST['total_price'] . "\n";
    $order_information .= 'Customer Name: ' . $customer_name . "\n";
    $order_information .= 'Customer Address: ' . $customer_address . "\n";
    $order_information .= 'Contact No: ' . $customer_tel_num . "\n";
    $order_information .= 'Landmark: ' . $landmark . "\n";
    $order_information .= 'Remarks: ' . $remarks . "\n";

    $ch = curl_init($endpoint);
    // Set the headers for the API request, including the Basic Authorization
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode("$email:$password")
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);

    // Set the data for the ITEXMO API request
    $data = array(
        "Email" => $email,
        "Password" => $password,
        "Recipients" => array($branch_phone_number),
        "Message" => $order_information,
        "ApiCode" => $api_code,
        "SenderId" => "ITEXMO SMS"
    );
    // Encode the data array as a JSON string and set it as the POST data
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request to send the SMS through ITEXMO API
    $response = curl_exec($ch);
    // Check for any errors during the request
    if (curl_errno($ch)) {
        echo curl_error($ch);
    }
    // Output the API response
    echo $response;

    // Close the cURL session
    curl_close($ch);

    // Close the database connection
    mysqli_close($conn);

    // Set the order success message and redirect to the customer view page
    $_SESSION['order_success'] = "Order added successfully!";
    header("Location: view-customer.php?id=$customer_id");
    exit;
} else {
    // If the form was not submitted, redirect to the index page
    header("Location: index.php");
    exit;
}
?>