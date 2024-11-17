<?php


$id_produk = $_GET['id']; // Ambil id produk dari URL

$conn = mysqli_connect("localhost", "root", "", "kantin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query untuk menghapus produk dari tabel menu_produk
$sql = "DELETE FROM menu_produk WHERE id_produk = $id_produk";

if (mysqli_query($conn, $sql)) {
    header('Location: seller.php'); // Redirect ke halaman seller setelah berhasil menghapus produk
    exit;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
