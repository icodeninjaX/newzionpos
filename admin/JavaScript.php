<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>


<?php
require_once 'db_connection.php';

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
            background-color: dodgerblue;
        }

        #header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: wheat;
            padding: 14px;
            color: white;
            border: 3px solid lightcoral;
            position: fixed;
            top: 10px;
            width: 1250px;
            z-index: 1000;
            margin-left: 10px;
            border-radius: 5px;

        }

        .container {
            display: flex;
        }

        .sidebar {
            height: 80vh;
            width: 200px;
            padding: 16px;
            position: fixed;
            border: 3px solid lightcoral;
            background-color: wheat;
            margin-left: 10px;
            border-radius: 5px;
            top: 100px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .settings-container {
            display: inline-block;
        }

        .settings-container a {
            color: #333333;
            text-decoration: none;
            margin-left: 16px;
        }

        .sidebar li a {
            display: block;
            text-decoration: none;
            color: white;
            padding: 10px;
            border-radius: 20px;
            margin-bottom: 6px;
            transition: background-color 0.1s;
            font-weight: 500;
        }

        .sidebar li a:hover {
            background-color: lightgreen;
            color: black;
            font-weight: bold;
        }

        .sidebar li a:hover i {
            background-color: lightgreen;
            color: black;
            font-weight: bold;
        }

        .sidebar li a.log-out:hover {
            background-color: red;
            color: white;
            font-weight: bold;
        }

        .sidebar li a.log-out:hover i {
            background-color: red;
            color: white;
            font-weight: bold;
            transition: background-color 0.1s;
        }


        .sidebar li.active a {
            background-color: lightgreen;
            color: black;
            font-weight: 700;
        }

        .sidebar li.active i {
            background-color: lightgreen;
            color: black;
            font-weight: 700;
        }

        .main-content {
            flex-grow: 1;
            padding: 10px;
            margin-left: 218px;
            margin-right: 20px;
            margin-top: 100px;
            height: 482px;
            width: 100%;
            border: 3px solid lightcoral;
            border-radius: 8px;
            background-color: wheat;
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
            font-size: 11px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            border-radius: 4px;
            overflow: hidden;
            background-color: white;
        }

        th,
        td {
            text-align: center;
            border-bottom: 1px solid #ddd;

        }

        tr:hover {
            background-color: rgba(63, 81, 181, 0.1);
            cursor: pointer;
        }

        th {
            font-size: 12px;
            background-color: #1E90FF;
            color: white;
            width: 5%;
        }

        td {
            height: 35px;
            font-weight: bold;
        }

        .logo {
            max-width: 50px;
            max-height: 100px;
        }

        .material-icons {
            color: white;
        }


        .pagination {
            display: flex;
            justify-content: center;
            margin-bottom: 16px;
        }

        .pagination a {
            text-decoration: none;
            color: #3F51B5;
            padding: 8px 12px;
            margin-right: 4px;
            border: 1px solid #3F51B5;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: rgba(63, 81, 181, 0.1);
        }

        .pagination a.active {
            background-color: #3F51B5;
            color: white;
        }

        .search-form {
            display: flex;
            align-items: center;
            border-radius: 10px;
            width: 250px;
            padding: 0;
        }

        .search-form input[type="text"] {
            border: none;
            outline: none;
            padding: 8px;
            font-size: 14px;
            flex-grow: 1;
            border-radius: 15px;
            margin-right: 4px;
        }

        .search-form input[type="text"]:focus {
            border: 2px solid #1E90FF;
        }


        .search-form button {
            background-color: wheat;
            color: white;
            font-size: 14px;
            font-weight: 500;
            padding-top: 2px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            outline: none;
            transition: background-color 0.3s;
        }

        .search-form button:hover {
            background-color: lightgreen;
        }

        .search-form input::placeholder {
            color: gray;
            font-style: italic;
        }

        .search-form button:hover i {
            color: black;
        }

        .edit-btn,
        .delete-btn {
            text-decoration: none;
            padding: 6px 12px;
            background-color: dod;
            color: white;
            border-radius: 4px;
            font-size: 12px;
            transition: background-color 0.3s;
        }


        .edit-btn {
            background-color: dodgerblue;
            color: white;
        }

        .edit-btn i {
            color: white;
        }

        .edit-btn:hover {
            background-color: green;
            color: white;
        }

        .delete-btn:hover {
            background-color: darkred;
            color: white;
        }

        .delete-btn:hover i {
            color: white;

        }


        .delete-btn {
            background-color: red;
        }

        .order-icon {
            color: white;
            font-size: 15px;
            margin-right: 5px;
        }

        .edit-icon {
            font-size: 20px;
            vertical-align: middle;
            color: black;
        }

        .delete-icon {
            font-size: 20px;
            vertical-align: middle;
            color: white;
        }

        summary {
            color: #333333;
            margin-bottom: 10px;
        }

        .ordermanagement {
            background-color: #1E90FF;
            color: white;
        }

        .reg-cus {
            vertical-align: text-top;
            color: dodgerblue;
            font-size: 30px;
        }

        .top-icons {
            color: dodgerblue;
            font-size: 20px;
            margin-right: 5px;
        }

        .log-out {
            background-color: tomato;
        }

        .address {
            width: 20%;
        }

        .fullname {
            width: 10%;
        }

        .id {
            width: 5%;
        }

        .search {
            font-size: 25px;
            color: dodgerblue;
        }
    </style>


</head>

<body>
    <div id="header-container">
        <a href="main_dashboard.php"><img src="img/background-removebg-preview.png" alt="" class="logo"></a>
        <div class="settings-container">
            <a href="#"><i class="material-icons top-icons">settings</i></a>
            <a href="#"><i class="material-icons top-icons">person</i></a>
            <a href="#"><i class="material-icons top-icons">admin_panel_settings</i></a>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <!-- Add your existing sidebar content here -->
            <ul>
                <!-- Your existing menu items -->
                <li class="active"><a href="order_management.php" style="font-size: 12px;" class="ordermanagement"><i
                            class="material-icons order-icon" style="vertical-align: middle;">assignment</i>Order
                        Management</a></li>
                <li><a href="customer.php" style="font-size: 12px;" class="ordermanagement"><i
                            class="material-icons order-icon" style="vertical-align: middle;">group</i>Registered
                        Customer</a></li>
                <li><a href="product_management.php" style="font-size: 12px;" class="ordermanagement"><i
                            class="material-icons order-icon" style="vertical-align: middle;">list</i>Product
                        Management</a></li>
                <li><a href="registered_branch.php" style="font-size: 12px;" class="ordermanagement"><i
                            class="material-icons order-icon" style="vertical-align: middle;">store</i>Registered
                        Branch</a></li>
                <li><a href="sales_report.php" style="font-size: 12px;" class="ordermanagement"><i
                            class="material-icons order-icon" style="vertical-align: middle;">bar_chart</i>Sales
                        Report</a></li>
                <p style="font-size: 10px; text-align: center; font-weight: bold;">Location Management</p>
                <li><a href="city_management.php" style="font-size: 10px;" class="ordermanagement"><i
                            class="material-icons order-icon" style="vertical-align: middle;">add</i>City Management</a>
                </li>
                <li><a href="barangay_management.php" style="font-size: 10px;" class="ordermanagement"><i
                            class="material-icons order-icon" style="vertical-align: middle;">add</i>Barangay
                        Management</a></li>
                <li><a href="subdivision_management.php" style="font-size: 10px;" class="ordermanagement"><i
                            class="material-icons order-icon" style="vertical-align: middle;">add</i>Subdivision
                        Management</a></li>
                <li><a href="street_management.php" style="font-size: 10px;" class="ordermanagement"><i
                            class="material-icons order-icon" style="vertical-align: middle;">add</i>Street
                        Management</a></li>
                <br>

                <li><a href="logout.php" class="ordermanagement log-out" style="font-size: 12px;"><i
                            class="material-icons order-icon" style="vertical-align: text-top;">logout</i>LOG OUT</a>
                </li>


            </ul>
        </div>

        <div class="main-content">
            <div class="content-header">
                <h1 style="font-size: 25px; vertical-align: middle;"><i class="material-icons reg-cus"
                        style="vertical-align: text-top; padding-right: 5px;">assignment</i>Order Management</h1>
                <form class="search-form" action="order_management.php" method="GET">
                    <input type="text" name="search_query" placeholder="Search for orders" autocomplete="off">
                    <button type="submit"><i class="material-icons search"
                            style="vertical-align: middle;">search</i></button>
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
                                    <button class="cancel-button" type="submit"><i
                                            class="material-icons cancel-icon">cancel_presentation</i></button>
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