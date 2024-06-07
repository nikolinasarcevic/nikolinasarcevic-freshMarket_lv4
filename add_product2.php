<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin.php');
    exit();
}
include 'functions.php';

if (isset($_POST['add_product'])) {
    $conn = connect_db();
    $name = $conn->real_escape_string($_POST['name']);
    $price = $conn->real_escape_string($_POST['price']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $description = $conn->real_escape_string($_POST['description']);
    $image = $conn->real_escape_string($_POST['image']);

    $query = "INSERT INTO products (name, price, amount, description, image) VALUES ('$name', '$price', '$amount', '$description', '$image')";
    if ($conn->query($query) === TRUE) {
        $conn->close();
        header('Location: products2.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add New Product</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
    <?php?>
    <h2 class="admin-h2">Add New Product</h2>
    <nav class="admin-nav">
        <a href="home.php">Home</a>
        <a href="products2.php">Products</a>
        <a href="orders.php">Orders</a>
        <a href="logout.php">Logout</a>

    </nav>

    <form method="post" action="add_product2.php">
        <label for="name">Name:</label>
        <input type="text" name="name" id="p_name" required><br>
        <label for="price">Price:</label>
        <input type="text" name="price" id="p_price" required><br>
        <label for="amount">Amount:</label>
        <input type="text" name="amount" id="p_amount" required><br>
        <label for="description">Description:</label>
        <textarea name="description" id="p_description" required></textarea><br>
        <label for="image">Image URL:</label>
        <input type="text" name="image" id="p_image" required>
        <button type="submit" name="add_product" class="new-btn2">Add Product</button>
    </form>
</body>

</html>