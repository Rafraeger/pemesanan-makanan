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

    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $deskripsi_produk = $_POST['deskripsi_produk'];

    $gambar_produk = ''; // Nama gambar produk

    if (isset($_FILES['gambar_produk']) && $_FILES['gambar_produk']['error'] === 0) {
        $upload_dir = "img/"; // Direktori penyimpanan gambar
        $gambar_produk = $_FILES['gambar_produk']['name'];
    
        // Membuat nama file yang unik dengan menambahkan timestamp
        $timestamp = time();
        $ext = pathinfo($_FILES['gambar_produk']['name'], PATHINFO_EXTENSION);
        $nama_file_unik = $timestamp . "." . $ext;
    
        $target_file = $upload_dir . $nama_file_unik;
    
        if (move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $target_file)) {
            // Query untuk menambahkan produk ke dalam tabel menu_produk
            $sql = "INSERT INTO menu_produk (nama_produk, harga_produk, gambar_produk, deskripsi_produk) VALUES ('$nama_produk', $harga_produk, '$nama_file_unik', '$deskripsi_produk')";
    
            if (mysqli_query($conn, $sql)) {
                header('Location: seller.php'); // Redirect ke halaman seller setelah berhasil menambahkan produk
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Upload gambar gagal.";
        }
    } else {
        echo "Gambar produk tidak diunggah atau terdapat kesalahan.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
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

        .image-preview {
            display: none;
            text-align: center;
            margin-top: 10px;
        }

        .image-preview img {
            max-width: 100%;
            height: auto;
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
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>TAMBAH PRODUK</h1>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nama_produk">Nama Produk:</label>
            <input type="text" id="nama_produk" name="nama_produk" required>
            <label for="harga_produk">Harga Produk:</label>
            <input type="number" id="harga_produk" name="harga_produk" required>
            <label for="gambar_produk">Gambar Produk:</label>
            <input type="file" id="gambar_produk" name="gambar_produk" accept="image/*" required onchange="previewImage(this);">
            <div class="image-preview" id="imagePreview">
                <img src="#" alt="Pratinjau Gambar" />
            </div>
            <label for="deskripsi_produk">Deskripsi Produk:</label>
            <textarea id="deskripsi_produk" name="deskripsi_produk" required></textarea>
            <input type="submit" value="Tambah Produk">
        </form>
        <a href="seller.php">Kembali ke Daftar Produk</a>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function () {
                preview.style.display = 'block';
                preview.querySelector('img').src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.style.display = null;
                preview.querySelector('img').src = null;
            }
        }
    </script>
</body>
</html>

