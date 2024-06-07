<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin.php');
    exit();
}
include 'functions.php';
$conn = connect_db();

$query = "SELECT * FROM products";
$result = $conn->query($query);
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Products</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
    <h2 class="admin-h2">Manage Products</h2>
    <nav class="admin-nav">
        <a href="home.php">Home</a>
        <a href="products2.php">Products</a>
        <a href="orders.php">Orders</a>
        <a href="logout.php">Logout</a>

    </nav>

    <h3>All Products</h3>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Amount</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="50"></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['price']; ?>$</td>
                    <td><?php echo $product['amount']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="add_product2.php"><button class="new-btn">Add New Product</button></a>
</body>

</html>