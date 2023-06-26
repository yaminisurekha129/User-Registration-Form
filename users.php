<?php
session_start();

// Check if the admin is logged in, if not redirect to the admin login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Include the database connection
include 'connect1.php';

// Pagination
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$start = ($page - 1) * $limit; // Starting index for records

// Sorting
$sortField = isset($_GET['sortField']) ? $_GET['sortField'] : 'name'; // Field to sort by
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc'; // Sort order (asc/desc)

// Search filter
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query to fetch users with pagination, sorting, and search filter
$query = "SELECT * FROM users ";
if (!empty($search)) {
    $query .= "WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' ";
}
$query .= "ORDER BY $sortField $sortOrder LIMIT $start, $limit";

$result = mysqli_query($con, $query);

// Count total number of records
$totalRecordsQuery = "SELECT COUNT(*) as total FROM users";
$totalRecordsResult = mysqli_query($con, $totalRecordsQuery);
$totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $limit);

// Get the current page URL
$currentPageURL = $_SERVER['REQUEST_URI'];

// Function to generate table rows for users
function generateTableRows($result)
{
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['phone']}</td>";
            echo "<td><a href='edit_user.php?id={$row['id']}' class='btn btn-primary'>Edit</a></td>";
            echo "<td><a href='delete_user.php?id={$row['id']}' class='btn btn-danger'>Delete</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No users found</td></tr>";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Users</h2>
        <div class="mb-3">
            <a href="add_user.php" class="btn btn-primary">Add User</a>
        </div>
        <div class="mb-3">
            <form action="users.php" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by name, email, or phone"
                           value="<?php echo $search; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th><a href="<?php echo "$currentPageURL&sortField=name&sortOrder=" . ($sortField === 'name' && $sortOrder === 'asc' ? 'desc' : 'asc'); ?>">Name</a></th>
                <th><a href="<?php echo "$currentPageURL&sortField=email&sortOrder=" . ($sortField === 'email' && $sortOrder === 'asc' ? 'desc' : 'asc'); ?>">Email</a></th>
                <th><a href="<?php echo "$currentPageURL&sortField=phone&sortOrder=" . ($sortField === 'phone' && $sortOrder === 'asc' ? 'desc' : 'asc'); ?>">Phone</a></th>
                <th>Actions</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php generateTableRows($result); ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <?php if ($totalPages > 1): ?>
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo "$currentPageURL&page=" . ($page - 1); ?>">Previous</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo "$currentPageURL&page=$i"; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo "$currentPageURL&page=" . ($page + 1); ?>">Next</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>
</html>
