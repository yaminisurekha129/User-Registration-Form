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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Insert the new user into the users table
    $insertQuery = "INSERT INTO users (name, email, phone) VALUES ('$name', '$email', '$phone')";
    $result = mysqli_query($con, $insertQuery);

    if ($result) {
        // User added successfully, redirect to the users page
        header("Location: users.php");
        exit;
    } else {
        $error = "Error adding user";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Add User</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="add_user.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>
</body>
</html>
