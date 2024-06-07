<?php
session_start();
$_SESSION['totalProductsInCart'] = 0;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="thank-you">
        <h2>Thank you for your order!</h2>
        <a href="index.php" class="continue">Continue Shopping -></a>
    </div>
</body>

</html>