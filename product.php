<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Web Shop</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <?php
    include 'functions.php';

    $conn = connect_db();
    $product_id = isset($_GET['id']) ? $_GET['id'] : 1;

    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();

    ?>


    <?php include 'header.php'; ?>
    <div class="back-arrow" onclick="goBack()">
        <i class="fas fa-arrow-left"></i> Back
    </div>
    <div class="product-page">
        <h2 class="product-h2"><?php echo $product['name']; ?></h2>
        <div class="container">
            <div class="container1">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-img">
            </div>
            <div class="container2">

                <p>Price: <span><?php echo $product['price']; ?>$</span></p>
                <p>Amount: <span id="product-amount"><?php echo $product['amount']; ?></span></p>
                <p class="descr"><?php echo $product['description']; ?></p>

                <form method="post" action="cart.php" onsubmit="return validateQuantity()">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?php echo $product['amount']; ?>">
                    <br><button type="submit" name="add_to_cart" class="btn-add">Add to Cart</button>
                </form>

            </div>
        </div>

    </div>

    <script>
        function goBack() {
            console.log("Back button clicked");
            window.history.back();
        }

        function validateQuantity() {
            const quantityInput = document.getElementById('quantity');
            const maxQuantity = quantityInput.max;
            const selectedQuantity = quantityInput.value;

            if (selectedQuantity > maxQuantity) {
                alert('You cannot add more than ' + maxQuantity + ' of this product to the cart.');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>