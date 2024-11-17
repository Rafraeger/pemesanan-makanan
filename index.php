<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
require 'functions.php';

$conn = mysqli_connect("localhost", "root", "", "kantin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$menu_query = mysqli_query($conn, "SELECT * FROM menu_produk");

if (!$menu_query) {
    die("Query failed: " . mysqli_error($conn));
}

$menu_produk = mysqli_fetch_all($menu_query, MYSQLI_ASSOC);

// Fungsi untuk mengelola keranjang belanja
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id_produk = $_GET['barang'];
    $jumlah = $_POST['jumlah'];

    // Cek apakah produk sudah ada di keranjang
    if (isset($_SESSION['keranjang'][$id_produk])) {
        // Produk sudah ada, tambahkan jumlahnya
        $_SESSION['keranjang'][$id_produk]['jumlah'] += $jumlah;
    } else {
        // Produk belum ada di keranjang, tambahkan produk baru
        $_SESSION['keranjang'][$id_produk] = [
            'id_produk' => $id_produk,
            'nama' => $_GET['nama'],
            'harga' => $_GET['harga'],
            'jumlah' => $jumlah
        ];
    }
}

// Mengurangi jumlah item dalam keranjang
if (isset($_GET['action']) && $_GET['action'] == 'decrease') {
    $id_produk = $_GET['barang'];

    // Cek apakah produk ada dalam keranjang
    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk]['jumlah']--;

        // Hapus item jika jumlahnya menjadi 0
        if ($_SESSION['keranjang'][$id_produk]['jumlah'] <= 0) {
            unset($_SESSION['keranjang'][$id_produk]);
        }
    }
}

// Set variabel sesi 'keranjang_kosong' jika keranjang belanja kosong
if (empty($_SESSION['keranjang'])) {
    $_SESSION['keranjang_kosong'] = true;
} else {
    unset($_SESSION['keranjang_kosong']);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENU KANTIN</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

header {
    background-color: #213627;
    color: white;
    padding: 10px 0;
    text-align: center;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    font-size: 24px;
}

.product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.product {
    width: calc(40% - 20px); 
    margin: 10px;
    padding: 10px;
    background-color: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.9);
    text-align: center;
}

.product img {
    max-width: 100%;
    height: auto;
    border-radius: 10%;
    box-shadow: 0 8px 10px rgba(0, 0, 0, 0.3);
    border: 3px solid rgba(0, 0, 0, 0.6);
}

.product strong {
    display: block;
    margin-top: 10px;
    font-size: 18px;
}

.product form {
    margin-top: 10px;
}

.product form input[type="number"] {
    width: 50px;
}

.product form input[type="submit"] {
    background-color: #839284;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}

h2 {
    margin-top: 20px;
    font-size: 20px;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

table th {
    background-color: #333;
    color: white;
}

a {
    display: block;
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
    color: #333;
    background-color: #f0f0f0;
    padding: 10px;
    border: 1px solid #ddd;
    font-weight: bold;
}

.checkout-button {
    background-color: #333;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 18px;
    margin-top: 20px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.checkout-button:hover {
    background-color: #555;
}
    </style>
</head>
<body>
<header>
    <img src="img/logo.jpg" alt="Mercu Buana Logo" width="100">
    <h1>MENU </h1>
    <?php if(isset($_SESSION['username'])): ?>
        <p>Halo, Selamat datang  <?php echo $_SESSION['username']; ?>!</p>
    <?php endif; ?>
    <a href="riwayat_pembayaran.php">Riwayat</a>
</header>

    <div class="container">
        <div class="product-container">
            <?php foreach ($menu_produk as $produk) { ?>
                <div class="product">
                    <img src="img/<?php echo $produk['gambar_produk']; ?>" alt="<?php echo $produk['nama_produk']; ?>" width="200">
                    <br>
                    <strong><?php echo $produk['nama_produk']; ?></strong> - Rp. <?php echo $produk['harga_produk']; ?>
                    <br>
                    <?php echo $produk['deskripsi_produk']; ?>
                    <br>
                    <form action="index.php?action=add&barang=<?php echo $produk['id_produk']; ?>&nama=<?php echo $produk['nama_produk']; ?>&harga=<?php echo $produk['harga_produk']; ?>" method="post">
                        Jumlah: <input type="number" name="jumlah" value="1" min="1">
                        <input type="submit" value="Beli">
                    </form>
                </div>
            <?php } ?>
    </div>
    <h2>Keranjang Belanja</h2>
    <form action="pembayaran.php" method="post">
        <table>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Persatu Barang</th>
                <th>Kurangi</th>
            </tr>
            <?php
            if (isset($_SESSION['keranjang'])) {
                foreach ($_SESSION['keranjang'] as $id_produk => $barang) {
                    echo "<tr>";
                    echo "<td>{$barang['nama']}</td>";
                    echo "<td>{$barang['jumlah']}</td>";
                    echo "<td>Rp. {$barang['harga']}</td>";
                    echo "<td><a href='index.php?action=decrease&barang={$barang['id_produk']}'>Kurangi</a></td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
        <input type="submit" class="checkout-button" value="Checkout">
    </form>
    <hr>
    <br>
    <a href="logout.php">Logout</a>
    <br>
    <br>
    <br>
    </div>
</body>
</html>