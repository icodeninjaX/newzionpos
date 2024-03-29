<?php
// Import the Twilio PHP SDK
require_once 'vendor/autoload.php';
use Twilio\Rest\Client;

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
    $stmt = mysqli_prepare($conn, "INSERT INTO orders (customer_id, total_price, cashier, order_created) VALUES (?, ?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, "ids", $customer_id, $total_price, $cashier);
    $result = mysqli_stmt_execute($stmt);

    $order_id = mysqli_insert_id($conn);



    // Fetch the customer's address
    $address_query = "SELECT cus_address, street, subdivision, barangay, city, first_name, last_name, tel_num,
     landmark FROM customers WHERE id='$customer_id'";
    $address_result = mysqli_query($conn, $address_query);
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


    // Replace these placeholders with your Twilio Account SID, Auth Token, and Twilio phone number
    $account_sid = 'AC7803f099ac7c945d49ff453411daadf5';
    $auth_token = '9e953d934b209a095eaa47a68ac7794c';
    $twilio_phone_number = '+15076206357';


    $branch_phone_number = $_POST['branch_phone_number'];



    // Create a Twilio client
    $client = new Client($account_sid, $auth_token);


    // Prepare the order information for the SMS
    $order_information = "Order details:\n";
    if (isset($_POST['product_name']) && isset($_POST['quantity'])) {
        foreach ($_POST['product_name'] as $index => $product) {
            $order_information .= $product . ', Quantity: ' . $_POST['quantity'][$index] . "\n";
        }
    }
    $order_information .= 'Total ' . $_POST['total_price'] . "\n";
    $order_information .= 'Name ' . $customer_name . "\n";
    $order_information .= 'Address' . $customer_address . "\n";
    $order_information .= 'Telnum' . $customer_tel_num . "\n";
    $order_information .= 'Landmark ' . $landmark . "\n";
    $order_information .= 'Remarks' . $remarks . "\n";


    // Send the SMS
    $message = $client->messages->create(
        $branch_phone_number,
        [
            'from' => $twilio_phone_number,
            'body' => $order_information,
        ]
    );

    // Close the connection
    mysqli_close($conn);

    $_SESSION['order_success'] = "Order added successfully!";
    header("Location: view-customer.php?id=$customer_id");
    exit;

} else {
    header("Location: index.php");
    exit;
}
?>