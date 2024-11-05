<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit();
}

echo "Welcome to the Admin Dashboard!";
?>
