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

// Fetch user data from the users table based on the user ID
$sql = "SELECT * FROM users WHERE id = '$userId' LIMIT 1";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);

// Check if the user exists
if (!$user) {
    header("Location: users.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update the user details in the users table
    $updateQuery = "UPDATE users SET name = '$name', email = '$email', phone = '$phone' WHERE id = '$userId'";
    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        // User updated successfully, redirect to the users page
        header("Location: users.php");
        exit;
    } else {
        $error = "Error updating user";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="edit_user.php?id=<?php echo $userId; ?>" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</body>
</html>
