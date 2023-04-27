<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
// Connect to the database
require_once 'db_connection.php';
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dongle:wght@400;700&display=swap" rel="stylesheet">

</head>


<body>

    <div id="header-container">
        <a href="main_dashboard.php"><img src="img/background-removebg-preview.png" alt="" class="logo"></a>
        <div class="settings-container">
            <a href="#"><img src="img/settings.png" alt="gas" class="order-img"></a>
            <a href="#"><img src="img/edit-profile.png" alt="gas" class="order-img"></a>
            <a href="#"><img src="img/change-password.png" alt="gas" class="order-img"></a>
        </div>
    </div>
    <div class="container">
        <div class="sidebar">
            <!-- Add your existing sidebar content here -->
            <ul>
                <!-- Your existing menu items -->
                <li><a href="order_management.php" style="font-size: 18px;" class="ordermanagement"><img
                            src="img/inventory-management.png" alt="gas" class="orders">Order Management</a></li>
                <li><a href="customer.php" style="font-size: 18px;" class="ordermanagement"><img
                            src="img/customer-1.png" alt="gas" class="orders">Registered Customer</a></li>
                <li class="active"><a href="product_management.php" style="font-size: 18px;" class="ordermanagement"><img
                            src="img/gas-2.png" alt="gas" class="orders">Product Management</a></li>
                <li><a href="registered_branch.php" style="font-size: 18px;" class="ordermanagement"><img
                            src="img/franchise.png" alt="gas" class="orders">Registered Branch</a></li>
                <li><a href="sales_report.php" style="font-size: 18px;" class="ordermanagement"><img src="img/sales.png"
                            alt="gas" class="orders">Sales Report</a></li>
                <p style="font-size: 10px; text-align: center; font-weight: bold;">Location Management</p>
                <li><a href="city_management.php" style="font-size: 17px;" class="ordermanagement"><img
                            src="img/location.png" alt="gas" class="orders">City Management</a></li>
                <li><a href="barangay_management.php" style="font-size: 17px;" class="ordermanagement"><img
                            src="img/location.png" alt="gas" class="orders">Barangay Management</a></li>
                <li><a href="subdivision_management.php" style="font-size: 16px;" class="ordermanagement"><img
                            src="img/location.png" alt="gas" class="orders">Subdivision Management</a></li>
                <li><a href="street_management.php" style="font-size: 17px;" class="ordermanagement"><img
                            src="img/location.png" alt="gas" class="orders">Street Management</a></li>
                <br>
                <li><a href="logout.php" class="ordermanagement log-out" style="font-size: 20px;"><img
                            src="img/logout.png" alt="gas" class="orders">LOG OUT</a></li>
            </ul>
        </div>

        <?php

        // Pagination settings
        $limit = 10; // Number of products per page
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        // Get the total number of products
        $total_result = mysqli_query($conn, "SELECT COUNT(*) FROM products");
        $total_rows = mysqli_fetch_array($total_result)[0];
        $total_pages = ceil($total_rows / $limit);

        // Retrieve a limited list of products from the database
        $sql = "SELECT product_id, product_name, price, product_description, brand, sku, weight, date_added FROM products LIMIT $start, $limit";
        $result = mysqli_query($conn, $sql);
        ?>

        <div class="main-content">
            <div class="content-header">
                <h1
                    style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size: 25px; vertical-align: middle;">
                    <img src="img/product-management.png" alt="Orders" class="order-img">Product Management</h1>
                <button class="add-product"><a href="product_add_form.php"><i class="material-icons order-icon"
                            style="vertical-align: text-top; font-size: 20px; font-weight: bold;">add</i>ADD
                        PRODUCTS</a></button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Product Description</th>
                        <th>Brand</th>
                        <th>SKU</th>
                        <th>Weight</th>
                        <th>Date Added</th>
                        <th colspan="2" style="text-align: center;">Modify</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if the query returned any results
                    if (mysqli_num_rows($result) > 0) {
                        // Output each product as a table row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["product_id"] . "</td>";
                            echo "<td>" . $row["product_name"] . "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                            echo "<td>" . $row["product_description"] . "</td>";
                            echo "<td>" . $row["brand"] . "</td>";
                            echo "<td>" . $row["sku"] . "</td>";
                            echo "<td>" . $row["weight"] . "</td>";
                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row["date_added"]);
                            if ($date !== false) {
                                $formattedDate = $date->format('F d, Y - h:i    A');
                                echo "<td>" . $formattedDate . "</td>";
                            } else {
                                echo "<td>" . $row["date_added"] . "</td>";
                            }
                            echo "<td><button class='edit-btn'><a href='update_form_products.php?id=" . $row['product_id'] . "'><i class='material-icons delete-icon'>edit</i></a></button></td>";
                            echo "<td><button class='delete-btn'><a href='delete_product.php?id=" . $row['product_id'] . "'><i class='material-icons edit-icon'>delete</i></a></button></td>";

                            echo "</tr>";
                        }
                    } else {
                        // Display an error message if no products were found
                        echo "No products found";
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>

        </div>

    </div>
</body>

</html>