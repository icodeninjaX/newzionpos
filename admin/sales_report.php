<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
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
            <a href="#"><i class="material-icons top-icons">settings</i></a>
            <a href="#"><i class="material-icons top-icons">person</i></a>
            <a href="#"><i class="material-icons top-icons">admin_panel_settings</i></a>
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
                <li><a href="registered_branch.php" style="font-size: 18px;" class="ordermanagement"><img
                            src="img/franchise.png" alt="gas" class="orders">Registered Branch</a></li>
                <li class="active"><a href="sales_report.php" style="font-size: 18px;" class="ordermanagement"><img
                            src="img/sales.png" alt="gas" class="orders">Sales Report</a></li>
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
                    <img src="img/sales-report.png" alt="Orders" class="order-img">Sales Report
                </h1>
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
                <button id="print-button">Print Report</button>
            </form>

            <p id="date-range-display"></p> <!-- Moved above the "Print Report" button -->



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
                    require_once 'db_connection.php';

                    $from_date = isset($_GET['from-date']) ? $_GET['from-date'] : '';
                    $until_date = isset($_GET['until-date']) ? $_GET['until-date'] : '';
                    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                    $limit = 20; // Columns per page
                    $offset = ($page - 1) * $limit;

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
        ORDER BY orders.order_id DESC
        LIMIT $limit
        OFFSET $offset";


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
            <?php
            // Add PHP code for pagination links
            

            // Find the total number of records
            $sql_total_records = "SELECT COUNT(*) as total_records
                      FROM customers
                      JOIN orders ON customers.id = orders.customer_id
                      JOIN order_items ON orders.order_id = order_items.order_id
                      JOIN products ON order_items.product_id = products.product_id
                      WHERE $sql_filter";
            $result_total_records = mysqli_query($conn, $sql_total_records);
            $row_total_records = mysqli_fetch_assoc($result_total_records);
            $total_records = $row_total_records['total_records'];

            $total_pages = ceil($total_records / $limit);


            echo "<div class='pagination'>";
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='sales_report.php?page=" . $i . "&from-date=" . $from_date . "&until-date=" . $until_date . "'>" . $i . "</a>";
            }
            echo "</div>";
            ?>
        </div>
    </div>

    <script>
        function getDateRangeText() {
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

                return `This report is from ${formattedFromDate} to ${formattedUntilDate}`;
            }

            return '';
        }

        function displayDateRange() {
            const dateRangeText = getDateRangeText();
            if (dateRangeText) {
                document.getElementById("date-range-display").innerText = dateRangeText;
            }
        }


        // Add this function to handle the print functionality
        function printReport() {
            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>New Zion LPG Corp.</title>');
            printWindow.document.write('<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">');
            printWindow.document.write('<link href="print-style.css" rel="stylesheet">');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h1>Sales Report</h1>'); // Optional: Add a title for the printed report
            const dateRangeText = getDateRangeText();
            if (dateRangeText) {
                printWindow.document.write('<p>' + dateRangeText + '</p>');
            }
            printWindow.document.write(document.getElementById("sales-report-table").outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        // Add an event listener to the print button
        document.getElementById("print-button").addEventListener("click", printReport);

        window.addEventListener('load', displayDateRange);
    </script>


</body>

</html>