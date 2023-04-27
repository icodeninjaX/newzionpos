<?php
require_once 'auth_check.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Zion POS</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <script src="script.js"></script>
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
      height: 50%;
    }

    .profile-section {
      text-align: right;
      margin-right: 10px;
    }

    .profile-section a {
      color: #007bff;
    }

    .profile-section a:hover {
      text-decoration: underline;
    }

    .form-label {
      font-weight: bold;
      font-size: 10px;
    }

    .btn-primary {
      background-color: #2698d6;
      border-color: #2698d6;
    }

    .btn-primary:hover {
      background-color: #1c7db4;
      border-color: #1c7db4;
    }

    .error-message {
      text-align: center;
      color: red;
      font-size: 20px;
    }

    main {
      width: 50%;
      margin: 0 auto;
      border: 1px solid #ced4da;
      border-radius: 4px;
      margin-bottom: 20px;
    }

    .form-control-width {
      width: 47.5%;
    }

    .form-control {
      height: 17px;
      font-size: 10px;
      font-weight: bold;
      padding: 0;
      padding-left: 0.3rem;
      border: 1px solid black;
    }

    .form-group {
      margin-bottom: 0rem;
    }

    label {
      margin-bottom: 0rem;
    }

    h1 {
      color: #007bff;
      margin-top: 10px;
      font-size: 15px;
    }

    .welcome {
      font-size: 15px;
    }

    .btn {
      font-size: 12px;
      text-align: center;
    }

    .btn-primary {
      font-weight: bolder;
      color: white;
      background-color: #007bff;
      margin-top: 29px;
      margin-bottom: 10px;
    }

    .footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      text-align: center;
      opacity: 0.5;
      font-size: 12px;
      z-index: 1000;
    }

    .footer a {
      color: #007bff;
      text-decoration: none;
    }

    .footer a:hover {
      color: #0056b3;
      text-decoration: underline;
    }

    .icon-align {
      top: 0.2em;
      margin-right: 0.5em;
      font-size: 1.5em;
      vertical-align: text-top;
    }

    .text-center {
      color: black;
    }

    .person {
      font-size: 20px;
      margin-right: 2px;
      vertical-align: text-top;
    }
  </style>
</head>

<?php
require_once 'db_connection.php';

$insert_id = null;

