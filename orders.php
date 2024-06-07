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
$query = "SELECT customer_name, customer_surname, customer_address, product_id, total FROM orders";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="orders">
        <h2>Orders</h2>
        <div class="back-arrow" onclick="goBack()">
            <i class="fas fa-arrow-left"></i> Back
        </div>
        <?php if ($result->num_rows > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Address</th>
                        <th>Products</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['customer_surname']); ?></td>
                            <td><?php echo htmlspecialchars($row['customer_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['total']); ?>$</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>