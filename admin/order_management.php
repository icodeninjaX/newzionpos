<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>


<?php
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set limit and current page
$limit = 10;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $limit;

// Check if search query was submitted
if (isset($_GET['search_query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search_query']);
    $sql = "SELECT customers.*, orders.*, order_items.quantity, order_items.price as paid_amount, products.product_name
          FROM customers
          JOIN orders ON customers.id = orders.customer_id
          JOIN order_items ON orders.order_id = order_items.order_id
          JOIN products ON order_items.product_id = products.product_id
          WHERE customers.first_name LIKE '%$search_query%'
          OR customers.last_name LIKE '%$search_query%'
          OR products.product_name LIKE '%$search_query%'
          ORDER BY orders.order_created DESC LIMIT $start_from, $limit";
} else {
    $sql = "SELECT customers.*, orders.*, order_items.quantity, order_items.price as paid_amount, products.product_name
          FROM customers
          JOIN orders ON customers.id = orders.customer_id
          JOIN order_items ON orders.order_id = order_items.order_id
          JOIN products ON order_items.product_id = products.product_id
          ORDER BY orders.order_created DESC LIMIT $start_from, $limit";
}


$result = mysqli_query($conn, $sql);

// Calculate total pages
$sql_total = "SELECT COUNT(*) as total_records FROM orders";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_records = $row_total['total_records'];
$total_pages = ceil($total_records / $limit);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Order Management</title>
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
            text-align: center;
            padding: 5px;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #ddd;
        }

        table tbody td {
            padding: 2px;
            border-bottom: 1px solid #ddd;
        }

        .tablehead {
            border-radius: 4px;
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
            padding: 10px;
            font-size: 12px;
            flex-grow: 1;
        }

        .search-form button {
            background-color: #3F51B5;
            color: white;
            font-size: 12px;
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
            font-size: 12px;
        }

        td {
            padding: 5px;
            text-align: center;
            font-size: 12px;
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

        .order-icon {
            color: white;
            font-size: 15px;
            margin-right: 5px;
        }

        .search-icon {
            font-size: 20px;
        }

        .delivered-icon {
            background-color: #3F51B5;
            font-size: 15px;
        }

        .cancel-icon {
            font-size: 15px;
        }

        .material-icons{
            vertical-align: text-top;
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
                <li class="active"><a href="order_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">assignment</i>Order Management</a></li>
                <li><a href="customer.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">group</i>Registered Customer</a></li>
                <li><a href="product_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">list</i>Product Management</a></li>
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

        <div class="main-content">
            <div class="content-header">
                <h1> Order Management </h1>
                <form class="search-form" action="order_management.php" method="GET">
                    <input type="text" name="search_query" placeholder="Search for orders" autocomplete="off">
                    <button type="submit"><i class="material-icons search-icon" style="vertical-align: middle;">search</i>Search</button>
                </form>
            </div>

            <table>


                <th>ORDER ID</th>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Product Details</th>
                <th>Qty</th>
                <th>Paid Amount</th>
                <th>Order Created</th>
                <th>Status</th>
                <th colspan="2">Action</th>



                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="table-row">
                            <td>
                                <?php echo $row['order_id']; ?>
                            </td>
                            <td>
                                <?php echo $row['id']; ?>
                            </td>
                            <td>
                                <?php echo $row['first_name'] . " " . $row['last_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['product_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['quantity']; ?>
                            </td>
                            <td>
                                <?php echo $row['total_price']; ?>
                            </td>
                            <td>
                                <?php echo $row['order_created']; ?>
                            </td>
                            <td>
                                <?php echo $row['status']; ?>
                            </td>
                            <!-- <td>
                                <form action="delete_order.php" method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                    <button class="delete-button" type="submit">Delete</button>
                                </form>
                            </td> -->
                            <td>
                                <form action="update_order_status.php" method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                    <button type="submit"><i class="material-icons delivered-icon">check_circle</i></button>
                                </form>
                            </td>

                            <td>
                                <form action="cancel_order.php" method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                    <button class="cancel-button" type="submit"><i class="material-icons cancel-icon">cancel_presentation</i></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>

                <?php } else { ?>
                    <p>No data found</p>
                <?php } ?>

            </table>

            <div class="pagination">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo "<a href='order_management.php?page=" . $i . "' class='active'>" . $i . "</a> ";
                    } else {
                        echo "<a href='order_management.php?page=" . $i . "'>" . $i . "</a> ";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    </div>
</body>

</html>