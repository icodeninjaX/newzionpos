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
    <title>Add products</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
            color: black;
            top: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            z-index: 1000;
            position: fixed;
            width: 100%;
        }

        .logo {
            max-width: 50px;
            /* Adjust this value according to your desired logo size */
            max-height: 50px;
            height: auto;
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

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            font-size: 14px;
        }

        form {
            align-items: center;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 4px;
            display: block;
        }

        input[type="submit"] {
            background-color: #3F51B5;
            border: none;
            color: white;
            text-align: center;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            padding: 8px 16px;
        }

        .material-icons {
            vertical-align: middle;
            color: white;
        }

        .icon-button {
            background-color: #3F51B5;
            padding: 8px;
            font-size: 18px;
        }

        .icon-button:hover {
            background-color: rgba(63, 81, 181, 0.3);
        }

        .settings-container {
            display: flex;
            gap: 16px;
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
                <li><a href="add-test.php">Order Management</a></li>
                <li><a href="customer.php">Registered Customer</a></li>
                <li class="active"><a href="product_management.php">Product Management</a></li>
                <li><a href="registered_branch.php">Registered Branch</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="content-header">
                <h1>Add Products</h1>
            </div>
            <form action="add_products.php" method="post" style="width:60%;">
                <label for="name">Product Name:</label>
                <input type="text" name="name" id="name" placeholder="Name" required autocomplete="off">
                <br>
                <br>
                <label for="description">Product Description:</label>
                <textarea name="description" id="description" placeholder="Description" required></textarea>
                <br>
                <br>
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" placeholder="Price" required autocomplete="off">
                <br>
                <br>
                <label for="brand">Brand:</label>
                <input type="text" name="brand" id="brand" placeholder="Brand" required autocomplete="off">
                <br>
                <br>
                <label for="sku">SKU:</label>
                <input type="number" name="sku" id="sku" placeholder="SKU" required autocomplete="off">
                <br>
                <br>
                <label for="weight">Weight:</label>
                <input type="number" name="weight" id="weight" placeholder="Weight" required autocomplete="off">
                <br>
                <br>
                <input type="submit" value="Add product" id="submit" name="submit">
            </form>
        </div>
    </div>
</body>

</html>