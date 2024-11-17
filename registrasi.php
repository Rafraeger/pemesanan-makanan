<?php
require 'functions.php';

if(isset($_POST['register'])){

    if(registrasi($_POST) > 0){

             echo "
            <script>
                alert('user berhasil ditambahkan');
            </script>
        ";
    } else {
       echo mysqli_error($conn);
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
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

        .registration-container {
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

        button[type="submit"] {
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
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="img/logo.jpg" alt="Logo Mercu Buana" />
    </div>
    <h1>Halaman Registrasi</h1>

    <div class="registration-container">
        <?php if(isset($error)): ?>
            <p class="error-message">Username/password salah</p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            
            <label for="password2">Konfirmasi Password:</label>
            <input type="password" name="password2" id="password2">
            
            <button type="submit" name="register">Register</button>
        </form>
        <p>Sudah punya akun? Silahkan login <a href="login.php">di sini</a></p>
    </div>
</body>
</html>
