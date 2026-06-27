<?php 
require 'koneksi.php'; 

// === LOGIKA UPDATE STATUS INLINE ===
if (isset($_POST['update_status'])) {
    $id_buku = $_POST['id_buku'];
    $status_baru = $_POST['status'];
    mysqli_query($conn, "UPDATE buku SET status='$status_baru' WHERE id='$id_buku'");
    header("Location: kelola.php");
    exit;
}

// === LOGIKA TAMBAH BUKU ===
if (isset($_POST['submit_tambah'])) {
    $judul    = bersihkanInput($_POST['judul']);
    $penulis  = bersihkanInput($_POST['penulis']);
    $penerbit = bersihkanInput($_POST['penerbit']);
    $tahun    = bersihkanInput($_POST['tahun']);
    mysqli_query($conn, "INSERT INTO buku (judul, penulis, penerbit, tahun, status) VALUES ('$judul', '$penulis', '$penerbit', '$tahun', 'Belum dibaca')");
    header("Location: kelola.php");
    exit;
}

// === LOGIKA EDIT BUKU ===
if (isset($_POST['submit_edit'])) {
    $id       = $_POST['id_edit'];
    $judul    = bersihkanInput($_POST['judul']);
    $penulis  = bersihkanInput($_POST['penulis']);
    $penerbit = bersihkanInput($_POST['penerbit']);
    $tahun    = bersihkanInput($_POST['tahun']);
    mysqli_query($conn, "UPDATE buku SET judul='$judul', penulis='$penulis', penerbit='$penerbit', tahun='$tahun' WHERE id='$id'");
    header("Location: kelola.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - My Litle Library</title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">My Litle Library</a>
            <ul class="nav-menu">
                <li><a href="index.php">Beranda</a></li> 
                <li><a href="kelola.php" class="active">Kelola Buku</a></li>
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

        <section class="data-section">
            <div class="data-header">
                <h2>Manajemen Data Buku</h2>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>JUDUL BUKU</th>
                        <th>PENULIS</th>
                        <th>TAHUN</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
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
                        <td><span class="badge-tahun"><?php echo $row['tahun']; ?></span></td>
                        
                        <td>
                            <form action="" method="POST" style="margin: 0;">
                                <input type="hidden" name="update_status" value="1">
                                <input type="hidden" name="id_buku" value="<?php echo $row['id']; ?>">
                                <select name="status" class="status-dropdown <?php echo $status_class; ?>" onchange="this.form.submit()">
                                    <option value="Belum dibaca" <?php if($row['status'] == 'Belum dibaca') echo 'selected'; ?>>Belum dibaca</option>
                                    <option value="Sedang dibaca" <?php if($row['status'] == 'Sedang dibaca') echo 'selected'; ?>>Sedang dibaca</option>
                                    <option value="Selesai dibaca" <?php if($row['status'] == 'Selesai dibaca') echo 'selected'; ?>>Selesai dibaca</option>
                                </select>
                            </form>
                        </td>

                        <td>
                            <button type="button" class="btn btn-edit" 
                                onclick="bukaModalEdit('<?php echo $row['id']; ?>', '<?php echo addslashes($row['judul']); ?>', '<?php echo addslashes($row['penulis']); ?>', '<?php echo addslashes($row['penerbit']); ?>', '<?php echo $row['tahun']; ?>')">
                                Edit
                            </button>
                            <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-hapus" onclick="return confirm('Hapus buku ini?')">Hapus</a>
                        </td>
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

    <div id="modalEdit" class="modal">
        <div class="modal-content form-card">
            <h2>Edit Data Buku</h2>
            <form action="" method="POST">
                <input type="hidden" name="id_edit" id="edit_id"> <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" id="edit_judul" required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" id="edit_penulis" required>
                </div>
                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" id="edit_penerbit" required>
                </div>
                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun" id="edit_tahun" required>
                </div>
                <div class="form-actions">
                    <button type="submit" name="submit_edit" class="btn btn-tambah">Update Data</button>
                    <button type="button" class="btn btn-batal" onclick="tutupModal('modalEdit')">Batal</button>
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

        // Fungsi khusus untuk Pop-up Edit (Memasukkan data ke form secara otomatis)
        function bukaModalEdit(id, judul, penulis, penerbit, tahun) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_judul').value = judul;
            document.getElementById('edit_penulis').value = penulis;
            document.getElementById('edit_penerbit').value = penerbit;
            document.getElementById('edit_tahun').value = tahun;
            
            bukaModal('modalEdit');
        }
    </script>
</body>
</html>