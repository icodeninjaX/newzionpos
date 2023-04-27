<!DOCTYPE html>
<html>

<head>
    <title>City Management</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dongle:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>


    <?php
    // Database connection
    require_once 'db_connection.php';

    // Fetch the total number of orders
    $sql_orders = "SELECT COUNT(*) as total_orders FROM orders";
    $result_orders = mysqli_query($conn, $sql_orders);
    $row_orders = mysqli_fetch_assoc($result_orders);
    $total_orders = $row_orders['total_orders'];

    // Fetch the total number of customers
    $sql_customers = "SELECT COUNT(*) as total_customers FROM customers";
    $result_customers = mysqli_query($conn, $sql_customers);
    $row_customers = mysqli_fetch_assoc($result_customers);
    $total_customers = $row_customers['total_customers'];

    // Fetch the total number of registered branches
    $sql_branches = "SELECT COUNT(*) as total_branches FROM branches";
    $result_branches = mysqli_query($conn, $sql_branches);
    $row_branches = mysqli_fetch_assoc($result_branches);
    $total_branches = $row_branches['total_branches'];

    // Fetch the total number of products
    $sql_products = "SELECT COUNT(*) as total_products FROM products";
    $result_products = mysqli_query($conn, $sql_products);
    $row_products = mysqli_fetch_assoc($result_products);
    $total_products = $row_products['total_products'];

    $new_orders_today_query = "SELECT COUNT(*) as new_orders_today FROM orders WHERE DATE(order_created) = CURDATE()";
    $result = mysqli_query($conn, $new_orders_today_query);
    $row = mysqli_fetch_assoc($result);
    $new_orders_today = $row['new_orders_today'];

    // Fetch new customers today
    $new_customers_today_query = "SELECT COUNT(*) as new_customers_today FROM customers WHERE DATE(registered_date) = CURDATE()";
    $result = mysqli_query($conn, $new_customers_today_query);
    $row = mysqli_fetch_assoc($result);
    $new_customers_today = $row['new_customers_today'];

    // Fetch top-selling product
    $top_selling_product_query = "SELECT product_name FROM products ORDER BY total_sold DESC LIMIT 1";
    $result = mysqli_query($conn, $top_selling_product_query);
    $row = mysqli_fetch_assoc($result);
    $top_selling_product = $row['product_name'];

    $latest_orders_query = "SELECT orders.*, customers.first_name, customers.last_name FROM orders JOIN customers ON orders.customer_id = customers.id ORDER BY orders.order_created DESC LIMIT 3";
    $latest_orders_result = mysqli_query($conn, $latest_orders_query);


    $new_customers_query = "SELECT * FROM customers ORDER BY id DESC LIMIT 3";
    $new_customers_result = mysqli_query($conn, $new_customers_query);


    // Close the connection
    mysqli_close($conn);
    ?>

    <div id="header-container">
        <a href="main_dashboard.php"><img src="img/background-removebg-preview.png" alt="" class="logo"></a>
        <div class="settings-container">
            <a href="#"><img src="img/settings.png" alt="gas" class="order-img"></a>
            <a href="#"><img src="img/edit-profile.png" alt="gas" class="order-img"></a>
            <a href="#"><img src="img/change-password.png" alt="gas" class="order-img"></a>
        </div>
    </div>

    <div class="container">
        <div class="sidebar animated slideIn">
            <ul>
                <!-- Your existing menu items -->
                <li><a href="order_management.php" style="font-size: 18px;" class="ordermanagement"><img
                            src="img/inventory-management.png" alt="gas" class="orders">Order Management</a></li>
                <li><a href="customer.php" style="font-size: 18px;" class="ordermanagement"><img
                            src="img/customer-1.png" alt="gas" class="orders">Registered Customer</a></li>
                <li><a href="product_management.php" style="font-size: 18px;" class="ordermanagement"><img
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
        <div class="main-content">
            <div class="content-header">
                <h1
                    style="font-size: 25px; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                    <img src="img/home.png" alt="gas" class="home">Main Dashboard
                </h1>
            </div>
            <div class="dashboard-container">
                <div class="dashboard-box">
                    <img src="img/cargo.png" alt="gas" class="gas">
                    <h3>Total Orders</h3>
                    <div class="number">
                        <?php echo $total_orders; ?>
                    </div>
                </div>
                <div class="dashboard-box">
                    <img src="img/rating.png" alt="gas" class="gas">
                    <h3>Total Customers</h3>
                    <div class="number">
                        <?php echo $total_customers; ?>
                    </div>
                </div>
                <div class="dashboard-box">
                    <img src="img/branch.png" alt="gas" class="gas">
                    <h3>Total Branches</h3>
                    <div class="number">
                        <?php echo $total_branches; ?>
                    </div>
                </div>
                <div class="dashboard-box">
                    <img src="img/gas.png" alt="gas" class="gas">
                    <h3>Total Products</h3>
                    <div class="number">
                        <?php echo $total_products; ?>
                    </div>
                </div>
                <div class="dashboard-box">
                    <img src="img/delivery-service.png" alt="gas" class="gas">
                    <h3>New Orders Today</h3>
                    <div class="number">
                        <?php
                        // Fetch and display the number of new orders today
                        echo $new_orders_today; ?>
                    </div>
                </div>
                <div class="dashboard-box">
                    <img src="img/customer.png" alt="gas" class="gas">
                    <h3>New Customers Today</h3>
                    <div class="number">
                        <?php echo $new_customers_today; ?>
                    </div>
                </div>
                <div class="dashboard-box">
                    <img src="img/best-seller.png" alt="gas" class="gas">
                    <h3>Top Selling Product</h3>
                    <div class="number">
                        <?php echo $top_selling_product; ?>
                    </div>
                </div>

            </div>

            <div class="content-section">
                <h2>Recent Activity</h2>
                <div class="recent-activity">
                    <div class="activity-group">
                        <h3><i class="material-icons icon"
                                style="vertical-align: text-top; margin-right: 5px;">shopping_cart</i>Latest Orders</h3>
                        <ul>
                            <?php while ($row = mysqli_fetch_assoc($latest_orders_result)): ?>
                                <li>
                                    <?php echo $row['order_id'] . ' - ' . $row['first_name'] . ' ' . $row['last_name'] . ' - ' . $row['order_created'] . ' - ' . $row['total_price']; ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <div class="activity-group">
                        <h3><i class="material-icons icon"
                                style="vertical-align: text-top; margin-right: 5px;">supervised_user_circle</i>New
                            Customers</h3>
                        <ul>
                            <?php while ($row = mysqli_fetch_assoc($new_customers_result)): ?>
                                <li>
                                    <?php echo "Name: " . $row['first_name'] . ' ' . $row['last_name'] . ' --- Date Added: ' . $row['registered_date']; ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>