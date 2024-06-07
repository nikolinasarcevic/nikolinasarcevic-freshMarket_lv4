<?php
session_start();
include 'functions.php';

if (isset($_POST['login'])) {
    $conn = connect_db();
    $email = $_POST['email'];
    $password = hash('sha256', $_POST['password']);

    $query = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid login credentials";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <?php?>
    <h2 class="admin-h2">Admin Login</h2>
    <?php if (isset($error)) {
        echo "<p>$error</p>";
    } ?>
    <form method="post" action="" class="post-background">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="login" class="new-btn2">Login</button>
    </form>

</body>

</html>