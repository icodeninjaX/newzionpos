<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user's input from the sign-up form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the password and confirm password match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = "admin";

        // Prepare an SQL query to insert the new user into the users table
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $hashed_password, $role);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "New admin created successfully.";
            header("Location: add-test.php");
        } else {
            echo "Error creating new admin: " . $conn->error;
        }

        $stmt->close();
    }
}
$conn->close();
?>