<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ziondatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['barangay_id'])) {
    $barangay_id = $_GET['barangay_id'];

    // Fetch subdivisions for the specific barangay
    $sql = "SELECT * FROM subdivisions WHERE barangay_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $barangay_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $subdivisions = array();

    while ($row = $result->fetch_assoc()) {
        array_push($subdivisions, $row);
    }

    echo json_encode($subdivisions);

    $stmt->close();
}

$conn->close();
?>


