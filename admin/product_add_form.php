<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
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

    <style>
        body {
            font-family: Arial, sans-serif;
        }

       

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .form-group {
            flex: 1;
            padding: 0 10px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: black;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #3F51B5;
            color: white;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 20px;
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
                <h1>Add Products</h1>
            </div>
            <form action="add_products.php" method="post" class="form-container">
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" name="name" id="name" placeholder="Name" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="description">Product Description:</label>
                    <textarea name="description" id="description" placeholder="Description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" placeholder="Price" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="brand">Brand:</label>
                    <input type="text" name="brand" id="brand" placeholder="Brand" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="sku">SKU:</label>
                    <input type="number" name="sku" id="sku" placeholder="SKU" required autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="weight">Weight:</label>
                    <input type="number" name="weight" id="weight" placeholder="Weight" required autocomplete="off">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="submit" value="Add product" id="submit" name="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>