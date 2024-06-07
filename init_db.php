<?php
function connect_db()
{
    $servername = "localhost";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

$conn = connect_db();

$sql = "CREATE DATABASE IF NOT EXISTS shoppingcart";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

$conn->select_db("shoppingcart");

$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    amount INT,
    image VARCHAR(255) NOT NULL,
    description TEXT
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'products' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

$sql = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_surname VARCHAR(255) NOT NULL,
    customer_address VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'orders' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

$sql = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'admins' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

$sql = "INSERT INTO products (name, price, image, amount, description) VALUES
('Ananas', 2, 'images/ananas.jpg', 10, 'Juicy tropical fruit with a sweet and tangy flavor.'),
('Orange', 5, 'images/naranca.jpg', 12, 'Refreshing citrus fruit packed with vitamin C and a staple ingredient in many juices.'),
('Kiwi', 6, 'images/kivi.jpg', 8, 'Small, green fruit with a fuzzy brown skin and juicy, tart flesh.'),
('Strawberries', 6.99, 'images/jagode.jpg', 40, 'Red, juicy berries filled with sweetness and an intense fruity flavor.'),
('Apple', 1.99, 'images/jabuka.jpg', 20, 'Classic fruit with a crispy texture and a mildly sweet taste.'),
('Pear', 3.99, 'images/kruska.jpg', 15, 'Juicy fruit with a smooth, green or brown skin and sweet flesh.'),
('Peach', 5, 'images/breskve.jpg', 12, 'Soft, juicy fruit with a delicate skin, distinctive aroma, and sweet-tart flavor.'),
('Lemon', 1.5, 'images/limun.jpg', 25, 'Sour citrus fruit with yellow, thick skins and fresh juice often used for flavoring dishes and drinks.')
";
if ($conn->query($sql) === TRUE) {
    echo "Sample products inserted successfully\n";
} else {
    echo "Error inserting products: " . $conn->error . "\n";
}

$adminEmail = 'admin@admin.com';
$adminPassword = hash('sha256', 'admin123');

$sql = "INSERT INTO admins (email, password) VALUES ('$adminEmail', '$adminPassword') ON DUPLICATE KEY UPDATE email=email";
if ($conn->query($sql) === TRUE) {
    echo "Admin account created successfully\n";
} else {
    echo "Error creating admin account: " . $conn->error . "\n";
}

$conn->close();
