<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "kantin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set zona waktu PHP
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pembeli = $_POST["nama_pembeli"];
    $total_harga = 0;
    $bukti_pembayaran = "";
    $barang_dipesan = "";
    $catatan = $_POST["catatan"];

    if (isset($_SESSION['keranjang'])) {
        foreach ($_SESSION['keranjang'] as $barang) {
            $total_harga += $barang['harga'] * $barang['jumlah'];
            $barang_dipesan .= "{$barang['jumlah']} {$barang['nama']}, ";
        }
        // Hapus koma dan spasi ekstra di akhir string
        $barang_dipesan = rtrim($barang_dipesan, ', ');
    }
    
    // Ambil nama akun (bukan nama pembeli) dari sesi
    $nama_akun = $_SESSION['username'];

    if (isset($_FILES["bukti_pembayaran"]) && $_FILES["bukti_pembayaran"]["error"] === 0) {
        // Generate nama file yang unik dengan timestamp
        $timestamp = time();
        $bukti_pembayaran = $timestamp . '_' . $_FILES["bukti_pembayaran"]["name"];
    
        $upload_dir = "uploads/";
        $target_file = $upload_dir . $bukti_pembayaran;
    
        if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
            // Tambahkan kolom waktu_pemesanan ke dalam query SQL
            $sql = "INSERT INTO pembayaran (username, nama_barang, total_harga, bukti_pembayaran, status, barang_dipesan, catatan, waktu_pemesanan) VALUES ('$nama_akun', '$nama_pembeli', $total_harga, '$bukti_pembayaran', 'Belum Selesai', '$barang_dipesan', '$catatan', NOW())";
    
            if (mysqli_query($conn, $sql)) {
                unset($_SESSION['keranjang']);
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Upload bukti pembayaran gagal.";
        }
    } else {
        echo "Bukti pembayaran tidak diunggah atau terdapat kesalahan.";
    }

    mysqli_close($conn);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        h1 {
            text-align: center;
            font-size: 24px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .success-message {
            text-align: center;
            font-size: 18px;
            color: #4CAF50;
            margin-top: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
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
        }
    </style>
</head>
<body>
    <header>
        <h1>Status Pembayaran</h1>
    </header>
    <div class="container">
        <?php
        if (isset($_SESSION['login'])) {
            echo "<h2>Upload bukti pembayaran sukses, pesanan sedang diproses</h2>";

            // Tampilkan informasi pembayaran dari database
            $conn = mysqli_connect("localhost", "root", "", "kantin");
            if ($conn) {
                $sql = "SELECT * FROM pembayaran ORDER BY id_pembayaran DESC LIMIT 1";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<p><img src='uploads/{$row['bukti_pembayaran']}' alt='Bukti Pembayaran' width='350'></p>";
                    echo "<p>Bukti Pembayaran: " . $row['bukti_pembayaran'] . "</p>";
                    echo "<p>ID Pembayaran: " . $row['id_pembayaran'] . "</p>";
                    echo "<p>Nama Akun: " . $row['username'] . "</p>";
                    echo "<p>Nama Pembeli: " . $row['nama_barang'] . "</p>";
                    echo "<p>Total Harga: Rp. " . $row['total_harga'] . "</p>";
                    echo "<p>Barang Dipesan: " . $row['barang_dipesan'] . "</p>";
                    echo "<p>Catatan: " . $row['catatan'] . "</p>";
                    echo "<p>Waktu Pemesanan: " . $row['waktu_pemesanan'] . "</p>";
                } else {
                    echo "Tidak ada informasi pembayaran yang ditemukan.";
                }

                mysqli_close($conn);
            } else {
                echo "Gagal terhubung ke database.";
            }
        } else {
            echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
        }
        ?>
        <a href="index.php" onclick="kembaliKeMenuKantin(); ">Kembali ke Menu Kantin</a>
    </div>

    <script>
        function kembaliKeMenuKantin() {
            // Fungsi JavaScript untuk mengembalikan ke halaman Menu Kantin
        }
    </script>
</body>
</html>