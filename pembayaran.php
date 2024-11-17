<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

// Ambil nama pengguna dari sesi
$nama_pembeli = $_SESSION['username'];

// Periksa apakah keranjang belanja kosong
if (isset($_SESSION['keranjang_kosong']) && $_SESSION['keranjang_kosong'] === true) {
    // Keranjang belanja kosong, redirect ke index.php atau berikan pesan yang sesuai
    header('Location: index.php');
    exit;
}

$total_harga = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $barang) {
            $total_harga += $barang['harga'] * $barang['jumlah'];
        }
    }
}

if($total_harga == 0)
{
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
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

        h1 {
            text-align: center;
            font-size: 24px;
        }

        p {
            text-align: center;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #333;
            color: white;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 10px;
        }

        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            resize: vertical; 
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #555;
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
        
        .payment{
            height: 50px;
            width: 50px;
            margin-left: 65px;
        }

        .container{
            display: flex;
            /* margin-left: auto;
            margin-right: auto;
            width: 50%; */
        }

        .norek{
            margin-left: 40px;
        }
    </style>
</head>
<body>
    <header>
        <h1>PEMBAYARAN</h1>
        <?php if(isset($nama_pembeli)): ?>
            <p>Halo, Selamat datang <?php echo $nama_pembeli; ?>!</p>
        <?php endif; ?>
    </header>
    <form action="proses_pembayaran.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
            <?php
            if (isset($_SESSION['keranjang'])) {
                foreach ($_SESSION['keranjang'] as $barang) {
                    echo "<tr>";
                    echo "<td>{$barang['nama']}</td>";
                    echo "<td>{$barang['jumlah']}</td>";
                    echo "<td>Rp. {$barang['harga']}</td>";
                    echo "</tr>";
                }
            }
            ?>
            <tr>
                <th colspan="2">Total Harga:</th>
                <td colspan="2">Rp. <?php echo $total_harga; ?></td>
            </tr>
        </table>
        <br>
        <label for="">Menerima pembayaran melalui : </label><br>
        <div class="container">
        
        <div class="">
            <img src="./img/bca.png" alt="" class="payment">
            <label for="" class="norek">1270187645</label>
        </div>
        <div class="">
            <img src="./img/dana.png" alt="" class="payment">
            <label for="" class="norek">08966822845</label>
        </div>
        <div class="">
            <img src="./img/shopee.png" alt="" class="payment">
            <label for="" class="norek">08966822845</label>
        </div><div class="">
            <img src="./img/gopay.png" alt="" class="payment">
            <label for="" class="norek">08966822845</label>
        </div>
        </div>
        
        <h2>Informasi Pembayaran</h2>
        <label for="nama_pembeli">Nama Pembeli:</label>
        <input type="text" id="nama_pembeli" name="nama_pembeli" required>
        <br>
        <label for="catatan_pembelian">Catatan Pembeli:</label>
        <textarea id="catatan" name="catatan" rows="4" cols="50"></textarea> 
        <br>
        <label for="bukti_pembayaran">Bukti Pembayaran (Gambar):</label>
        <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" required>
        <br>
        <input type="submit" value="Bayar">
    </form>
    <br>
   
    <br>
    <a href="index.php" onclick="kembaliKeMenuKantin();">Kembali ke Menu Kantin</a>

    <script>
        function kembaliKeMenuKantin() {
            // Fungsi JavaScript untuk mengembalikan ke halaman Menu Kantin
        }
    </script>
</body>
</html>