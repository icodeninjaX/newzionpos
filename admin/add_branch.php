<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Branch</title>
    <!-- Add the same CSS and styles as in the Registered Branch page -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dongle:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<div id="header-container" style="position: fix;">
    <a href="main_dashboard.php"><img src="img/background-removebg-preview.png" alt="" class="logo"></a>
    <div class="settings-container">
        <a href="#"><i class="material-icons top-icons">settings</i></a>
        <a href="#"><i class="material-icons top-icons">person</i></a>
        <a href="#"><i class="material-icons top-icons">admin_panel_settings</i></a>
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
            <h1> Add Branch </h1>
        </div>

        <form action="add_branch_action.php" method="POST" style="width: 60%;">
            <div style="margin-bottom: 16px;">
                <label for="branch_name">Branch Name:</label><br>
                <input type="text" name="branch_name" required style="width: 100%; padding: 8px; margin-top: 4px; font-size: 14px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label for="contact_number">Contact Number:</label><br>
                <input type="text" name="contact_number" required style="width: 100%; padding: 8px; margin-top: 4px; font-size: 14px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label for="address">Address:</label><br>
                <input type="text" name="address" required style="width: 100%; padding: 8px; margin-top: 4px; font-size: 14px;">
            </div>
            <button type="submit" style="background-color: #3F51B5; color: white; font-size: 14px; font-weight: 500; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; outline: none; transition: background-color 0.3s;">Add
                Branch</button>
        </form>
    </div>
</div>
</body>

</html>