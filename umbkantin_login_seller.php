<?php
session_start();

if (isset($_SESSION['seller_id'])) {
    header("Location: seller.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "kantin");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa username dan password seller
    $query = "SELECT * FROM sellers WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $seller = mysqli_fetch_assoc($result);

        // Memeriksa kecocokan password
        if (password_verify($password, $seller['password'])) {
            // Password cocok, set session dan redirect ke halaman seller
            $_SESSION['seller_id'] = $seller['id'];
            header("Location: seller.php");
            exit;
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Username tidak ditemukan.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Seller</title>
    <style>
        /* CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #213627;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        .navbar img {
            max-width: 100px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        a {
            text-decoration: none;
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="img/logo.jpg" alt="Logo Mercu Buana" />
    </div>
    <h1>Login Seller</h1>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Login">
    </form>
    <p>Belum punya akun? Silahkan registrasi <a href="umbkantin_registrasi_seller.php">di sini</a></p>
</body>
</html>
