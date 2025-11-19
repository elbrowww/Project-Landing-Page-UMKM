<?php 
session_start();
include '../config/koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login sebagai Admin</title>

<link rel="icon" href="../asset/img/logo.png" type="image/x-icon">
<link rel="stylesheet" href="../asset/css/loginadmin.css">

<?php
if (isset($_POST['login'])) {
    $id_user = $_POST['user'];
    $password = ($_POST['password']); 

    // Query sesuai dengan di database
    $query = $koneksi->query("SELECT * FROM user 
                           WHERE id_user='$id_user' 
                           AND password='$password'");

    if ($query->num_rows > 0) {
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $id_user;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('ID User atau Password salah!');</script>";
    }
}
?>

</head>
<body>

   <div class="login-container">
        <div class="login-box">
            <div class="logo">
                <div class="logo-content">
                    <img src="../asset/img/logo-nobg.png" alt="Dapur Bu Mon Logo" class="logo-img">
                    <div class="logo-text">
                        <h1>Dapur Bu Mon</h1>
                        <p>Admin Dashboard</p>
                    </div>
                </div>
            </div>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="user" placeholder="Masukkan username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input pattern=".{8,}" type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>
   
                <button type="submit" class="btn-login" name="login">Masuk</button>
                

            </form>
        </div>
    </div>

</body>
</html>