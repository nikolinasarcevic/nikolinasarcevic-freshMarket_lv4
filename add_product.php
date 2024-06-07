<?php
include 'functions.php';

if (!isset($_SESSION['admin'])) {
    header('Location: admin.php');
    exit;
}

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    $target = 'imgs/' . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $conn = connect_db();
    $query = "INSERT INTO products (name, price, quantity, description, image) VALUES ('$name', '$price', '$quantity', '$description', '$image')";
    $conn->query($query);

    header('Location: dashboard.php');
    exit;
}
?>

<div class="add-product">
    <h2>Add New Product</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" required>

        <button type="submit" name="add_product">Add Product</button>
    </form>
</div>