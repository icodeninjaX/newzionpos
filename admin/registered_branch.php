<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>

<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch branches
$sql = "SELECT * FROM branches";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registered Branch</title>
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
            padding: 16px;
            align-items: center;
            background-color: #3F51B5;
            color: black;
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
        }

        tr:hover {
            background-color: rgba(63, 81, 181, 0.1);
        }

        th {
            background-color: #3F51B5;
            color: white;
            font-size: 12px;
        }

        td {
            font-size: 12px;
        }

        .logo {
            max-width: 50px;
            max-height: 50px;
            height: auto;
            border-radius: 22px;
        }

        .material-icons {
            vertical-align: middle;
            color: white;
        }

        .settings-container {
            display: flex;
        }

        .settings-container a {
            color: white;
            text-decoration: none;
            margin-left: 16px;
        }


        .add-button {
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

        .add-button:hover {
            background-color: #5C6BC0;
        }

        .order-icon {
            color: white;
            font-size: 15px;
            margin-right: 5px;
        }

        .delete {
            background-color: #f44336;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            padding: 4px;
        }

        .delete:hover {
            background-color: #e53935;
        }

        .edit {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 4px;
        }

        .edit:hover {
            background-color: #43A047;
        }

        .delete-button {
            border: none;
        }

        .address {
            width: 40%;
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
                <li><a href="product_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">list</i>Product Management</a></li>
                <li class="active"><a href="registered_branch.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">store</i>Registered Branch</a></li>
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
                <h1>Registered Branch</h1>
                <button class="add-button" onclick="window.location.href='add_branch.php'">ADD NEW BRANCH</button>

            </div>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Branch Name</th>
                    <th>Contact Number</th>
                    <th class="address">Address</th>
                    <th colspan="2" style="text-align: center;">Action</th>
                </tr>
                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td>
                                <?php echo $row['id']; ?>
                            </td>
                            <td>
                                <?php echo $row['branch_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['contact_number']; ?>
                            </td>
                            <td>
                                <?php echo $row['address']; ?>
                            </td>
                            <td>
                                <button class="delete-button"><i class="material-icons delete" onclick="window.location.href='delete_branch.php?id=<?php echo $row['id']; ?>'">delete</i></button>
                            </td>
                            <td>
                                <button class="delete-button"><i class="material-icons edit" onclick="window.location.href='edit_branch.php?id=<?php echo $row['id']; ?>'">edit</i></button>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <p>No branches found</p>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>