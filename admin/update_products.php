<?php

$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_description = $_POST['description'];
    $product_brand = $_POST['brand'];
    $sku = $_POST['sku'];
    $weight = $_POST['weight'];

    // prepare the SQL statement
    $stmt = mysqli_prepare($conn, "UPDATE products SET product_name=?, price=?, product_description=?, brand=?, sku=?, weight=? WHERE product_id=?");
    mysqli_stmt_bind_param($stmt, 'sssssss', $product_name, $product_price, $product_description, $product_brand, $sku, $weight, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: product_management.php?id=$id");
    } else {
        echo "Failed to update product";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

?>