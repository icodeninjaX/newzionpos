<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>


<?php
require_once 'db_connection.php';

// Fetch cities
$sql_cities = "SELECT * FROM cities";
$result_cities = mysqli_query($conn, $sql_cities);

// Fetch barangays
$sql_barangays = "SELECT barangays.*, cities.city_name FROM barangays JOIN cities ON barangays.city_id = cities.id";
$result_barangays = mysqli_query($conn, $sql_barangays);

// Fetch subdivisions
$sql_subdivisions = "SELECT subdivisions.*, barangays.barangay_name FROM subdivisions JOIN barangays ON subdivisions.barangay_id = barangays.id";
$result_subdivisions = mysqli_query($conn, $sql_subdivisions);
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
            <ul>
                <li class="active"><a href="order_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">assignment</i>Order
                        Management</a></li>
                <li><a href="customer.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">group</i>Registered Customer</a></li>
                <li><a href="product_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">list</i>Product Management</a></li>
                <li><a href="registered_branch.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">store</i>Registered Branch</a></li>
                <li><a href="sales_report.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">bar_chart</i>Sales Report</a></li>
                <li><a href="city_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">location_city</i>City Management</a></li>
                <li><a href="barangay_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">location_on</i>Barangay Management</a></li>
                <li><a href="subdivision_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">location_searching</i>Subdivision Management</a></li>

            </ul>
        </div>

        <div class="main-content">
            <div class="content-header">
                <h1> Location Management </h1>
            </div>

            <!-- Cities table -->
            <h2>Cities</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>City Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_cities)) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['city_name']; ?></td>
                            <td>
                                <!-- Add action buttons here -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Barangays table -->
            <h2>Barangays</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Barangay Name</th>
                        <th>City Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_barangays)) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['barangay_name']; ?></td>
                            <td><?php echo $row['city_name']; ?></td>
                            <td>
                                <!-- Add action buttons here -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Subdivisions table -->
            <h2>Subdivisions</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Subdivision Name</th>
                        <th>Barangay Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_subdivisions)) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['subdivision_name']; ?></td>
                            <td><?php echo $row['barangay_name']; ?></td>
                            <td>
                                <!-- Add action buttons here -->
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>


    </div>
    </div>
    </div>
</body>

</html>