<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>

<?php
require_once 'db_connection.php';

$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

if (isset($_GET['search_query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search_query']);
    $sql = "SELECT *
        FROM customers
        JOIN orders ON customers.id = orders.customer_id
        JOIN order_items ON orders.order_id = order_items.order_id
        JOIN products ON order_items.product_id = products.product_id
        WHERE customers.first_name LIKE '%$search_query%'
        OR customers.last_name LIKE '%$search_query%'
        OR products.product_name LIKE '%$search_query%'
        ORDER BY orders.order_id DESC
        LIMIT $start_from, $limit";


} else {
    $sql = "SELECT *
            FROM customers
            JOIN orders ON customers.id = orders.customer_id
            JOIN order_items ON orders.order_id = order_items.order_id
            JOIN products ON order_items.product_id = products.product_id
            ORDER BY orders.order_id DESC
            LIMIT $start_from, $limit";
}





$result = mysqli_query($conn, $sql);

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <ul>
                <li class="active">
                    <a href="order_management.php" style="font-size: 18px;" class="ordermanagement">
                        <img src="img/inventory-management.png" alt="gas" class="orders">Order Management
                    </a>
                </li>
                <li>
                    <a href="customer.php" style="font-size: 18px;" class="ordermanagement">
                        <img src="img/customer-1.png" alt="gas" class="orders">Registered Customer
                    </a>
                </li>
                <li>
                    <a href="product_management.php" style="font-size: 18px;" class="ordermanagement">
                        <img src="img/gas-2.png" alt="gas" class="orders">Product Management
                    </a>
                </li>
                <li>
                    <a href="registered_branch.php" style="font-size: 18px;" class="ordermanagement">
                        <img src="img/franchise.png" alt="gas" class="orders">Registered Branch
                    </a>
                </li>
                <li>
                    <a href="sales_report.php" style="font-size: 18px;" class="ordermanagement">
                        <img src="img/sales.png" alt="gas" class="orders">Sales Report
                    </a>
                </li>
                <p style="font-size: 10px; text-align: center; font-weight: bold;">Location Management</p>
                <li>
                    <a href="city_management.php" style="font-size: 17px;" class="ordermanagement">
                        <img src="img/location.png" alt="gas" class="orders">City Management
                    </a>
                </li>
                <li>
                    <a href="barangay_management.php" style="font-size: 17px;" class="ordermanagement">
                        <img src="img/location.png" alt="gas" class="orders">Barangay Management
                    </a>
                </li>
                <li>
                    <a href="subdivision_management.php" style="font-size: 16px;" class="ordermanagement">
                        <img src="img/location.png" alt="gas" class="orders">Subdivision Management
                    </a>
                </li>
                <li>
                    <a href="street_management.php" style="font-size: 17px;" class="ordermanagement">
                        <img src="img/location.png" alt="gas" class="orders">Street Management
                    </a>
                </li>
                <br>
                <li>
                    <a href="logout.php" class="ordermanagement log-out" style="font-size: 20px;">
                        <img src="img/logout.png" alt="gas" class="orders">LOG OUT
                    </a>
                </li>
            </ul>
        </div>

        <div class="main-content" width="1000" height="300">
            <div class="content-header">
                <h1
                    style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size: 25px; vertical-align: middle;">
                    <img src="img/order-management1.png" alt="Orders" class="order-img">Order Management
                </h1>
                <form class="search-form" action="order_management.php" method="GET">
                    <input type="text" name="search_query" placeholder="Search for orders" autocomplete="off">
                    <button type="submit"><i class="material-icons search"
                            style="vertical-align: middle;">search</i></button>
                </form>
            </div>

            <table>
                <thead>
                    <th>ORDER ID</th>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Product Details</th>
                    <th>Qty</th>
                    <th>Paid Amount</th>
                    <th>Order Created</th>
                    <th>Status</th>
                    <th colspan="2">Action</th>
                </thead>

                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tbody>
                            <tr style="padding: 0;">
                                <td>
                                    <?php echo $row['order_id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['customer_id']; ?>

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
                                <td>
                                    <form action="update_order_status.php" method="POST">
                                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                        <button type="submit" class="edit-btn">
                                            <i class="material-icons delivered-icon">check_circle</i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="cancel_order.php" method="POST">
                                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                        <button class="delete-btn" type="submit">
                                            <i class="material-icons cancel-icon">cancel_presentation</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
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