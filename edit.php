<?php
require 'koneksi.php';

$id = $_GET['id'];
$queryData = "SELECT * FROM buku WHERE id = '$id'";
$resultData = mysqli_query($conn, $queryData);
$buku = mysqli_fetch_assoc($resultData);

if (isset($_POST['submit'])) {
    $judul    = bersihkanInput($_POST['judul']);
    $penulis  = bersihkanInput($_POST['penulis']);
    $penerbit = bersihkanInput($_POST['penerbit']);
    $tahun    = bersihkanInput($_POST['tahun']);
     
    // Pada bagian atas file edit.php
    $query = "UPDATE buku SET judul='$judul', penulis='$penulis', penerbit='$penerbit', tahun='$tahun' WHERE id='$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: kelola.php"); // Diarahkan ke halaman kelola setelah edit
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
    <title>Edit Data - My Litle Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">My Litle Library</a>
            <ul class="nav-menu">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="kelola.php">Kelola Buku</a></li>
                <li><a href="tambah.php">Tambah Buku</a></li> 
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="form-card">
            <h2>Edit Data Buku</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" value="<?php echo $buku['judul']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" value="<?php echo $buku['penulis']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" value="<?php echo $buku['penerbit']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun" value="<?php echo $buku['tahun']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Status Baca</label>
                    <select name="status" required>
                        <option value="Belum dibaca" <?php if($buku['status'] == 'Belum dibaca') echo 'selected'; ?>>Belum dibaca</option>
                        <option value="Sedang dibaca" <?php if($buku['status'] == 'Sedang dibaca') echo 'selected'; ?>>Sedang dibaca</option>
                        <option value="Selesai dibaca" <?php if($buku['status'] == 'Selesai dibaca') echo 'selected'; ?>>Selesai dibaca</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" name="submit" class="btn btn-tambah">Update Data</button>
                    <a href="kelola.php" class="btn btn-batal">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>