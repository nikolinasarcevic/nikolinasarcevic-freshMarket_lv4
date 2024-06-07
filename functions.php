<?php
function connect_db()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "shoppingcart";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
