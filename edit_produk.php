<?php
session_start();

// Periksa apakah session seller_id telah diatur
if (!isset($_SESSION['seller_id'])) {
    header("Location: umbkantin_login_seller.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "kantin");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $deskripsi_produk = $_POST['deskripsi_produk'];

    // Periksa apakah gambar baru diunggah
    if (isset($_FILES['gambar_produk']) && $_FILES['gambar_produk']['error'] === 0) {
        // Hapus gambar produk lama
        $produk_query = mysqli_query($conn, "SELECT gambar_produk FROM menu_produk WHERE id_produk = $id_produk");
        if ($produk_query) {
            $produk = mysqli_fetch_assoc($produk_query);
            $gambar_produk_lama = $produk['gambar_produk'];
            unlink("img/" . $gambar_produk_lama);
        }

        // Upload gambar baru
        $upload_dir = "img/";
        $gambar_produk = $_FILES['gambar_produk']['name'];

        // Membuat nama file yang unik dengan menambahkan timestamp
        $timestamp = time();
        $ext = pathinfo($_FILES['gambar_produk']['name'], PATHINFO_EXTENSION);
        $nama_file_unik = $timestamp . "." . $ext;

        $target_file = $upload_dir . $nama_file_unik;

        if (move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $target_file)) {
            // Query untuk mengupdate produk dalam tabel menu_produk dengan gambar baru
            $sql = "UPDATE menu_produk SET nama_produk='$nama_produk', harga_produk=$harga_produk, deskripsi_produk='$deskripsi_produk', gambar_produk='$nama_file_unik' WHERE id_produk=$id_produk";

            if (mysqli_query($conn, $sql)) {
                header('Location: seller.php'); // Redirect ke halaman seller setelah berhasil mengedit produk
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Upload gambar gagal.";
        }
    } else {
        // Jika tidak ada gambar baru diunggah, hanya update data tanpa mengubah gambar
        $sql = "UPDATE menu_produk SET nama_produk='$nama_produk', harga_produk=$harga_produk, deskripsi_produk='$deskripsi_produk' WHERE id_produk=$id_produk";

        if (mysqli_query($conn, $sql)) {
            header('Location: seller.php'); // Redirect ke halaman seller setelah berhasil mengedit produk
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-top: 20px;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Edit Produk</h1>
    <div class="container">
        <?php
        $id_produk = $_GET['id']; // Ambil id produk dari URL

        $conn = mysqli_connect("localhost", "root", "", "kantin");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $produk_query = mysqli_query($conn, "SELECT * FROM menu_produk WHERE id_produk = $id_produk");

        if ($produk_query) {
            $produk = mysqli_fetch_assoc($produk_query);
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">
            <label for="nama_produk">Nama Produk:</label>
            <input type="text" id="nama_produk" name="nama_produk" value="<?php echo $produk['nama_produk']; ?>" required>
            <label for="harga_produk">Harga Produk:</label>
            <input type="number" id="harga_produk" name="harga_produk" value="<?php echo $produk['harga_produk']; ?>" required>
            <label for="gambar_produk">Gambar Produk:</label>
            <input type="file" id="gambar_produk" name="gambar_produk" accept="image/*">
            <label for="deskripsi_produk">Deskripsi Produk:</label>
            <textarea id="deskripsi_produk" name="deskripsi_produk" required><?php echo $produk['deskripsi_produk']; ?></textarea>
            <input type="submit" value="Simpan Perubahan">
        </form>
        <a href="seller.php">Kembali ke Daftar Produk</a>
    </div>
</body>
</html>

