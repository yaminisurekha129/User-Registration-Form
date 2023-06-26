<?php
session_start();

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Retrieve the user's information from the session
$email = $_SESSION['email'];

// Include the database connection
include 'connect.php';

// Fetch user data from the registration table based on the email
$sql = "SELECT * FROM registration WHERE email = '$email' LIMIT 1";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // Retrieve user information
    $firstName = $user['first_name'];
    $lastName = $user['last_name'];

    // Display the welcome message and user information
    echo "Welcome, $firstName $lastName! You are logged in with email: $email";
} else {
    // User not found in the registration table
    echo "Error: User information not found";
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Welcome</h2>
        <p>
            Welcome, <?php echo "$firstName $lastName"; ?>! You are logged in with email: <?php echo $email; ?>
        </p>
        <a href="logout.php" class="btn btn-primary">Logout</a>
    </div>
</body>
</html>
