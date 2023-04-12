<!DOCTYPE html>
<html>

<head>
    <title>Main Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            margin: 0;
            background-color: #F8F9FA;
        }

        #header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #3F51B5;
            padding: 16px;
            color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .settings-container {
            display: flex;
        }

        .settings-container a {
            color: white;
            text-decoration: none;
            margin-left: 16px;
        }

        .settings-container a:hover {
            text-decoration: underline;
        }

        .container {
            display: flex;
        }

        .sidebar {
            background-color: #3F51B5;
            height: 100vh;
            width: 200px;
            padding: 16px;
            position: fixed;
            top: 68px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            top: 81px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;

        }

        .sidebar li a {
            display: block;
            text-decoration: none;
            color: white;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 8px;
            transition: background-color 0.3s;
            font-weight: 500;
        }

        .sidebar li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar li.active a {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 700;
        }

        .main-content {
            flex-grow: 1;
            padding: 16px;
            background-color: #F8F9FA;
            margin-left: 200px;
            margin-top: 80px;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            border-radius: 4px;

        }

        table thead th {
            background-color: #3F51B5;
            color: white;
            text-align: left;
            padding: 12px;
            border-radius: 4px;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #ddd;
        }

        table tbody td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .search-form {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            width: 35%;
        }

        .search-form input[type="text"] {
            border: none;
            outline: none;
            padding: 8px;
            font-size: 14px;
            flex-grow: 1;
        }

        .search-form button {
            background-color: #3F51B5;
            color: white;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            outline: none;
            transition: background-color 0.3s;
        }

        .search-form button:hover {
            background-color: #283593;
        }

        button {
            background-color: #3F51B5;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #283593;
        }

        .delete-button,
        .cancel-button {
            background-color: #f44336;
        }

        .delete-button:hover,
        .cancel-button:hover {
            background-color: #d32f2f;
        }

        .logo {
            max-width: 50px;
            /* Adjust this value according to your desired logo size */
            max-height: 50px;
            /* Adjust this value according to your desired logo size */
            height: auto;
        }

        th {
            background-color: #3F51B5;
            color: white;
            padding: 12px;
        }

        .pagination {
            text-align: center;
            margin: 16px 0;
        }

        .pagination a {
            display: inline-block;
            margin: 0 4px;
            padding: 8px 12px;
            text-decoration: none;
            background-color: #3F51B5;
            color: white;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a.active,
        .pagination a:hover {
            background-color: #283593;
        }

        .dashboard-box {
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            margin-right: 20px;
            flex-basis: calc(25% - 20px);
            box-sizing: border-box;
            transition: all 0.3s;
        }

        .dashboard-box h3 {
            margin-bottom: 10px;
            font-weight: 500;
            font-size: 18px;
            color: #3F51B5;
        }

        .dashboard-box .number {
            font-size: 48px;
            font-weight: 700;
            color: #3F51B5;
        }

        .dashboard-box .icon {
            font-size: 48px;
            color: #3F51B5;
            margin-bottom: 10px;
        }

        .dashboard-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.16), 0 4px 6px rgba(0, 0, 0, 0.23);
        }

        .dashboard-container {
            display: flex;
            justify-content: space-between;
        }

        .quick-stats {
            display: flex;
            justify-content: space-between;

        }

        .quick-stat {
            width: 30%;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            font-size: 15px;
            font-weight: 700;
            color: #3F51B5;
        }

        .content-section {
            justify-content: space-between;
        }

        .recent-activity {
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
        }


        .activity-group {
            width: 48%;
            background-color: #ffffff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            display: flex;
            flex-direction: column;
            margin: 10px;
        }

        .activity-group ul li {
            font-size: 14px;
            padding: 12px;
            background-color: #f2f2f2;
            margin-bottom: 8px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .activity-group ul li:hover {
            background-color: #ddd;
        }

        .activity-group ul li span {
            font-weight: 500;
            color: #3F51B5;
        }

        .activity-group ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }


        .activity-group li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
        }


        .activity-group li:last-child {
            border-bottom: none;
        }

        .activity-group-title {
            font-size: 18px;
            font-weight: 500;
            color: #3F51B5;
            margin-bottom: 16px;
        }


        .wrapper {
            display: flex;
            flex-direction: column;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
            }

            to {
                transform: translateY(0);
            }
        }

        .animated {
            animation-duration: 0.5s;
            animation-fill-mode: both;
        }

        .animated.fadeIn {
            animation-name: fadeIn;
        }

        .animated.slideIn {
            animation-name: slideIn;
        }

        .order-icon {
            color: white;
            font-size: 15px;
            margin-right: 5px;
        }
    </style>
