<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>

<?php
// Connect to the database
require_once 'db_connection.php';

// Get the customer ID from the URL
$customer_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch customer data
$sql = "SELECT * FROM customers WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $customer_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$customer = mysqli_fetch_assoc($result);



if (!$customer) {
    die("Customer not found");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $last_name = trim($_POST['last_name']);
    $tel_num = trim($_POST['tel_num']);
    $cus_address = trim($_POST['cus_address']);
    $street = trim($_POST['street']);
    $subdivision = trim($_POST['subdivision']);
    $landmark = trim($_POST['landmark']);
    $city = trim($_POST['city']);
    $tanktype = trim($_POST['tanktype']);
    $barangay = trim($_POST['barangay']);

    // Validate and sanitize the input data
    $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
    $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
    $tel_num = filter_var($tel_num, FILTER_SANITIZE_STRING);
    $cus_address = filter_var($cus_address, FILTER_SANITIZE_STRING);
    $street = filter_var($street, FILTER_SANITIZE_STRING);
    $subdivision = filter_var($subdivision, FILTER_SANITIZE_STRING);
    $landmark = filter_var($landmark, FILTER_SANITIZE_STRING);
    $city = filter_var($city, FILTER_SANITIZE_STRING);
    $barangay = filter_var($barangay, FILTER_SANITIZE_STRING);

    // Update the customer record in the database
    $sql = "UPDATE customers SET first_name = ?, last_name = ?, tel_num =?, cus_address = ?, street = ?, subdivision = ?, landmark = ?, city = ?, barangay = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssssssi', $first_name, $last_name, $tel_num, $cus_address, $street, $subdivision, $landmark, $city, $customer_id, $barangay);
    mysqli_stmt_execute($stmt);


    // Redirect to the registered customers page after successful update
    header("Location: customer.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <!-- Add your CSS and other head elements here -->
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

        .form-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: wheat;
            border: 2px solid lightcoral;
            border-radius: 10px;
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
                <h1>Edit Customer</h1>
            </div>
            <div class="form-container">
                <form method="POST" action="edit_customer.php?id=<?php echo $customer_id; ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($customer['first_name']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($customer['last_name']); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tel_num">Contact Number:</label>
                            <input type="text" id="tel_num" name="tel_num" value="<?php echo htmlspecialchars($customer['tel_num']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="cus_address">House #</label>
                            <input type="text" id="cus_address" name="cus_address" value="<?php echo htmlspecialchars($customer['cus_address']); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="street">Street:</label>
                            <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($customer['street']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="subdivision">Subdivision:</label>
                            <input type="text" id="subdivision" name="subdivision" value="<?php echo htmlspecialchars($customer['subdivision']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="barangay">Barangay</label>
                            <input type="text" id="barangay" name="barangay" value="<?php echo htmlspecialchars($customer['barangay']); ?>">
                        </div>
                    </div>
                    <div class="form-row">

                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($customer['city']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="landmark">Landmark:</label>
                            <input type="text" id="landmark" name="landmark" value="<?php echo htmlspecialchars($customer['landmark']); ?>">
                        </div>


                    </div>


                    <div class="form-row">
                        <div class="form-group">
                            <input type="submit" value="Save Changes" onclick="displayMessage()">
                        </div>
                    </div>
                </form>
            </div>

            <script>
                function displayMessage() {
                    alert("Customer Edited Successfully");
                }
            </script>
</body>

</html>