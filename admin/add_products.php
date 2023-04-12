<?php

$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["submit"])) {


    // prepare the SQL statement
    $stmt = mysqli_prepare($conn, "INSERT INTO products (product_name, price, product_description, brand, sku, weight) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssssss', $product_name, $product_price, $product_description, $product_brand, $sku, $weight);

    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_description = $_POST['description'];
    $product_brand = $_POST['brand'];
    $sku = $_POST['sku'];
    $weight = $_POST['weight'];

    if (mysqli_stmt_execute($stmt)) {
        header("Location: product_management.php");
    } else {
        echo "No product has been added";
    }
    mysqli_stmt_close($stmt);

} else {
    echo "No record found";
}

mysqli_close($conn);


?>