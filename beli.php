<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['barang'], $_GET['nama'], $_GET['harga'])) {
    $barang = $_GET['barang'];
    $nama_barang = $_GET['nama'];
    $harga_barang = $_GET['harga'];
} else {

    header('Location: index.php');
    exit;
}

$jumlah = 1;

if (isset($_SESSION['keranjang'][$barang])) {
    $jumlah = $_SESSION['keranjang'][$barang]['jumlah'] + 1;
}

$_SESSION['keranjang'][$barang] = [
    'nama' => $nama_barang,
    'harga' => $harga_barang,
    'jumlah' => $jumlah,
    'catatan' => '',
];

header("Location: index.php");
?>
