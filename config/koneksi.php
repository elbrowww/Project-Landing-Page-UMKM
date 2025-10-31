<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "database_bu_mon"; // nama database sesuai permintaan

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika juga butuh PDO
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>