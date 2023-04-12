<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>

<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
<html>

<head>
    <title>Registered Customer</title>
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

        .settings-container {
            display: flex;
        }

        .settings-container a {
            color: white;
            text-decoration: none;
            margin-left: 16px;
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
            font-size: 11px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            border-radius: 4px;
            overflow: hidden;
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
            background-color: #3F51B5;
            color: white;
            width: 5%;
        }

        td {
            height: 35px;
        }

        .logo {
            max-width: 50px;
            max-height: 50px;
            height: auto;
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

        .edit-btn,
        .delete-btn {
            text-decoration: none;
            padding: 6px 12px;
            background-color: #3F51B5;
            color: white;
            border-radius: 4px;
            font-size: 12px;
            transition: background-color 0.3s;
        }

        .edit-btn:hover,
        .delete-btn:hover {
            background-color: #283593;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .delete-btn:hover {
            background-color: #c62828;
        }

        .order-icon {
            color: white;
            font-size: 15px;
            margin-right: 5px;
        }

        .edit-icon {
            font-size: 20px;
            vertical-align: middle;
        }

        .address {
            width: 15%;
            font-size: 10px;
        }

        .landmark {
            width: 10%;
        }

        .city {
            width: 8%;
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
                <li class="active"><a href="customer.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">group</i>Registered Customer</a></li>
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
                <h1> Registered Customers </h1>
                <form method="GET" action="" class="search-form">
                    <input type="text" name="search" placeholder="Search customers" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit">Search</button>
                </form>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID No.</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact No.</th>
                        <th>Address</th>
                        <th>Street</th>
                        <th>Subdivision</th>
                        <th>Landmark</th>
                        <th>City</th>
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
                        echo "<td>" . $customer["first_name"] . "</td>";
                        echo "<td>" . $customer["last_name"] . "</td>";
                        echo "<td>" . $customer["tel_num"] . "</td>";
                        echo "<td class='address'>" . $customer["cus_address"] . "</td>";
                        echo "<td>" . $customer["street"] . "</td>";
                        echo "<td class='subdivision'>" . $customer["subdivision"] . "</td>";
                        echo "<td class='landmark'>" . $customer["landmark"] . "</td>";
                        echo "<td class='city'>" . $customer["city"] . "</td>";
                        echo "<td>" . $customer["tanktype"] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_customer.php?id=" . $customer["id"] . "' class='edit-btn'><i class='material-icons edit-icon'>edit</i></a>";
                        echo "</td>";
                        echo "<td>";
                        echo "<a href='delete_customer_action.php?id=" . $customer["id"] . "' class='delete-btn' onclick='deleteMessageDisplay()'><i class='material-icons edit-icon'>delete</i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
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