// Check if the form was submitted
if (isset($_POST['submit'])) {
  // Get the form data
  $id = $_POST['id'];
  $first_name = strtoupper($_POST['first_name']);
  $last_name = strtoupper($_POST['last_name']);
  $tel_num = $_POST['tel_num'];
  $address = strtoupper($_POST['cus_address']);
  $street = strtoupper($_POST['street']);
  $subdivision = strtoupper($_POST['subdivision']);
  $landmark = strtoupper($_POST['landmark']);
  $city = strtoupper($_POST['city']);
  $branch = strtoupper($_POST['branch']);
  $tanktype = strtoupper($_POST['tanktype']);
  $barangay = strtoupper($_POST['barangay']);

  // Prepare the SQL statement
  $stmt = $conn->prepare("INSERT INTO customers (first_name, last_name, tel_num, cus_address, street, subdivision, landmark, city, branch, tanktype, barangay) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssssssss", $first_name, $last_name, $tel_num, $address, $street, $subdivision, $landmark, $city, $branch, $tanktype, $barangay);

  // Execute the statement and check for errors
  if ($stmt->execute()) {
    $id = $conn->insert_id;
    header("Location: add-order.php?id=" . $id);
    // $successMessage = "Customer added successfully. ID: {$id}";
  } else {
    $errorMessage = "Error: " . $stmt->error;
  }

  // Close the statement
  $stmt->close();
}
?>

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

  <div class="container">
    <div class="profile-section">
      <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) : ?>
        <p class="welcome">Welcome, <?php echo $_SESSION['username']; ?> | <a href="edit_profile.php">Edit Profile</a></p>
        <form action="logout.php" method="post">
          <input class="btn btn-outline-danger" type="submit" value="Log Out">
        </form>
      <?php else : ?>
        <a href="login.php">Log In</a>
      <?php endif; ?>
    </div>
  </div>
  <main>
    <div class="container" style="margin-top: 25px;">

      <?php if (isset($id)) : ?>
        <p class="text-center text-primary font-weight-bold">ID: <?php echo $id; ?></p>
      <?php endif; ?>

      <form action="index.php" method="POST">
        <h1><i class="material-icons person">person</i>Customer Information</h1>
        <hr>

        <!-- Form content -->
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" autocomplete="off" oninput="forceUppercase(this)" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="last_name">Surname</label>
              <input type="text" class="form-control" id="last_name" name="last_name" autocomplete="off" oninput="forceUppercase(this)" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="tel_num">Cellphone # / Telephone #</label>
          <input type="text" class="form-control form-control-width" id="tel_num" name="tel_num" autocomplete="off" oninput="forceUppercase(this)" required>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="cus_address">House # & Building #</label>
              <input type="text" class="form-control" id="cus_address" name="cus_address" autocomplete="off" oninput="forceUppercase(this)" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="street">Street</label>
              <input type="text" class="form-control" id="street" name="street" required>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="city" class="form-label">City</label>
              <select class="form-control" id="city" name="city" required>
                <option value="">Select City</option>
                <!-- Populate cities here -->
              </select>
            </div>
          </div>


          <div class="col-md-6">
            <div class="form-group">
              <label for="barangay" class="form-label">Barangay</label>
              <select class="form-control" id="barangay" name="barangay" disabled required>
                <option value="">Select Barangay</option>
              </select>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="subdivision">Subdivision</label>
              <select class="form-control" id="subdivision" name="subdivision">
                <option value="-">Select Subdivision</option>
                <option></option>
                <!-- Populate streets here -->
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="landmark">Landmark</label>
              <input type="text" class="form-control" id="landmark" name="landmark" autocomplete="off" oninput="forceUppercase(this)">

            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="branch">Nearest Branch</label>
              <select class="form-control" name="branch" required>
                <option value="Pamplona 1">Pamplona 1</option>
                <option value="Pamplona 2">Pamplona 2</option>
                <option value="Pamplona 3">Pamplona 3</option>
                <option value="Pamplona 4">Pamplona 4</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="tanktype">Tank-Type</label>
              <select class="form-control" name="tanktype" required>
                <option value="11kgs snap on">11kgs snap on</option>
                <option value="11kgs pol valve">11kgs pol valve</option>
                <option value="5kgs snap on">5kgs snap on</option>
                <option value="5kgs pol valve">5kgs pol valve</option>
              </select>
            </div>
          </div>
        </div>
    </div>

    <div class="form-group text-center">

      <button type="submit" name="submit" class="btn btn-primary" onclick="successAlert()" id="add-customer-btn"><i class="material-icons icon-align">person_add</i>Add Customer</button>
    </div>

    </form>
  </main>

  <?php if (isset($errorMessage)) : ?>
    <p class="error-message"><?php echo $errorMessage; ?></p>
  <?php endif; ?>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSS_GFpoO/4q4UJ6h7NRO2atBctyUpuIq3MApUNVb66c/1Y7d6NW" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-gzjHzU5l3r9X7t7YNS8xiW45d2RZt6aEfropB98e8WAD7sJQLf74dK7G6zJM8T78" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ6pajs/rfdfs3SO+kD4Ck5BdPtF+to8xMikenZR/" crossorigin="anonymous"></script>


  <script>
    $(document).ready(function() {
      // Fetch cities
      $.get("get_cities.php", function(data) {
        let cities = JSON.parse(data);
        cities.forEach(function(city) {
          $("#city").append(`<option value="${city.city_name}" data-id="${city.id}">${city.city_name}</option>`);
        });
      });

      // Fetch barangays based on city selection
      $("#city").change(function() {
        let cityId = $('option:selected', this).data('id');
        $("#barangay").html('<option value="">Select Barangay</option>').prop("disabled", false);
        $.get("get_barangays.php", {
          city_id: cityId
        }, function(data) {
          let barangays = JSON.parse(data);
          barangays.forEach(function(barangay) {
            $("#barangay").append(`<option value="${barangay.barangay_name}" data-id="${barangay.id}">${barangay.barangay_name}</option>`);
          });
        });
      });

      // Fetch streets/subdivisions based on barangay selection

      $("#barangay").change(function() {
        let barangayId = $('option:selected', this).data('id');
        $("#subdivision").html('<option value="">Select Subdivision</option>').prop("disabled", false);
        $.get("get_subdivision.php", {
            barangay_id: barangayId
          })
          .done(function(data) {
            let subdivisions = JSON.parse(data);
            subdivisions.forEach(function(subdivision) {
              $("#subdivision").append(`<option value="${subdivision.subdivision_name}" data-id="${subdivision.id}">${subdivision.subdivision_name}</option>`);
            });
          })
          .fail(function(xhr, textStatus, errorThrown) {
            console.error('Error:', textStatus, errorThrown);
          });
      });


      $("#subdivision").change(function() {
        let subdivisionId = $('option:selected', this).data('id');
        $("#street").html('<option value="">Select Street</option>').prop("disabled", false);
        $.get("get_streets.php", {
          subdivision_id: subdivisionId
        }, function(data) {
          let streets = JSON.parse(data);
          streets.forEach(function(street) {
            $("#street").append(`<option value="${street.street_name}" data-id="${street.id}">${street.street_name}</option>`);
          });
        });
      });


    });

    function successAlert() {
      alert("Customer Added Successfully!");
    }
  </script>

</body>

<footer class="footer">
  Design by <a href="https://www.facebook.com/dwarren16/">Keith Dwarren P. Vergara</a> | © 2023 - All Rights Reserved
</footer>



</html>