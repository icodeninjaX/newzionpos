<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>


<!DOCTYPE html>
<html>

<head>
    <title>Product Management</title>
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

        .container {
            display: flex;
        }

        .sidebar {
            background-color: #3F51B5;
            height: 100vh;
            width: 200px;
            padding: 16px;
            position: fixed;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            top: 80px;
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
            overflow: hidden;
        }

        th,
        td {
            text-align: center;
            border-bottom: 1px solid #ddd;
            width: 5%;
            font-size: 12px;
        }

        tr:hover {
            background-color: rgba(63, 81, 181, 0.1);
        }

        th {
            background-color: #3F51B5;
            color: white;
        }

        .add-product {
            background-color: #3F51B5;
            border: none;
            color: white;
            text-align: center;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            padding: 8px 16px;
            transition: background-color 0.3s;
        }


        button:hover {
            background-color: #5C6BC0;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .logo {
            max-width: 50px;
            /* Adjust this value according to your desired logo size */
            max-height: 50px;
            height: auto;
        }

        .material-icons {
            vertical-align: middle;
        }

        .icon-button {
            font-size: 15px;
            border: none;
        }

        .icon-button:hover {
            background-color: rgba(63, 81, 181, 0.3);
        }

        .settings-container {
            display: flex;
        }

        .settings-container a {
            color: white;
            text-decoration: none;
            margin-left: 16px;
        }

        .header-brand {
            display: flex;
            align-items: center;
        }

        .header-brand-text {
            font-weight: 700;
            font-size: 24px;
            margin-left: 8px;
        }

        /* Pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin-bottom: 16px;
        }

        .pagination a {
            padding: 8px 12px;
            background-color: #3F51B5;
            color: white;
            text-decoration: none;
            margin: 0 4px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #5C6BC0;
        }

        .pagination a.active {
            background-color: #5C6BC0;
            font-weight: 700;
        }

        .order-icon {
            color: white;
            font-size: 15px;
            margin-right: 5px;
        }

        .icon-button.delete {
            background-color: #f44336;
            color: white;
            border-radius: 4px;
        }

        .icon-button.delete:hover {
            background-color: #e53935;
        }

        .icon-button.edit {
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
        }

        .icon-button.edit:hover {
            background-color: #43A047;
        }
    </style>



</head>

<body>

    <div id="header-container">
        <a href="main_dashboard.php"><img src="img/background.jpg" alt="" class="logo"></a>
        <div class="settings-container">
            <a href="#"><i class="material-icons">settings</i></a>
            <a href="#"><i class="material-icons">person</i></a>
            <a href="#"><i class="material-icons">admin_panel_settings</i></a>
            <a href="logout.php">LOG OUT</a>
        </div>

    </div>
    <div class="container">
        <div class="sidebar">
            <!-- Add your existing sidebar content here -->
            <ul>
                <!-- Your existing menu items -->
                <li><a href="order_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">assignment</i>Order Management</a></li>
                <li><a href="customer.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">group</i>Registered Customer</a></li>
                <li class="active"><a href="product_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">list</i>Product Management</a></li>
                <li><a href="registered_branch.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">store</i>Registered Branch</a></li>
                <li><a href="sales_report.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">bar_chart</i>Sales Report</a></li>

                <!-- Location Manager drop-down menu -->
                <li>
                    <details style="font-size: 12px; color: white; font-weight: bold; padding-top: 5px;">
                        <summary>
                            <i class="material-icons order-icon" style="vertical-align: middle; padding-bottom: 5px;">location_city</i>Location Manager
                        </summary>
                        <ul>
                            <li><a href="city_management.php">City Management</a></li>
                            <li><a href="barangay_management.php">Barangay Management</a></li>
                            <li><a href="subdivision_management.php">Subdivision Management</a></li>
                            <li><a href="street_management.php">Street Management</a></li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>

        <?php
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ziondatabase";
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

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
                <h1>Product Management</h1>
                <button class="add-product"><a href="product_add_form.php">ADD PRODUCTS</a></button>
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

                            echo "<td><button class='icon-button delete'><a href='delete_product.php?id=" . $row['product_id'] . "'><i class='material-icons'>delete</i></a></button></td>";
                            echo "<td><button class='icon-button edit'><a href='update_form_products.php?id=" . $row['product_id'] . "'><i class='material-icons'>edit</i></a></button></td>";
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
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <a href="?page=<?= $i ?>" class="<?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>

        </div>

    </div>
</body>

</html>