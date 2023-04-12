<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>

<?php
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    echo "No record found";
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Products</title>

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
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: rgba(63, 81, 181, 0.1);
        }

        th {
            background-color: #3F51B5;
            color: white;
        }

        .logo {
            max-width: 50px;
            /* Adjust this value according to your desired logo size */
            max-height: 50px;
            /* Adjust this value according to your desired logo size */
            height: auto;
        }

        .material-icons {
            color: white;
        }

        .settings-container {
            display: flex;
            gap: 16px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-around;
        }

        .edit-button,
        .delete-button {
            display: inline-block;
            font-size: 18px;
            color: #3F51B5;
            cursor: pointer;
            transition: color 0.3s;
        }

        button {
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

        button:hover {
            background-color: #5C6BC0;
        }

        .edit-button:hover,
        .delete-button:hover {
            color: rgba(63, 81, 181, 0.8);
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
                <li><a href="order_management.php">Order Management</a></li>
                <li><a href="customer.php">Registered Customer</a></li>
                <li class="active"><a href="product_management.php">Product Management</a></li>
                <li><a href="registered_branch.php">Registered Branch</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="content-header">
                <h1>Update Customer Information</h1>
            </div>

            <form action="update_products.php" method="post" style="width: 60%;">
                <input type="hidden" name="id" value="<?php echo $row['product_id']; ?>"
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">
                <label for="name">Product Name:</label>
                <br>
                <input type="text" name="name" id="name" placeholder="Name" value="<?php echo $row['product_name']; ?>"
                    required style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">
                <br>
                <br>
                <label for="description">Product Description:</label>
                <br>
                <textarea name="description" id="description" placeholder="Description" required rows="6" cols="50"
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;"><?php echo $row['product_description']; ?></textarea>
                <br>
                <br>
                <label for="price">Price:</label>
                <br>
                <input type="number" name="price" id="price" placeholder="Price" value="<?php echo $row['price']; ?>"
                    required style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">
                <br>
                <br>
                <label for="brand">Brand:</label>
                <br>
                <input type="text" name="brand" id="brand" placeholder="Brand" value="<?php echo $row['brand']; ?>"
                    required style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">
                <br>
                <br>
                <label for="sku">SKU:</label>
                <br>
                <input type="number" name="sku" id="sku" placeholder="SKU" value="<?php echo $row['sku']; ?>" required
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">
                <br>
                <br>
                <label for="weight">Weight:</label>
                <br>
                <input type="number" name="weight" id="weight" placeholder="Weight"
                    value="<?php echo $row['weight']; ?>" required
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">
                <br>
                <br>
                <input type="submit" value="Update" id="update_product" name="update_product"
                    style="background-color: #3F51B5; color: white; font-size: 14px; font-weight: 500; padding: 8px; border: none; border-radius: 4px; cursor: pointer;">
            </form>
        </div>
</body>

</html>