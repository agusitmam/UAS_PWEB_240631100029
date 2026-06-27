<?php
require 'koneksi.php';

if (isset($_POST['submit'])) {
    $judul    = bersihkanInput($_POST['judul']);
    $penulis  = bersihkanInput($_POST['penulis']);
    $penerbit = bersihkanInput($_POST['penerbit']);
    $tahun    = bersihkanInput($_POST['tahun']);

    // Query INSERT diubah: otomatis memasukkan nilai 'Belum dibaca' ke kolom status
    $query = "INSERT INTO buku (judul, penulis, penerbit, tahun, status) VALUES ('$judul', '$penulis', '$penerbit', '$tahun', 'Belum dibaca')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data - My Litle Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">My Litle Library</a>
            <ul class="nav-menu">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="kelola.php">Kelola Buku</a></li>
                <li><a href="tambah.php" class="active">Tambah Buku</a></li> 
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="form-card">
            <form action="" method="POST">
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" required placeholder="Masukkan judul...">
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" required placeholder="Nama penulis...">
                </div>
                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" required placeholder="Nama penerbit...">
                </div>
                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun" required placeholder="Contoh: 2024">
                </div>
                
                <div class="form-actions">
                    <button type="submit" name="submit" class="btn btn-tambah">Simpan Data</button>
                    <a href="index.php" class="btn btn-batal">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>