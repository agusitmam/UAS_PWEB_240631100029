<?php 
require 'koneksi.php'; 

// === LOGIKA TAMBAH BUKU DARI POP-UP ===
if (isset($_POST['submit_tambah'])) {
    $judul    = bersihkanInput($_POST['judul']);
    $penulis  = bersihkanInput($_POST['penulis']);
    $penerbit = bersihkanInput($_POST['penerbit']);
    $tahun    = bersihkanInput($_POST['tahun']);

    $query = "INSERT INTO buku (judul, penulis, penerbit, tahun, status) VALUES ('$judul', '$penulis', '$penerbit', '$tahun', 'Belum dibaca')";
    mysqli_query($conn, $query);
    
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Litle Library - Beranda</title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">My Litle Library</a>
            <ul class="nav-menu">
                <li><a href="index.php" class="active">Beranda</a></li> 
                <li><a href="kelola.php">Kelola Buku</a></li>
                <li><a href="#" onclick="bukaModal('modalTambah')">Tambah Buku</a></li> 
            </ul>
        </div>
    </nav>

    <div class="container">
        <header class="welcome-section">
            <div class="welcome-text">
                <h1>Daftar BukuKu</h1>
                <p>Bacalah aku...</p>
            </div>
        </header>

        <section id="daftar-buku" class="data-section">
            <div class="data-header">
                <h2>List BukuMu</h2>
                <div class="total-text">
                    Total: <strong><?php echo hitungTotalBuku($conn); ?></strong> buku
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>JUDUL BUKU</th>
                        <th>PENULIS</th>
                        <th>PENERBIT</th>
                        <th>TAHUN</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = "SELECT * FROM buku ORDER BY id DESC";
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result) > 0) { 
                        while($row = mysqli_fetch_assoc($result)) { 
                            $status_class = '';
                            if($row['status'] == 'Belum dibaca') $status_class = 'status-belum';
                            elseif($row['status'] == 'Sedang dibaca') $status_class = 'status-sedang';
                            elseif($row['status'] == 'Selesai dibaca') $status_class = 'status-selesai';
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><strong><?php echo $row['judul']; ?></strong></td>
                        <td><?php echo $row['penulis']; ?></td>
                        <td><?php echo $row['penerbit']; ?></td>
                        <td><span class="badge-tahun"><?php echo $row['tahun']; ?></span></td>
                        <td><span class="badge-status <?php echo $status_class; ?>"><?php echo $row['status'] ?? 'Belum dibaca'; ?></span></td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center; padding: 20px; color: #a3aed1;'>Belum ada data buku tersimpan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <div id="modalTambah" class="modal">
        <div class="modal-content form-card">
            <h2>Tambah Buku Baru</h2>
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
                    <button type="submit" name="submit_tambah" class="btn btn-tambah">Simpan Data</button>
                    <button type="button" class="btn btn-batal" onclick="tutupModal('modalTambah')">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bukaModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
            document.body.classList.add('modal-open');
        }
        function tutupModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.classList.remove('modal-open');
        }
    </script>
</body>
</html>