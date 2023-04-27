<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>

<?php
// Database connection and fetch branch data
require_once 'db_connection.php';

$id = intval($_GET['id']);
$sql = "SELECT * FROM branches WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Branch</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dongle:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <div id="header-container">
        <a href="main_dashboard.php"><img src="img/background.jpg" alt="" class="logo"></a>
        <div class="settings-container">
            <a href="#"><i class="material-icons">settings</i></a>
            <a href="#"><i class="material-icons">person</i></a>
            <a href="#"><i class="material-icons">admin_panel_settings</i></a>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <ul>
                <!-- Your existing menu items -->
                <li><a href="order_management.php" style="font-size: 18px;" class="ordermanagement"><img src="img/inventory-management.png" alt="gas" class="orders">Order Management</a></li>
                <li><a href="customer.php" style="font-size: 18px;" class="ordermanagement"><img src="img/customer-1.png" alt="gas" class="orders">Registered Customer</a></li>
                <li><a href="product_management.php" style="font-size: 18px;" class="ordermanagement"><img src="img/gas-2.png" alt="gas" class="orders">Product Management</a></li>
                <li><a href="registered_branch.php" style="font-size: 18px;" class="ordermanagement"><img src="img/franchise.png" alt="gas" class="orders">Registered Branch</a></li>
                <li><a href="sales_report.php" style="font-size: 18px;" class="ordermanagement"><img src="img/sales.png" alt="gas" class="orders">Sales Report</a></li>
                <p style="font-size: 10px; text-align: center; font-weight: bold;">Location Management</p>
                <li><a href="city_management.php" style="font-size: 17px;" class="ordermanagement"><img src="img/location.png" alt="gas" class="orders">City Management</a></li>
                <li><a href="barangay_management.php" style="font-size: 17px;" class="ordermanagement"><img src="img/location.png" alt="gas" class="orders">Barangay Management</a></li>
                <li><a href="subdivision_management.php" style="font-size: 16px;" class="ordermanagement"><img src="img/location.png" alt="gas" class="orders">Subdivision Management</a></li>
                <li><a href="street_management.php" style="font-size: 17px;" class="ordermanagement"><img src="img/location.png" alt="gas" class="orders">Street Management</a></li>
                <br>
                <li><a href="logout.php" class="ordermanagement log-out" style="font-size: 20px;"><img src="img/logout.png" alt="gas" class="orders">LOG OUT</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="content-header">
                <h1> Edit Branch </h1>
            </div>

            <form action="edit_branch_action.php" method="POST" style="width: 60%;">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div style="margin-bottom: 16px;">
                    <label for="branch_name">Branch Name:</label><br>
                    <input type="text" name="branch_name" value="<?php echo $row['branch_name']; ?>" required style="width: 100%; padding: 8px; margin-top: 4px; font-size: 14px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label for="contact_number">Contact Number:</label><br>
                    <input type="text" name="contact_number" value="<?php echo $row['contact_number']; ?>" required style="width: 100%; padding: 8px; margin-top: 4px; font-size: 14px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label for="address">Address:</label><br>
                    <input type="text" name="address" value="<?php echo $row['address']; ?>" required style="width: 100%; padding: 8px; margin-top: 4px; font-size: 14px;">
                </div>
                <button type="submit" style="background-color: #3F51B5; color: white; font-size: 14px; font-weight: 500; padding: 8px 16px; border: none; cursor: pointer;">Update
                    Branch</button>
            </form>
        </div>

    </div>
</body>

</html>
<?php
mysqli_close($conn);
?>