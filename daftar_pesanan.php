<?php
session_start();

// Periksa apakah session seller_id telah diatur
if (!isset($_SESSION['seller_id'])) {
    header("Location: umbkantin_login_seller.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "kantin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set jumlah item per halaman
$items_per_page = 5;

// Tentukan halaman saat ini
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Urutan tabel (default: ascending)
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'ASC';

// Tombol Refresh
if (isset($_POST['refresh'])) {
    header("Location: daftar_pesanan.php");
    exit;
}

// Query untuk mengambil data pesanan dengan pembagian halaman
$start_from = ($current_page - 1) * $items_per_page;

// Query untuk menghitung total item yang cocok dengan kriteria pencarian
$count_query = "SELECT COUNT(*) AS total_items FROM pembayaran 
                WHERE nama_barang LIKE '%$search%' 
                OR status LIKE '%$search%' 
                OR id_pembayaran LIKE '%$search%'";
$count_result = mysqli_query($conn, $count_query);
$total_items = 0;

if ($count_result) {
    $count_row = mysqli_fetch_assoc($count_result);
    $total_items = $count_row['total_items'];
}

$query = "SELECT * FROM pembayaran 
          WHERE nama_barang LIKE '%$search%' 
          OR status LIKE '%$search%' 
          OR id_pembayaran LIKE '%$search%'
          ORDER BY id_pembayaran $order_by LIMIT $start_from, $items_per_page";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>
    <link rel="stylesheet" href="style.css">

    <style>

        .bukti-pembayaran img {
            max-width: 400px; 
            height: auto; 
        }

        .button {
            background-color: #008CBA;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        th{
            text-align: center;
            background-color: black;
            color: white;
            /* background-color: grey; */
        }

        .img_produk{
            
            width: 165px;
        }
        
        .judul{
            color: black;
        }
        

    </style>
</head>

<script>
function updateStatus(id_pembayaran) {
    const newStatus = document.getElementById(`status_${id_pembayaran}`).value;

    fetch('update_status.php', {
        method: 'POST',
        body: new URLSearchParams({
            id_pembayaran: id_pembayaran,
            status: newStatus
        }),
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload(); // Muat ulang halaman untuk memperbarui status
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>


<body>
    <h1 class="judul">DAFTAR PESANAN</h1>
    
    <!-- Kotak pencarian -->
    <form action="" method="GET">
        <input type="text" name="search" placeholder="Cari barang" value="<?php echo $search; ?>">
        <input type="submit" class="button" value="Cari">
    </form>

    <!-- Tombol urutan tabel -->
    <div class="table-order">
        <a class="button" href="daftar_pesanan.php?page=1&search=<?php echo $search; ?>&order_by=ASC">Ascending</a>
        <a class="button" href="daftar_pesanan.php?page=1&search=<?php echo $search; ?>&order_by=DESC">Descending</a>
    </div>

    <!-- Tombol Refresh -->
    <form action="" method="POST">
        <input type="submit" name="refresh" class="button" value="Refresh">
    </form>

    <!-- Tampilkan data pesanan -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Pembeli</th>
            <th>Total Harga</th>
            <th>Barang Dipesan</th>
            <th>Catatan</th>
            <th>Ubah Status</th> <!-- Tambah kolom ini -->
            <th>Bukti Pembayaran</th>
            <th>Tanggal Pemesanan</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id_pembayaran']}</td>";
            echo "<td>{$row['nama_barang']}</td>";
            echo "<td>Rp. {$row['total_harga']}</td>";
            echo "<td>{$row['barang_dipesan']}</td>";
            echo "<td>{$row['catatan']}</td>";
            echo "<td>";
            echo "<select id='status_{$row['id_pembayaran']}'>";
            echo "<option value='Belum Selesai' " . ($row['status'] == 'Belum Selesai' ? 'selected' : '') . ">Belum Selesai</option>";
            echo "<option value='Selesai' " . ($row['status'] == 'Selesai' ? 'selected' : '') . ">Selesai</option>";
            echo "</select>";
            echo "<button class='button' onclick='updateStatus({$row['id_pembayaran']})'>Ubah</button>";
            echo "</td>";
            echo "<td class='bukti-pembayaran'><img src='uploads/{$row['bukti_pembayaran']}' alt='Bukti Pembayaran' class='img_produk'></td>";
            echo "<td>" . $row['waktu_pemesanan'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Tombol navigasi pagination -->
    <div class="pagination">
        <?php
        // Hitung jumlah total halaman
        $total_pages = ceil($total_items / $items_per_page);
        
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a class='button' href='daftar_pesanan.php?page=$i&search=$search&order_by=$order_by'>$i</a> ";
        }
        ?>
    </div>

    <a href="seller.php" class="button">Menu Utama</a>
</body>
</html>
