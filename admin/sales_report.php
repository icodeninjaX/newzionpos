<!DOCTYPE html>
<html>

<head>
    <title>Sales Report</title>
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
            align-items: center;
            background-color: #3F51B5;
            padding: 16px;
            color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .settings-container {
            display: flex;
        }

        .settings-container a {
            color: white;
            text-decoration: none;
            margin-left: 16px;
        }

        .settings-container a:hover {
            text-decoration: underline;
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
            top: 68px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            top: 81px;
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
            font-size: 10px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            border-radius: 4px;

        }

        table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #ddd;
        }

        table tbody td {
            border-bottom: 1px solid #ddd;
        }

        .search-form {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            width: 35%;
        }

        .search-form input[type="text"] {
            border: none;
            outline: none;
            padding: 8px;
            font-size: 14px;
            flex-grow: 1;
        }

        .search-form button {
            background-color: #3F51B5;
            color: white;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            outline: none;
            transition: background-color 0.3s;
        }

        .search-form button:hover {
            background-color: #283593;
        }

        button {
            background-color: #3F51B5;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #283593;
        }

        .delete-button,
        .cancel-button {
            background-color: #f44336;
        }

        .delete-button:hover,
        .cancel-button:hover {
            background-color: #d32f2f;
        }

        .logo {
            max-width: 50px;
            max-height: 50px;
            height: auto;
        }

        th {
            background-color: #3F51B5;
            color: white;
            text-align: left;
        }

        .pagination {
            text-align: center;
            margin: 16px 0;
        }

        .pagination a {
            display: inline-block;
            margin: 0 4px;
            padding: 8px 12px;
            text-decoration: none;
            background-color: #3F51B5;
            color: white;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a.active,
        .pagination a:hover {
            background-color: #283593;
        }

        #print-button {
            background-color: #4CAF50;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 12px;
        }

        #print-btn:hover {
            background-color: #388E3C;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #sales-report-table,
            #sales-report-table *,
            #date-range-display,
            #date-range-display * {
                visibility: visible;
            }

            #sales-report-table {
                position: absolute;
                left: 0;
                top: 30px;
                width: 100%;
                font-size: 14px;
                border-collapse: collapse;
            }

            #date-range-display {
                position: absolute;
                left: 0;
                top: 0;
                font-size: 12px;
                color: black;
            }

            th,
            td {
                border: 1px solid black;
                padding: 2px;
                text-align: left;
            }

            th {
                background-color: white;
                color: black;
            }
        }

        .order-icon {
            color: white;
            font-size: 15px;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div id="header-container">
        <!-- Add your existing header content here -->
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
                <li><a href="registered_branch.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">store</i>Registered Branch</a></li>
                <li class="active"><a href="sales_report.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">bar_chart</i>Sales Report</a></li>

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
                <h1> Sales Report </h1>
            </div>


            <?php
            $from_date = isset($_GET['from-date']) ? $_GET['from-date'] : '';
            $until_date = isset($_GET['until-date']) ? $_GET['until-date'] : '';
            ?>

            <form method="get" action="">
                <label for="from-date">From:</label>
                <input type="date" id="from-date" name="from-date" value="<?php echo $from_date; ?>">

                <label for="until-date">Until:</label>
                <input type="date" id="until-date" name="until-date" value="<?php echo $until_date; ?>">

                <button type="submit">Show Report</button>
            </form>

            <p id="date-range-display"></p> <!-- Moved above the "Print Report" button -->
            <button id="print-button">Print Report</button>


            <table id="sales-report-table">
                <thead>

                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Paid Amount</th>
                    <th>Order Created</th>
                    <th>Status</th>

                </thead>
                <tbody>
                    <!-- Add PHP code to fetch sales data and display it in table rows -->

                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "ziondatabase");
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $from_date = isset($_GET['from-date']) ? $_GET['from-date'] : '';
                    $until_date = isset($_GET['until-date']) ? $_GET['until-date'] : '';

                    if ($from_date != '' && $until_date != '') {
                        $sql_filter = "DATE(orders.order_created) BETWEEN '$from_date' AND '$until_date'";
                    } else {
                        $sql_filter = "1";
                    }


                    $sql = "SELECT customers.*, orders.*, order_items.quantity, order_items.price as paid_amount, products.product_name
            FROM customers
            JOIN orders ON customers.id = orders.customer_id
            JOIN order_items ON orders.order_id = order_items.order_id
            JOIN products ON order_items.product_id = products.product_id
            WHERE $sql_filter
            ORDER BY orders.order_created DESC";



                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['order_id'] . "</td>";
                            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                            echo "<td>" . $row['product_name'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['paid_amount'] . "</td>";
                            echo "<td>" . $row['order_created'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No sales data found</td></tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

    <script>
        function displayDateRange() {
            const url = new URL(window.location.href);
            const fromDate = url.searchParams.get('from-date');
            const untilDate = url.searchParams.get('until-date');

            if (fromDate && untilDate) {
                const formattedFromDate = new Intl.DateTimeFormat('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric'
                }).format(new Date(fromDate));

                const formattedUntilDate = new Intl.DateTimeFormat('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric'
                }).format(new Date(untilDate));

                document.getElementById("date-range-display").innerText = `This report is from ${formattedFromDate} to ${formattedUntilDate}`;
            }
        }

        document.querySelector("form").addEventListener("submit", function(event) {
            event.preventDefault();
            const fromDate = document.getElementById("from-date").value;
            const untilDate = document.getElementById("until-date").value;

            const url = new URL(window.location.href);
            url.searchParams.set('from-date', fromDate);
            url.searchParams.set('until-date', untilDate);

            window.location.href = url.toString();
        });

        // Add this function to handle the print functionality
        function printReport() {
            window.print();
        }

        // Add an event listener to the print button
        document.getElementById("print-button").addEventListener("click", printReport);

        window.addEventListener('load', displayDateRange);
    </script>


</body>

</html>