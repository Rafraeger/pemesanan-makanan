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
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'id_produk';

// Urutan tabel (default: ascending)
$order_dir = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'ASC';

// Tombol Refresh
if (isset($_POST['refresh'])) {
    header("Location: seller.php");
    exit;
}

// Query untuk mengambil data produk dengan pembagian halaman
$start_from = ($current_page - 1) * $items_per_page;

// Query untuk menghitung total item yang cocok dengan kriteria pencarian
$count_query = "SELECT COUNT(*) AS total_items FROM menu_produk 
                WHERE id_produk LIKE '%$search%' 
                OR nama_produk LIKE '%$search%' 
                OR harga_produk LIKE '%$search%'";
$count_result = mysqli_query($conn, $count_query);
$total_items = 0;

if ($count_result) {
    $count_row = mysqli_fetch_assoc($count_result);
    $total_items = $count_row['total_items'];
}

$query = "SELECT * FROM menu_produk 
          WHERE id_produk LIKE '%$search%' 
          OR nama_produk LIKE '%$search%' 
          OR harga_produk LIKE '%$search%'
          ORDER BY $order_by $order_dir LIMIT $start_from, $items_per_page";
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
    <title>Daftar Produk</title>
    <style>
        /* CSS untuk tampilan produk */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #333;
            text-align: center;
            color: white;
        }

        td {
            border: 1px solid #ddd;
        }

        img.product-image {
            max-width: 150px;
            height: auto;
        }

        /* CSS untuk tombol Cari & Urutkan */
        form {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        input[type="text"],
        select {
            margin-right: 10px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 200px;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        /* CSS untuk pagination */
        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 5px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }

        /* CSS tambahan */
        h1 {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
        }

        a.button {
            text-decoration: none;
            background-color: #333;
            color: white;
            padding: 3px 6px;
            border-radius: 5px;
            margin-right: 10px;
            font-weight: bold;
        }

        .hapus{
            color: red;
        }

    </style>
</head>
<body>
    <h1>DAFTAR PRODUK</h1>
    <br>
    <a class="button" href="tambah_produk.php">Tambah Produk</a>
    <a class="button" href="daftar_pesanan.php">Daftar Pesanan</a>

    <form action="" method="get">
        <input type="text" name="search" placeholder="Cari Produk" value="<?php echo $search; ?>">
        <select name="order_by">
            <option value="id_produk" <?php echo ($order_by == 'id_produk') ? 'selected' : ''; ?>>ID Produk</option>
            <option value="nama_produk" <?php echo ($order_by == 'nama_produk') ? 'selected' : ''; ?>>Nama Produk</option>
            <option value="harga_produk" <?php echo ($order_by == 'harga_produk') ? 'selected' : ''; ?>>Harga Produk</option>
        </select>
        <select name="order_dir">
            <option value="ASC" <?php echo ($order_dir == 'ASC') ? 'selected' : ''; ?>>Ascending</option>
            <option value="DESC" <?php echo ($order_dir == 'DESC') ? 'selected' : ''; ?>>Descending</option>
        </select>
        <input type="submit" value="Cari & Urutkan">
        <input type="submit" name="refresh" value="Refresh">
    </form>

    <table>
    <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Harga Produk</th>
        <th>Gambar</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['id_produk']}</td>";
        echo "<td>{$row['nama_produk']}</td>";
        echo "<td>Rp. {$row['harga_produk']}</td>";
        echo "<td><img src='img/{$row['gambar_produk']}' alt='{$row['nama_produk']}' class='product-image'></td>";
        echo "<td>{$row['deskripsi_produk']}</td>";
        echo "<td>";
        echo "<a href='edit_produk.php?id={$row['id_produk']}'>Edit</a><br>";
        echo "<a href='javascript:void(0);' onclick='konfirmasiHapus({$row['id_produk']})' class='hapus'>Hapus</a>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

<script>
    function konfirmasiHapus(idProduk) {
        if (confirm("Apakah Anda yakin akan menghapus produk ini?")) {
            window.location.href = "hapus_produk.php?id=" + idProduk;
        }
    }
</script>

    <?php
    // Hitung jumlah halaman yang diperlukan
    $total_pages = ceil($total_items / $items_per_page);

    // Tampilkan tombol pagination
    echo "<div class='pagination'>";
    for ($page = 1; $page <= $total_pages; $page++) {
        echo "<a href='seller.php?page={$page}&search={$search}&order_by={$order_by}&order_dir={$order_dir}'>{$page}</a>";
    }
    echo "</div>";
    ?>
    <hr>
    <br>
    <a class="button" href="logout_seller.php">Logout</a>
    <br>
    <br>
    <br>
</body>
</html>