</head>

<body>


    <?php
    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "ziondatabase");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

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

    $latest_orders_query = "SELECT orders.*, customers.first_name, customers.last_name FROM orders JOIN customers ON orders.customer_id = customers.id ORDER BY orders.order_created DESC LIMIT 5";
    $latest_orders_result = mysqli_query($conn, $latest_orders_query);


    $new_customers_query = "SELECT * FROM customers ORDER BY id DESC LIMIT 5";
    $new_customers_result = mysqli_query($conn, $new_customers_query);


    // Close the connection
    mysqli_close($conn);
    ?>

    <div id="header-container" class="animated fadeIn">
        <a href="main_dashboard.php"><img src="img/background.jpg" alt="" class="logo"></a>
        <div class="settings-container">
            <a href="#"><i class="material-icons">settings</i></a>
            <a href="#"><i class="material-icons">person</i></a>
            <a href="#"><i class="material-icons">admin_panel_settings</i></a>
            <a href="logout.php">LOG OUT</a>
        </div>
    </div>

    <div class="container">
        <div class="sidebar animated slideIn">
            <ul>
                <li><a href="order_management.php" style="font-size: 12px;"><i class="material-icons order-icon"
                            style="vertical-align: middle;">assignment</i>Order Management</a></li>
                <li><a href="customer.php" style="font-size: 12px;"><i class="material-icons order-icon"
                            style="vertical-align: middle;">group</i>Registered Customer</a></li>
                <li><a href="product_management.php" style="font-size: 12px;"><i
                            class="material-icons order-icon" style="vertical-align: middle;">list</i>Product
                        Management</a></li>
                <li><a href="registered_branch.php" style="font-size: 12px;"><i class="material-icons order-icon"
                            style="vertical-align: middle;">store</i>Registered Branch</a></li>
                <li><a href="sales_report.php" style="font-size: 12px;"><i class="material-icons order-icon"
                            style="vertical-align: middle;">bar_chart</i>Sales Report</a></li>
            </ul>
        </div>
        <div class="main-content animated fadeIn">
            <div class="content-header">
                <h1>Welcome to the Main Dashboard</h1>
            </div>
            <div class="dashboard-container">
                <div class="dashboard-box">
                    <i class="material-icons icon">shopping_cart</i>
                    <h3>Total Orders</h3>
                    <div class="number">
                        <?php echo $total_orders; ?>
                    </div>
                </div>
                <div class="dashboard-box">
                    <i class="material-icons icon">people</i>
                    <h3>Total Customers</h3>
                    <div class="number">
                        <?php echo $total_customers; ?>
                    </div>
                </div>
                <div class="dashboard-box">
                    <i class="material-icons icon">store</i>
                    <h3>Total Branches</h3>
                    <div class="number">
                        <?php echo $total_branches; ?>
                    </div>
                </div>
                <div class="dashboard-box" style="margin-right: 0;">
                    <i class="material-icons icon">inventory_2</i>
                    <h3>Total Products</h3>
                    <div class="number">
                        <?php echo $total_products; ?>
                    </div>
                </div>
            </div>
            <div class="content-section">
                <h2>Quick Statistics</h2>
                <div class="quick-stats">
                    <div class="quick-stat">
                        <i class="material-icons icon">shopping_cart</i>
                        <h3>New Orders Today</h3>
                        <div class="number">
                            <?php
                            // Fetch and display the number of new orders today
                            echo $new_orders_today; ?>
                        </div>
                    </div>
                    <div class="quick-stat">
                        <i class="material-icons icon">person_add</i>
                        <h3>New Customers Today</h3>
                        <div class="number">
                            <?php echo $new_customers_today; ?>
                        </div>
                    </div>
                    <div class="quick-stat">
                        <i class="material-icons icon">star_border</i>
                        <h3>Top Selling Product</h3>
                        <div class="number">
                            <?php echo $top_selling_product; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-section">
                <h2>Recent Activity</h2>
                <div class="recent-activity">
                    <div class="activity-group">
                        <h3>Latest Orders</h3>
                        <ul>
                            <?php while ($row = mysqli_fetch_assoc($latest_orders_result)): ?>
                                <li>
                                    <?php echo $row['order_id'] . ' - ' . $row['first_name'] . ' ' . $row['last_name'] . ' - ' . $row['order_created'] . ' - ' . $row['total_price']; ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <div class="activity-group">
                        <h3>New Customers</h3>
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