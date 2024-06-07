<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin.php');
    exit();
}
if (isset($_COOKIE['admin_logged_in']) && $_COOKIE['admin_logged_in'] === true) {
    $_SESSION['admin_logged_in'] = true;
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
    <?php?>
    <h2 class="admin-h2">Welcome to Admin Dashboard</h2>

    <nav class="admin-nav">
        <a href="home.php">Home</a>
        <a href="products2.php">Products</a>
        <a href="orders.php">Orders</a>
        <a href="logout.php">Logout</a>

    </nav>

</body>

</html>