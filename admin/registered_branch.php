<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>

<?php
// Database connection
require_once 'db_connection.php';

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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Branches</title>
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
                <li><a href="customer.php" style="font-size: 18px;" class="ordermanagement"><img
                            src="img/customer-1.png" alt="gas" class="orders">Registered Customer</a></li>
                <li><a href="product_management.php" style="font-size: 18px;" class="ordermanagement"><img
                            src="img/gas-2.png" alt="gas" class="orders">Product Management</a></li>
                <li class="active"><a href="registered_branch.php" style="font-size: 18px;" class="ordermanagement"><img
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
                    <img src="img/registered-branch.png" alt="Orders" class="order-img">Registered Branches
                </h1>
                <button class="add-product" onclick="window.location.href='add_branch.php'"
                    style="font-weight: bold;"><i class="material-icons order-icon"
                        style="vertical-align: text-top; font-size: 20px; font-weight: bold;">add</i>ADD NEW
                    BRANCH</button>

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
                                <button class="edit-btn"><i class="material-icons"
                                        onclick="window.location.href='edit_branch.php?id=<?php echo $row['id']; ?>'">edit</i></button>
                            </td>
                            <td>
                                <button class="delete-btn"><i class="material-icons delete"
                                        onclick="window.location.href='delete_branch.php?id=<?php echo $row['id']; ?>'">delete</i></button>
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