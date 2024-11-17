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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran</title>
    <style>
        /* CSS Anda bisa menambah atau memodifikasinya di sini */
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

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
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
    </style>
</head>
<body>
    <header>
        <h1>RIWAYAT PEMBAYARAN</h1>
    </header>
    <div class="container">
        <?php
        if (isset($_SESSION['login'])) {
            // Ambil nama akun dari sesi
            $nama_akun = $_SESSION['username'];

            // Query untuk mengambil riwayat pembayaran berdasarkan username
            $sql = "SELECT * FROM pembayaran WHERE username = '$nama_akun' ORDER BY waktu_pemesanan DESC";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Nama Pembeli</th><th>Total Harga</th><th>Status</th><th>Waktu Pemesanan</th><th>Bukti Pembayaran</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id_pembayaran'] . "</td>";
                    echo "<td>" . $row['nama_barang'] . "</td>";
                    echo "<td>Rp. " . $row['total_harga'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['waktu_pemesanan'] . "</td>";
                    echo "<td><img src='uploads/{$row['bukti_pembayaran']}' alt='Bukti Pembayaran' width='180'></td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Riwayat pembayaran kosong.</p>";
            }
        } else {
            echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
        }
        ?>
        <a href="index.php">Kembali ke Menu Kantin</a>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
