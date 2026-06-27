<?php
require 'koneksi.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM buku WHERE id = '$id'";
    
    if(mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>