<?php 
session_start();
include '../config/koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login sebagai Admin</title>

<link rel="stylesheet" href="../asset/css/loginadmin.css">

</head>
<body>

<form method="POST">
    <h3>Login sebagai Admin</h3>
    <input type="text" name="user" placeholder="ID User" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>

<?php
if (isset($_POST['login'])) {
    $id_user = $_POST['user'];
    $password_user = ($_POST['password']); 

    // Query sesuai dengan di database
    $query = $conn->query("SELECT * FROM user 
                           WHERE id_user='$id_user' 
                           AND password_user='$password_user'");

    if ($query->num_rows > 0) {
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $id_user;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('ID User atau Password salah!');</script>";
    }
}
?>
</body>
</html>