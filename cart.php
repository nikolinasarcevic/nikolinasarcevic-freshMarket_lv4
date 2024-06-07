<?php
include 'functions.php';
include 'header.php';

$conn = connect_db();

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $query = "SELECT amount FROM products WHERE id = $product_id";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();
    $available_amount = $product['amount'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $new_quantity = $_SESSION['cart'][$product_id] + $quantity;
    } else {
        $new_quantity = $quantity;
    }

    if ($new_quantity <= $available_amount) {
        $_SESSION['cart'][$product_id] = $new_quantity;
    } else {
        echo "Error: Cannot add more than the available amount.";
    }
}

if (isset($_POST['update_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $query = "SELECT amount FROM products WHERE id = $product_id";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();
    $available_amount = $product['amount'];

    if ($quantity <= $available_amount) {
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    } else {
        echo "Error: Cannot update to more than the available amount.";
    }
}

if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
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
$_SESSION['totalProductsInCart'] = $totalProductsInCart;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="cart">
        <h2 class="cart-h2">Your Cart</h2>
        <?php if (empty($products)) : ?>
            <p>Your cart is empty.</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?php echo $product['name']; ?></td>
                            <td>
                                <form method="post" action="cart.php" class="forma">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="1">
                                    <button type="submit" name="update_cart" class="btn-update">Update</button>
                                </form>
                            </td>
                            <td><?php echo $product['price']; ?>$</td>
                            <td><?php echo $product['price'] * $product['quantity']; ?>$</td>
                            <td>
                                <form method="post" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" name="remove_from_cart" class="btn-update2">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="total">Total: <?php echo $total; ?>$</p>
            <a href="checkout.php" class="checkout">Cofirm order</a>
        <?php endif; ?>
        <div class="back-arrow" onclick="goBack()">
            <i class="fas fa-arrow-left"></i> Back
        </div>
    </div>
    <div class="modal" id="miniCart">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="cart-title">Cart</h2>
            <ul class="cart-items">
                <?php foreach ($products as $product) : ?>
                    <li>
                        <?php echo $product['name']; ?> - <?php echo $product['price']; ?>$ x <?php echo $product['quantity']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p>Total: <span class="cart-total"><?php echo $total; ?>$</span></p>
            <div class="buy-mess" style="display: none;">
                You have successfully purchased the items!
            </div>
            <button class="buy-btn" onclick="goToCartPage()">Kupi sad</button>
        </div>
    </div>

    <script>
        function goBack() {
            console.log("Back button clicked");
            window.history.back();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var cartBadge = document.querySelector('.cart-badge');
            if (cartBadge) {
                cartBadge.textContent = <?php echo $totalProductsInCart; ?>;

            }

        });
    </script>
</body>

</html>