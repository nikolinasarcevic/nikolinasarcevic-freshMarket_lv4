<?php
include 'functions.php';
include 'header.php';

include '4products.php';
include 'all.php';



$conn = connect_db();


$query = "SELECT * FROM products";
$result = $conn->query($query);


$conn->close();
