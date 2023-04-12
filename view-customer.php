<?php
require_once 'auth_check.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            padding: 0.5rem 1rem;
        }

        .navbar .nav-item .nav-link {
            color: #000;
        }

        .navbar .nav-item .nav-link:hover {
            color: #007bff;
        }

        .container {
            max-width: 100%;
            display: flex;
            margin-bottom: 50px;
        }

        .profile-section {
            text-align: right;
            margin-bottom: 1rem;
        }

        .profile-section a {
            color: #007bff;
        }

        .profile-section a:hover {
            text-decoration: underline;
        }

        .customer-details {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            width: 50%;
            margin-right: 10px;
        }

        .customer-details h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #ced4da;
            padding-bottom: 0.5rem;
        }

        .customer-details p {
            font-size: 13px;
            margin-bottom: 0.25rem;
            font-weight: bold;
        }

        .add-button-form {
            text-align: center;
            margin: 0 auto;

        }

        .add-button-form input[type="submit"] {
            border: 1px solid black;
            height: 50px;
            width: 120px;
            font-size: 13px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
        }

        .add-button-form input[type="submit"]:hover {
            background-color: lightgray;
            color: black;

        }

        .previous-orders {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            width: 50%;
        }

        .previous-orders h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #ced4da;
            padding-bottom: 0.5rem;
        }

        .table-responsive {
            display: table;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;

        }


        .table-responsive>.table {
            margin-bottom: 0;

        }

        table th {
            font-size: 8.6px;
            padding: 3px;
            white-space: nowrap;
            text-align: center;
            border-bottom: 1px solid #ced4da;
        }

        table td {
            font-size: 8.6px;
            white-space: nowrap;
            text-align: center;
            border-bottom: 1px solid #ced4da;
            font-weight: bold;
        }


        tr:hover {
            background-color: #ced4da;
            cursor: pointer;
        }

        table {
            border: 1px solid #ced4da;
            border-collapse: collapse;
            height: 80%;
        }

        .material-icons {
            margin-right: 4px;
            vertical-align: middle;
            font-size: 25px;
        }

        main {
            width: 80%;
            display: flex;
            margin: 0 auto;
        }

        .alert {
            width: 80%;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">New Zion POS</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search-customer.php">Search</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php

    if (isset($_SESSION['order_success'])) {
        echo "<div class='alert alert-success'>" . $_SESSION['order_success'] . "</div>";
        unset($_SESSION['order_success']);
    }

    if (isset($_GET['id'])) {
        $customer_id = $_GET['id'];

        // Your database connection code and SQL query here
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ziondatabase";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM customers WHERE id= ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $customer_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $customer = mysqli_fetch_assoc($result);
        } else {
            echo "<p>Customer not found</p>";
        }

        mysqli_close($conn);
    } else {
        echo "<p>Invalid request. Please try again.</p>";
    }

    ?>

    <main>
        <?php if (isset($customer)) : ?>
            <div class="customer-details">
                <h2><span class="material-icons">account_circle</span>Customer Details</h2>
                <p>ID:
                    <?= $customer['id'] ?>
                </p>
                <p>Full Name:
                    <?= $customer['first_name'] . " " . $customer['last_name'] ?>
                </p>

                <p>Address:
                    <?= $customer['cus_address'] . " " . $customer['street'] . " " . $customer['subdivision'] . " " . $customer['barangay'] . " " . $customer['city'] ?>
                </p>
                <p>Contact #:
                    <?= $customer['tel_num'] ?>
                </p>
                <p>Landmark:
                    <?= $customer['landmark'] ?>
                </p>
                <p>Tank Type:
                    <?= $customer['tanktype'] ?>
                </p>
                <p>Branch:
                    <?= $customer['branch'] ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- Display the customer's previous orders -->
        <?php if (isset($customer_id)) : ?>
            <div class="previous-orders">
                <h2><span class="material-icons">history</span>Previous Orders</h2>
                <?php
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT o.order_id, pr.product_name, oi.quantity, oi.price, o.total_price, o.order_created, o.status, o.cashier 
                            FROM orders o
                            INNER JOIN order_items oi ON o.order_id = oi.order_id
                            INNER JOIN products pr ON oi.product_id = pr.product_id
                            WHERE o.customer_id = ?
                            ORDER BY o.order_created DESC"; // Add this line to sort the orders in descending order by order_created



                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $customer_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table-responsive'>";
                    echo "<thead><tr><th>Order ID</th><th>Product Name</th><th>Qty</th><th>Price</th><th>Total Price</th>
                        <th>Order Created</th><th>Order Status</th><th>Cashier</th>
                      </tr></thead>";
                    echo "<tbody>";
                    while ($order = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $order['order_id'] . "</td>";
                        echo "<td>" . $order['product_name'] . "</td>";
                        echo "<td>" . $order['quantity'] . "</td>";
                        echo "<td>" . $order['price'] . "</td>";
                        echo "<td>" . $order['total_price'] . "</td>";
                        echo "<td>" . $order['order_created'] . "</td>";
                        echo "<td>" . $order['status'] . "</td>";
                        echo "<td>" . $order['cashier'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p>No previous orders found.</p>";
                }

                mysqli_close($conn);
                ?>
            </div>
        <?php endif; ?>
        </div>
    </main>

    <!-- Add Order button -->
    <div class="add-button-form">
        <form action="add-order.php?id=<?php echo $customer['id']; ?>" method="POST">
            <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
            <input type="submit" name="submit" value="PLACE AN ORDER">
        </form>
    </div>

    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSS_GFpoO/4q4UJ6h7NRO2atBctyUpuIq3MApUNVb66c/1Y7d6NW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-gzjHzU5l3r9X7t7YNS8xiW45d2RZt6aEfropB98e8WAD7sJQLf74dK7G6zJM8T78" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ6pajs/rfdfs3SO+kD4Ck5BdPtF+to8xMikenZR/" crossorigin="anonymous"></script>

</body>

</html>