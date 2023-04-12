<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Add Customer</h1>
        <form id="add-customer-form" class="mt-4">
            <!-- Additional customer fields go here -->

            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <select class="form-select" id="city" required>
                    <option value="">Select City</option>
                    <!-- Populate cities here -->
                </select>
            </div>
            <div class="mb-3">
                <label for="barangay" class="form-label">Barangay</label>
                <select class="form-select" id="barangay" disabled required>
                    <option value="">Select Barangay</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Street/Subdivision</label>
                <select class="form-select" id="street" disabled required>
                    <option value="">Select Street/Subdivision</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Customer</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
  // Fetch cities
  $.get("get_cities.php", function(data) {
    let cities = JSON.parse(data);
    console.log('Cities:', cities); // Add this line
    cities.forEach(function(city) {
      $("#city").append(`<option value="${city.id}">${city.city_name}</option>`);
    });
  });

  // Fetch barangays based on city selection
  $("#city").change(function() {
    let cityId = $(this).val();
    $("#barangay").html('<option value="">Select Barangay</option>').prop("disabled", false);
    $.get("get_barangays.php", {
      city_id: cityId
    }, function(data) {
      let barangays = JSON.parse(data);
      console.log('Barangays:', barangays); // Add this line
      barangays.forEach(function(barangay) {
        $("#barangay").append(`<option value="${barangay.id}">${barangay.barangay_name}</option>`);
      });
    });
  });

  // Fetch streets/subdivisions based on barangay selection
  $("#barangay").change(function() {
    let barangayId = $(this).val();
    $("#street").html('<option value="">Select Street/Subdivision</option>').prop("disabled", false);
    $.get("get_subdivision.php", {
      barangay_id: barangayId
    }, function(data) {
      let streets = JSON.parse(data);
      console.log('Streets:', streets); // Add this line
      streets.forEach(function(street) {
        $("#street").append(`<option value="${street.id}">${street.street_name}</option>`);
      });
    });
  });
});

</script>
</body>
</html>