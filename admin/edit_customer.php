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

    // Validate and sanitize the input data
    $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
    $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
    $tel_num = filter_var($tel_num, FILTER_SANITIZE_STRING);
    $cus_address = filter_var($cus_address, FILTER_SANITIZE_STRING);
    $street = filter_var($street, FILTER_SANITIZE_STRING);
    $subdivision = filter_var($subdivision, FILTER_SANITIZE_STRING);
    $landmark = filter_var($landmark, FILTER_SANITIZE_STRING);
    $city = filter_var($city, FILTER_SANITIZE_STRING);

    // Update the customer record in the database
    $sql = "UPDATE customers SET first_name = ?, last_name = ?, tel_num =?, cus_address = ?, street = ?, subdivision = ?, landmark = ?, city = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssi', $first_name, $last_name, $tel_num, $cus_address, $street, $subdivision, $landmark, $city, $customer_id);
    mysqli_stmt_execute($stmt);


    // Redirect to the registered customers page after successful update
    header("Location: customer.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Customer</title>
    <!-- Add your CSS and other head elements here -->
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
                <li class="active"><a href="customer.php">Registered Customer</a></li>
                <li><a href="product_management.php">Product Management</a></li>
                <li><a href="registered_branch.php">Registered Branch</a></li>
            </ul>
        </div>


        <div class="main-content">
            <div class="content-header">
                <h1>Edit Customer</h1>
            </div>

            <form method="POST" action="edit_customer.php?id=<?php echo $customer_id; ?>" style="width: 60%;">

                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name"
                    value="<?php echo htmlspecialchars($customer['first_name']); ?>"
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name"
                    value="<?php echo htmlspecialchars($customer['last_name']); ?>"
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">

                <label for="last_name">Contact Number:</label>
                <input type="text" id="tel_num" name="tel_num"
                    value="<?php echo htmlspecialchars($customer['tel_num']); ?>"
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">

                <label for="cus_address">Address:</label>
                <input type="text" id="cus_address" name="cus_address"
                    value="<?php echo htmlspecialchars($customer['cus_address']); ?>"
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">

                <label for="street">Street:</label>
                <input type="text" id="street" name="street"
                    value="<?php echo htmlspecialchars($customer['street']); ?>"
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">

                <label for="subdivision">Subdivision:</label>
                <input type="text" id="subdivision" name="subdivision"
                    value="<?php echo htmlspecialchars($customer['subdivision']); ?>"
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">

                <label for="landmark">Landmark:</label>
                <input type="text" id="landmark" name="landmark"
                    value="<?php echo htmlspecialchars($customer['landmark']); ?>"
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">

                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($customer['city']); ?>"
                    style="width: 100%; padding: 8px; margin-top: 7px; margin-bottom: 3px; font-size: 14px;">
                <br>
                <br>
                <input type="submit" value="Save Changes"
                    style="background-color: #3F51B5; color: white; font-size: 14px; font-weight: 500; padding: 8px; border: none; cursor: pointer; border-radius: 4px;"
                    onclick="displayMessage()">
            </form>


        </div>

        <script>
            function displayMessage() {
                alert("Customer Edited Succesfully");
            }
        </script>
</body>

</html>