<?php
session_start();

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Check if the user is an admin, if not redirect to the welcome page
if ($_SESSION['role'] !== 'admin') {
    header("Location: welcome.php");
    exit;
}

// Check if the user ID is provided in the query string
if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}

// Get the user ID from the query string
$userId = $_GET['id'];

// Connect to the database
include 'connect.php';

// Delete the user from the users table
$deleteQuery = "DELETE FROM users WHERE id = '$userId'";
$result = mysqli_query($con, $deleteQuery);

if ($result) {
    // User deleted successfully, redirect to the users page
    header("Location: users.php");
    exit;
} else {
    $error = "Error deleting user";
}

mysqli_close($con);
?>
