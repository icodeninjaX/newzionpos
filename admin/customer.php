<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>

<?php
// Connect to the database
require_once 'db_connection.php';

// Define the number of records per page
$records_per_page = 10;

// Get the current page number from the URL or set a default value
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

// Get the search query from the URL or set a default value
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Calculate the total number of pages based on the number of records and the number of records per page
$total_records_query = "SELECT COUNT(*) FROM customers" . (!empty($search_query) ? " WHERE first_name LIKE ? OR last_name LIKE ?" : "");
$stmt = mysqli_prepare($conn, $total_records_query);
if (!empty($search_query)) {
    $search_param = '%' . $search_query . '%';
    mysqli_stmt_bind_param($stmt, 'ss', $search_param, $search_param);
}
mysqli_stmt_execute($stmt);
$total_records_result = mysqli_stmt_get_result($stmt);
$total_records = mysqli_fetch_array($total_records_result)[0];
$total_pages = ceil($total_records / $records_per_page);

// Modify the SQL query to fetch only the records for the current page and apply the search query
$sql = "SELECT * FROM customers" . (!empty($search_query) ? " WHERE first_name LIKE ? OR last_name LIKE ? OR tel_num LIKE ?" : "") . " LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conn, $sql);
if (!empty($search_query)) {
    $offset = ($current_page - 1) * $records_per_page;
    mysqli_stmt_bind_param($stmt, 'ssssi', $search_param, $search_param, $search_param, $records_per_page, $offset);
} else {
    $offset = ($current_page - 1) * $records_per_page;
    mysqli_stmt_bind_param($stmt, 'ii', $records_per_page, $offset);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if the query returned any results
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<?php
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $message = "Are you sure you want to delete?";
    $confirm = "<script>if(confirm('$message')){document.location='delete_customer.php?id=$id';}</script>";
    echo $confirm;
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Customer</title>
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
                <li class="active"><a href="customer.php" style="font-size: 18px;" class="ordermanagement"><img
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
                    style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size: 25px; vertical-align: middle;">
                    <img src="img/registered-customer.png" alt="Orders" class="order-img">Registered Customers</h1>
                <form method="GET" action="" class="search-form">
                    <input type="text" name="search" autocomplete="off" placeholder="Enter name or contact num"
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit"><i class="material-icons search">search</i></button>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID No.</th>
                        <th>Customer Name</th>
                        <th>Contact No.</th>
                        <th>Complete Address</th>
                        <th>Landmark</th>
                        <th>Tank type</th>

                        <th colspan="2" style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through each row in the customers table and output the data in a table row
                    while ($customer = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td class='id'>" . $customer["id"] . "</td>";
                        echo "<td class='fullname'>" . $customer["first_name"] . " " . $customer["last_name"] . "</td>";
                        echo "<td>" . $customer["tel_num"] . "</td>";
                        echo "<td class='address'>" . $customer["cus_address"] . " " . $customer["street"] . " " . $customer["subdivision"] . " " . $customer["barangay"] . " " . $customer["city"] . "</td>";
                        echo "<td class='landmark'>" . $customer["landmark"] . "</td>";
                        echo "<td>" . $customer["tanktype"] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_customer.php?id=" . $customer["id"] . "' class='edit-btn'><i class='material-icons edit-icon'>edit</i></a>";
                        echo "</td>";
                        echo "<td>";
                        echo "<a href='delete_customer_action.php?id=" . $customer["id"] . "' class='delete-btn' onclick='deleteMessageDisplay()'><i class='material-icons delete-icon'>delete</i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                    <a href="?page=<?php echo $page; ?>" <?php echo ($page == $current_page ? 'class="active"' : ''); ?>><?php echo $page; ?></a>
                <?php endfor; ?>
            </div>

        </div>
    </div>

    <script>
        function deleteMessageDisplay() {
            alert("Customer Deleted Succesfully!");
        }
    </script>
</body>

</html>