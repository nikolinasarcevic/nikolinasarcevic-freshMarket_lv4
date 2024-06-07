<?php
include 'functions.php';
include 'header.php';

$conn = connect_db();
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM products LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <?php?>
    <h2 class="all-h2">All Products</h2>
    <?php?>
    <div class="back-arrow" onclick="goBack()">
        <i class="fas fa-arrow-left"></i> Back
    </div>
    <div class="products">
        <div class="product-list">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="product">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <h3><?php echo $row['name']; ?></h3>
                    <p><?php echo $row['price']; ?>$</p>
                    <p>Amount: <?php echo $row['amount']; ?></p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">View Product</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php
    $result_total = $conn->query("SELECT COUNT(*) AS total FROM products");
    $total = $result_total->fetch_assoc()['total'];
    $total_pages = ceil($total / $limit);
    ?>
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