<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_buku";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi 1: Membersihkan input form (mencegah karakter berbahaya)
function bersihkanInput($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// Fungsi 2: Menghitung total buku yang ada di database
function hitungTotalBuku($conn) {
    $query = "SELECT COUNT(id) as total FROM buku";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}
?>
