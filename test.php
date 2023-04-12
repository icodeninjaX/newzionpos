<?php
require_once 'auth_check.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Customer</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }

    .navbar {
      padding: 0.5rem 1rem;
      margin-bottom: 80px
    }

    .navbar .nav-item .nav-link {
      color: #000;
    }

    .navbar .nav-item .nav-link:hover {
      color: #007bff;
    }

    .container {
      max-width: 100%;
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

    .search-form input[type="text"] {
      border: 1px solid black;
      border-radius: 8px;
      height: 20px;
      width: 23%;
      font-size: 10px;
      padding-left: 7px;
      font-weight: bold;
    }

    .search-form input[type="submit"] {
      border: 1px solid black;
      border-radius: 8px;
      height: 20px;
      width: 50px;
      font-size: 11px;
      cursor: pointer;
      padding: 0;
      background-color: #007bff;
      color: white;
      font-weight: bold;
    }

    .search-form input[type="submit"]:hover {
      background-color: lightgray;
      color: black;
    }

    .search-form-wrapper {
      text-align: center;
      justify-content: center;
      margin-bottom: 30px;
    }

    table {
      border: 1px solid black;
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 8px;
    }

    th {
      height: 10px;
      text-align: center;
      font-size: 12px;
      background-color: #007bff;
      color: #ffffff;
    }

    td {
      border: 1px solid black;
      text-align: center;
      font-weight: bold;
      font-size: 10px;
    }

    tr:hover {
      background-color: #FFFDD0;
      cursor: pointer;
    }

    .contact {
      width: 10%;
    }

    .address {
      width: 20%;
      font-size: 10px;
    }

    .table-wrapper {
      border: 1px solid black;
      border-radius: 4px;
      overflow: hidden;
    }

    main {
      width: 80%;
      margin: 0 auto;
    }

    h2 {
      font-size: 1.5rem;
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

  <main>

    <div class="search-form-wrapper">
      <form class="search-form" action="search-customer.php" method="POST">
        <h2>Search Customer</h2>
        <input type="text" name="search" placeholder="Search by Name or Cellphone # / Telephone #" autocomplete="off">
        <input type="submit" name="submit" value="Search">
      </form>
    </div>

    <?php
    $search = '';
    if (isset($_POST['search'])) {
      $search = $_POST['search'];
    } elseif (isset($_GET['search'])) {
      $search = $_GET['search'];
    } else {
      $search = ''; // Initialize the search variable as an empty string if not set
    }


    // Your database connection code and SQL query here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ziondatabase";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $search = mysqli_real_escape_string($conn, $search);
    $sql = "SELECT * FROM customers WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR tel_num LIKE '%$search%' LIMIT 10";
    $result = mysqli_query($conn, $sql);



    if (mysqli_num_rows($result) > 0) {

      echo "<div class='table-wrapper'>";
      echo "<table>";
      echo "<tr><th>#</th><th>ID</th><th>First name</th><th>Last name</th><th>Address</th>
      <th>Street</th><th>Subdivison</th><th>Contact #</th><th>Landmark</th><th>Tank Type</th><th>Branch</th></tr>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><a href='view-customer.php?id=" . $row['id'] . "'>" . "Order" . "</a></td>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td class='address'>" . $row['cus_address'] . "</td>";
        echo "<td>" . $row['street'] . "</td>";
        echo "<td>" . $row['subdivision'] . "</td>";
        echo "<td class='contact'>" . $row['tel_num'] . "</td>";
        echo "<td>" . $row['landmark'] . "</td>";
        echo "<td>" . $row['tanktype'] . "</td>";
        echo "<td>" . $row['branch'] . "</td>";
        echo "</tr>";
      }


      echo "</table>";
      echo "</div>";
    } else {
      echo "<p>No results found</p>";
    }



    ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSS_GFpoO/4q4UJ6h7NRO2atBctyUpuIq3MApUNVb66c/1Y7d6NW" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-gzjHzU5l3r9X7t7YNS8xiW45d2RZt6aEfropB98e8WAD7sJQLf74dK7G6zJM8T78" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ6pajs/rfdfs3SO+kD4Ck5BdPtF+to8xMikenZR/" crossorigin="anonymous"></script>
</body>

</html>