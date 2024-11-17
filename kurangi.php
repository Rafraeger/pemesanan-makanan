<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Periksa apakah produk dengan ID ini ada dalam keranjang
    if (isset($_SESSION['keranjang'][$id])) {
        // Kurangi jumlah produk dalam keranjang
        $_SESSION['keranjang'][$id]['jumlah']--;

        // Hapus produk jika jumlahnya menjadi 0
        if ($_SESSION['keranjang'][$id]['jumlah'] == 0) {
            unset($_SESSION['keranjang'][$id]);
        }
    }
}

// Redirect kembali ke halaman index.php
header("Location: index.php");
exit;
?>
