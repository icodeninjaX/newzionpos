<?php

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "ziondatabase");

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the user's input from the login form
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare an SQL query to find a user with the given username and password
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a matching user is found, check the password
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {



            // If the password is correct, start a session and store the user ID and role in session variables
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];


            // Redirect the user to the dashboard or another appropriate page
            header("Location: main_dashboard.php");
            exit;
        } else {
            // Handle the incorrect password case
            echo "Incorrect password.";
        }

    } else {
        // Handle the case where no matching user is found
        echo "No user found with the given username.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: 5% auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center">Admin Login</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <!---<div>
                <button><a href="admin_signup.php">Signup</a></button>
            </div> -->

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>