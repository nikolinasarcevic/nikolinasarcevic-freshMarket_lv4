<?php
session_start();
include 'functions.php';
$conn = connect_db();

if (isset($_POST['checkout'])) {
    $customer_name = $_POST['customer_name'];
    $customer_surname = $_POST['customer_surname'];
    $customer_address = $_POST['customer_address'];
    $cart = $_SESSION['cart'] ?? [];

    foreach ($cart as $product_id => $quantity) {
        $query = "SELECT price, amount FROM products WHERE id = $product_id";
        $result = $conn->query($query);
        $product = $result->fetch_assoc();
        $total = $product['price'] * $quantity;

        if ($quantity <= $product['amount']) {
            $order_query = "INSERT INTO orders (product_id, quantity, total, customer_name, customer_surname, customer_address) VALUES ($product_id, $quantity, $total, '$customer_name', '$customer_surname', '$customer_address')";
            $conn->query($order_query);

            $update_query = "UPDATE products SET amount = amount - $quantity WHERE id = $product_id";
            $conn->query($update_query);
        } else {
            echo "Error: Not enough stock for product ID $product_id.";
        }
    }

    unset($_SESSION['cart']);
    header("Location: thank_you.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];
$products = [];
$total = 0;

if (!empty($cart)) {
    $ids = implode(',', array_keys($cart));
    $query = "SELECT * FROM products WHERE id IN ($ids)";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $row['quantity'] = $cart[$row['id']];
        $products[] = $row;
        $total += $row['price'] * $row['quantity'];
    }
}

$totalProductsInCart = array_sum($cart);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
    <?php ?>

    <div class="checkout2">
        <h2>Checkout</h2>
        <?php if (empty($products)) : ?>
            <p>Your cart is empty.</p>
        <?php else : ?>
            <table>
                <thead class="trt">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr class="trt2">
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['quantity']; ?></td>
                            <td><?php echo $product['price']; ?>$</td>
                            <td><?php echo $product['price'] * $product['quantity']; ?>$</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="total">Total: <?php echo $total; ?>$</p>

            <form method="post" action="checkout.php">
                <label for="customer_name">First Name:</label>
                <input type="text" id="customer_name" name="customer_name" required>
                <br>
                <label for="customer_surname">Last Name:</label>
                <input type="text" id="customer_surname" name="customer_surname" required>
                <br>
                <label for="customer_address">Order address:</label>
                <input type="text" id="customer_address" name="customer_address" required>
                <br>
                <button type="submit" name="checkout" class="btn-update">Place Order</button>
            </form>
        <?php endif; ?>
        <div class="back-arrow" onclick="goBack()">
            <i class="fas fa-arrow-left"></i> Back
        </div>
    </div>
    <script>
        function goBack() {
            console.log("Back button clicked");
            window.history.back();
        }
    </script>
</body>

</html>