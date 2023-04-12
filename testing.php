<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        <div class="row mt-4">
            <div class="col-md-4">
                <h3>Add City</h3>
                <form id="add-city-form">
                    <div class="mb-3">
                        <label for="city_name" class="form-label">City Name</label>
                        <input type="text" class="form-control" id="city_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add City</button>
                </form>
            </div>
            <div class="col-md-4">
                <h3>Add Barangay</h3>
                <form id="add-barangay-form">
                    <div class="mb-3">
                        <label for="city_id" class="form-label">City</label>
                        <select class="form-select" id="city_id" required>
                            <option value="">Select City</option>
                            <!-- Populate cities here -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="barangay_name" class="form-label">Barangay Name</label>
                        <input type="text" class="form-control" id="barangay_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Barangay</button>
                </form>
            </div>
            <div class="col-md-4">
                <h3>Add Subdivision</h3>
                <form id="add-subdivision-form">
                    <div class="mb-3">
                        <label for="barangay_id" class="form-label">Barangay</label>
                        <select class="form-select" id="barangay_id" required>
                            <option value="">Select Barangay</option>
                            <!-- Populate barangays here -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subdivision_name" class="form-label">Subdivision Name</label>
                        <input type="text" class="form-control" id="subdivision_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Subdivision</button>
                </form>
            </div>
            <div class="col-md-4">
                <h3>Add Street</h3>
                <form id="add-street-form">
                    <div class="mb-3">
                        <label for="subdivision_id" class="form-label">Subdivision</label>
                        <select class="form-select" id="subdivision_id" required>
                            <option value="">Select Subdivision</option>
                            <!-- Populate subdivisions here -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="street_name" class="form-label">Street Name</label>
                        <input type="text" class="form-control" id="street_name" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Street</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Fetch cities
            function fetchCities() {
                $.get("get_cities.php", function(data) {
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
                $.post("testing_add_cities.php", {
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
                $.post("testing_add_barangay.php", {
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
                $.post("testing_add_subdivision.php", {
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
                $.post("testing_add_street.php", {
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