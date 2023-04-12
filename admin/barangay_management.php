<?php
session_start();
require_once 'admin_auth_check.php';
requireAdmin();

$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT * FROM barangays";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Order Management</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
            font-size: 14px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            border-radius: 4px;
        }

        table thead th {
            background-color: #3F51B5;
            color: white;
            text-align: center;
            padding: 5px;
        }

        table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #ddd;
        }

        table tbody td {
            padding: 2px;
            border-bottom: 1px solid #ddd;
        }

        .tablehead {
            border-radius: 4px;
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
            padding: 10px;
            font-size: 12px;
            flex-grow: 1;
        }

        .search-form button {
            background-color: #3F51B5;
            color: white;
            font-size: 12px;
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
            /* Adjust this value according to your desired logo size */
            max-height: 50px;
            /* Adjust this value according to your desired logo size */
            height: auto;
        }

        th {
            background-color: #3F51B5;
            color: white;
            font-size: 12px;
        }

        td {
            padding: 5px;
            text-align: center;
            font-size: 12px;
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

        .order-icon {
            color: white;
            font-size: 15px;
            margin-right: 5px;
        }

        .search-icon {
            font-size: 20px;
        }

        .delivered-icon {
            background-color: #3F51B5;
            font-size: 15px;
        }

        .cancel-icon {
            font-size: 15px;
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
            <a href="logout.php">LOG OUT</a>
        </div>
    </div>

    <div class="sidebar">
        <ul>
            <!-- Your existing menu items -->
            <li><a href="order_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">assignment</i>Order Management</a></li>
            <li><a href="customer.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">group</i>Registered Customer</a></li>
            <li><a href="product_management.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">list</i>Product Management</a></li>
            <li><a href="registered_branch.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">store</i>Registered Branch</a></li>
            <li><a href="sales_report.php" style="font-size: 12px;"><i class="material-icons order-icon" style="vertical-align: middle;">bar_chart</i>Sales Report</a></li>

            <!-- Location Manager drop-down menu -->
            <li>
                <details style="font-size: 12px; color: white; font-weight: bold; padding-top: 5px;">
                    <summary>
                        <i class="material-icons order-icon active" style="vertical-align: middle; padding-bottom: 5px;">location_city</i>Location Manager
                    </summary>
                    <ul>
                        <li><a href="city_management.php">City Management</a></li>
                        <li class="active"><a href="barangay_management.php">Barangay Management</a></li>
                        <li><a href="subdivision_management.php">Subdivision Management</a></li>
                        <li><a href="street_management.php">Street Management</a></li>
                    </ul>
                </details>
            </li>
        </ul>
    </div>



    <div class="container">


        <div class="main-content">
            <div class="">
                <h2>BARANGAY MANAGEMENT</h2>
                <div class="container">
                    <div class="col-md-4">
                        <h3>Add Barangay</h3>
                        <form id="add-barangay-form">
                            <div class="mb-3" style="display: flex; justify-content: space-between; align-items: stretch;">
                                <select class="form-select" id="city_id" required style="margin-right: 10px;">
                                    <option value="">Select City</option>
                                    <!-- Populate cities here -->
                                </select>
                                <input type="text" class="form-control" id="barangay_name" required placeholder="Enter Barangay Name Here" style="width: 180px;" autocomplete="off">
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
                                        <td><?php echo $row['barangay_name']; ?></td>
                                        <td>
                                            <!-- Add action buttons here, e.g. Edit, Delete -->
                                            <a href="edit_city.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                            <a href="delete_city.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
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
                    <?php
                    mysqli_close($conn);
                    ?>
                </div>


            </div>


        </div>


        <script>
            $(document).ready(function() {
                // Fetch cities
                function fetchCities() {
                    $.get("get_city.php", function(data) {
                        let cities = JSON.parse(data);
                        $("#city_id").html('<option value="">Select City</option>');
                        cities.forEach(function(city) {
                            $("#city_id").append(`<option value="${city.id}">${city.city_name}</option>`);
                        });
                    });
                }

                fetchCities();

                // Add city
                $("#add-city-form").submit(function(e) {
                    e.preventDefault();
                    let city_name = $("#city_name").val();
                    $.post("add_city.php", {
                        city_name: city_name
                    }, function(data) {
                        alert(data);
                        $("#city_name").val("");
                        fetchCities();
                    });
                });

                // Add barangay
                $("#add-barangay-form").submit(function(e) {
                    e.preventDefault();
                    let city_id = $("#city_id").val();
                    let barangay_name = $("#barangay_name").val();
                    $.post("add_barangay.php", {
                        city_id: city_id,
                        barangay_name: barangay_name
                    }, function(data) {
                        alert(data);
                        $("#barangay_name").val("");
                    });
                });

                // Add subdivision
                $("#add-subdivision-form").submit(function(e) {
                    e.preventDefault();
                    let barangay_id = $("#barangay_id").val();
                    let subdivision_name = $("#subdivision_name").val();
                    $.post("add_subdivision.php", {
                        barangay_id: barangay_id,
                        subdivision_name: subdivision_name
                    }, function(data) {
                        alert(data);
                        $("#subdivision_name").val("");
                    });
                });

                // Add street
                $("#add-street-form").submit(function(e) {
                    e.preventDefault();
                    let subdivision_id = $("#subdivision_id").val();
                    let street_name = $("#street_name").val();
                    $.post("add_street.php", {
                        subdivision_id: subdivision_id,
                        street_name: street_name
                    }, function(data) {
                        alert(data);
                        $("#street_name").val("");
                    });
                });

                // Fetch barangays when a city is selected
                $("#city_id").change(function() {
                    let cityId = $(this).val();
                    $.get("get_barangays.php", {
                        city_id: cityId
                    }, function(data) {
                        let barangays = JSON.parse(data);
                        $("#barangay_id").html('<option value="">Select Barangay</option>');
                        barangays.forEach(function(barangay) {
                            $("#barangay_id").append(`<option value="${barangay.id}">${barangay.barangay_name}</option>`);
                        });
                    });
                });

                // Fetch subdivisions when a barangay is selected
                $("#barangay_id").change(function() {
                    let barangayId = $(this).val();
                    $.get("get_subdivision.php", {
                        barangay_id: barangayId
                    }, function(data) {
                        let subdivisions = JSON.parse(data);
                        $("#subdivision_id").html('<option value="">Select Subdivision</option>');
                        subdivisions.forEach(function(subdivision) {
                            $("#subdivision_id").append(`<option value="${subdivision.id}">${subdivision.subdivision_name}</option>`);
                        });
                    });
                });




            });
        </script>

</body>

</html>