<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();

require_once 'db_connection.php';

$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT barangays.*, cities.city_name 
        FROM barangays 
        INNER JOIN cities ON barangays.city_id = cities.id
        ORDER BY barangay_name ASC LIMIT $start, $limit";


$result = mysqli_query($conn, $sql);

$result_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM barangays");
$count = mysqli_fetch_assoc($result_count);
$total_pages = ceil($count['total'] / $limit);
?>


<!DOCTYPE html>
<html>

<head>
    <title>Barangay Management</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

    <div class="sidebar">
        <!-- Add your existing sidebar content here -->
        <ul>
            <!-- Your existing menu items -->
            <li><a href="order_management.php" style="font-size: 18px;" class="ordermanagement"><img
                        src="img/inventory-management.png" alt="gas" class="orders">Order Management</a></li>
            <li><a href="customer.php" style="font-size: 18px;" class="ordermanagement"><img src="img/customer-1.png"
                        alt="gas" class="orders">Registered Customer</a></li>
            <li><a href="product_management.php" style="font-size: 18px;" class="ordermanagement"><img
                        src="img/gas-2.png" alt="gas" class="orders">Product Management</a></li>
            <li><a href="registered_branch.php" style="font-size: 18px;" class="ordermanagement"><img
                        src="img/franchise.png" alt="gas" class="orders">Registered Branch</a></li>
            <li><a href="sales_report.php" style="font-size: 18px;" class="ordermanagement"><img src="img/sales.png"
                        alt="gas" class="orders">Sales Report</a></li>
            <p style="font-size: 10px; text-align: center; font-weight: bold;">Location Management</p>
            <li><a href="city_management.php" style="font-size: 17px;" class="ordermanagement"><img
                        src="img/location.png" alt="gas" class="orders">City Management</a></li>
            <li class="active"><a href="barangay_management.php" style="font-size: 17px;" class="ordermanagement"><img
                        src="img/location.png" alt="gas" class="orders">Barangay Management</a></li>
            <li><a href="subdivision_management.php" style="font-size: 16px;" class="ordermanagement"><img
                        src="img/location.png" alt="gas" class="orders">Subdivision Management</a></li>
            <li><a href="street_management.php" style="font-size: 17px;" class="ordermanagement"><img
                        src="img/location.png" alt="gas" class="orders">Street Management</a></li>
            <br>
            <li><a href="logout.php" class="ordermanagement log-out" style="font-size: 20px;"><img src="img/logout.png"
                        alt="gas" class="orders">LOG OUT</a></li>
        </ul>
    </div>
    </div>


    <div class="container">


        <div class="main-content">
            <div class="header-container">
                <h1
                    style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size: 25px; vertical-align: middle;">
                    <img src="img/location-management.png" alt="Orders" class="order-img">Barangay Management
                </h1>
                <div class="container">
                    <div class="col-md-4">
                        <h3>Add Barangay</h3>
                        <form id="add-barangay-form">
                            <div class="input-container">
                                <select class="form-select" id="city_id" required style="margin-right: 10px;">
                                    <option value="">Select City</option>
                                    <!-- Populate cities here -->
                                </select>
                                <input type="text" class="form-control" id="barangay_name" required
                                    placeholder="Enter Barangay" style="width: 180px;" autocomplete="off">
                                <button type="submit" class="btn btn-primary">Add Barangay</button>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="col-md-8">
                    <h3>Barangay List</h3>
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">City</th>
                                <th scope="col">Barangay Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="city-list">
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['city_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['barangay_name']; ?>
                                        </td>

                                        <td>
                                            <!-- Add action buttons here, e.g. Edit, Delete -->
                                            <a href="edit_city.php?id=<?php echo $row['id']; ?>"
                                                class="btn btn-primary">Edit</a>
                                            <a href="delete_city.php?id=<?php echo $row['id']; ?>"
                                                class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='2'>No cities found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="pagination<?php echo ($page == $i) ? ' active' : ''; ?>">
                                    <a class="pagination" href="barangay_management.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                    <?php
                    mysqli_close($conn);
                    ?>

                </div>


            </div>


        </div>


        <script>
            $(document).ready(function () {
                // Fetch cities
                function fetchCities() {
                    $.get("get_city.php", function (data) {
                        let cities = JSON.parse(data);
                        $("#city_id").html('<option value="">Select City</option>');
                        cities.forEach(function (city) {
                            $("#city_id").append(`<option value="${city.id}">${city.city_name}</option>`);
                        });
                    });
                }

                function fetchBarangays() {
                    $.get("get_barangays.php", function (data) {
                        let barangays = JSON.parse(data);
                        $("#city-list").html('');
                        barangays.forEach(function (barangay) {
                            $("#city-list").append(`
                        <tr>
                            <td>${barangay.city_name}</td>
                            <td>${barangay.barangay_name}</td>
                            <td>
                                <a href="edit_city.php?id=${barangay.id}" class="btn btn-primary">Edit</a>
                                <a href="delete_city.php?id=${barangay.id}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    `);
                        });
                    });
                }

                // Initialize
                fetchCities();
                fetchBarangays();

                // Add city
                $("#add-city-form").submit(function (e) {
                    e.preventDefault();
                    let city_name = $("#city_name").val();
                    $.post("add_city.php", {
                        city_name: city_name
                    }, function (data) {
                        alert(data);
                        $("#city_name").val("");
                        fetchCities();
                    });
                });

                // Add barangay
                $("#add-barangay-form").submit(function (e) {
                    e.preventDefault();
                    let city_id = $("#city_id").val();
                    let barangay_name = $("#barangay_name").val();
                    $.post("add_barangay.php", {
                        city_id: city_id,
                        barangay_name: barangay_name
                    }, function (data) {
                        alert(data);
                        $("#barangay_name").val("");
                    });
                });

                // Add subdivision
                $("#add-subdivision-form").submit(function (e) {
                    e.preventDefault();
                    let barangay_id = $("#barangay_id").val();
                    let subdivision_name = $("#subdivision_name").val();
                    $.post("add_subdivision.php", {
                        barangay_id: barangay_id,
                        subdivision_name: subdivision_name
                    }, function (data) {
                        alert(data);
                        $("#subdivision_name").val("");
                    });
                });

                // Add street
                $("#add-street-form").submit(function (e) {
                    e.preventDefault();
                    let subdivision_id = $("#subdivision_id").val();
                    let street_name = $("#street_name").val();
                    $.post("add_street.php", {
                        subdivision_id: subdivision_id,
                        street_name: street_name
                    }, function (data) {
                        alert(data);
                        $("#street_name").val("");
                    });
                });

                // Fetch barangays when a city is selected
                $("#city_id").change(function () {
                    let cityId = $(this).val();
                    $.get("get_barangays.php", {
                        city_id: cityId
                    }, function (data) {
                        let barangays = JSON.parse(data);
                        $("#barangay_id").html('<option value="">Select Barangay</option>');
                        barangays.forEach(function (barangay) {
                            $("#barangay_id").append(`<option value="${barangay.id}">${barangay.barangay_name}</option>`);
                        });
                    });
                });

                // Fetch subdivisions when a barangay is selected
                $("#barangay_id").change(function () {
                    let barangayId = $(this).val();
                    $.get("get_subdivision.php", {
                        barangay_id: barangayId
                    }, function (data) {
                        let subdivisions = JSON.parse(data);
                        $("#subdivision_id").html('<option value="">Select Subdivision</option>');
                        subdivisions.forEach(function (subdivision) {
                            $("#subdivision_id").append(`<option value="${subdivision.id}">${subdivision.subdivision_name}</option>`);
                        });
                    });
                });




            });
        </script>

</body>

</html>