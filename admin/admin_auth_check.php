<?php
function isLoggedIn()
{
    return (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']));
}

function requireAdmin()
{
    if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
        header("Location: access_denied.php");
        exit;
    }
}

?>