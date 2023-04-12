<?php

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the customer data from the AJAX request
$cus_code = $_POST["cus_code"];
$tel_num = $_POST["tel_num"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$cus_address = $_POST["cus_address"];
$street = $_POST["street"];
$subdivision = $_POST["subdivision"];
$landmark = $_POST["landmark"];
$remarks = $_POST["remarks"];
$city = $_POST["city"];
$branch = $_POST["branch"];

// Check if the customer code already exists in the database
$check_sql = "SELECT cus_code FROM customers WHERE cus_code='$cus_code'";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    echo "<script>alert('The customer code you entered already exists in the table. Please try another.');</script>";
} else {
    // Insert the customer data into the database
    $sql = "INSERT INTO customers (cus_code, tel_num, first_name, last_name, cus_address, street, subdivision, 
    landmark, remarks, city, branch) VALUES ('$cus_code', '$tel_num', '$first_name', '$last_name', '$cus_address', '$street', '$subdivision', '$landmark', '$remarks', '$city', '$branch')";
    if (mysqli_query($conn, $sql)) {
        echo "Customer added successfully";
    } else {
        echo "Error adding customer: " . mysqli_error($conn);
    }
}


// Close the database connection
mysqli_close($conn);

?>