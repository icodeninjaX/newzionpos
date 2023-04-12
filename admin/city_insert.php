<?php

if (!isset($_POST['form_type']) || !isset($_POST['city_name'])) {
    die("Missing required parameters.");
}

$form_type = $_POST['form_type'];
$city_name = $_POST['city_name'];

$conn = mysqli_connect("localhost", "root", "", "ziondatabase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($form_type === 'city') {
    $city_name = mysqli_real_escape_string($conn, $city_name);
    $sql = "INSERT INTO cities (city_name) VALUES ('$city_name')";
} else {
    die("Invalid form type.");
}

if (mysqli_query($conn, $sql)) {
    header("Location: location_management.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
