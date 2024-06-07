<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['totalProductsInCart'])) {
    $_SESSION['totalProductsInCart'] = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Web Shop</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <nav class="navbar">
        <div class="logo-container">
            <img src="images/logo2.png" class="logo">
        </div>
        <div class="nav-right">
            <div class="cart-container">
                <a href="cart.php">
                    <button class="cart-button">Cart <img src="images/cart_icon.png" class="cart_icon"> 
                        <?php if (isset($_SESSION['totalProductsInCart'])) : ?>
                            <span class="cart-badge"><?php echo $_SESSION['totalProductsInCart']; ?></span> 
                        <?php endif; ?>
                    </button>
                </a>
            </div>
        </div>
    </nav>
</body>

</html>
