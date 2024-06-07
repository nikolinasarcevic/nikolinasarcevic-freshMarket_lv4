<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Web Shop</title>
    <link rel="stylesheet" type="text/css" href="style2.css">

</head>

</html>

<?php

$conn = connect_db();

$query = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
$result = $conn->query($query);

if ($result === false) {
    echo "Error executing query: " . $conn->error;
} else {
    echo "<h2 class='recent'>New offer</h2>";

    echo "<div class='products'>";
    echo "<div class='product-list'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>" . $row['price'] . "$</p>";
        echo "<p>Amount: " . $row['amount'] . "</p>";

        echo "<a href='product.php?id=" . $row['id'] . "'>View Product</a>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
}

$conn->close();
