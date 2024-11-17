<?php
session_start();
if(isset($_SESSION['login'])){
    header('Location: index.php');
    exit;
}
require 'functions.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    if(mysqli_num_rows($result) == 1){
        $_SESSION['login'] = true;
    
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])){
            $_SESSION['username'] = $username; // Menyimpan username ke dalam sesi
            header("Location: index.php");
            exit;
        }
    }
    $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin Halaman Login</title>
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

        .login-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .error-message {
            color: #ff0000;
            text-align: center;
            margin-bottom: 10px;
        }

        form ul {
            list-style-type: none;
            padding: 0;
        }

        form li {
            margin-bottom: 10px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            color: #ff0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="img/logo.jpg" alt="Logo Mercu Buana" />
    </div>
    <h1>Login</h1>

    <div class="login-container">
        <?php if(isset($error)): ?>
            <p class="error-message">Username/password salah</p>
        <?php endif; ?>
        <form action="" method="post">
            <ul>
                <li>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username">
                </li>
                <li>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                </li>
                <li>
                    <button type="submit" name="login">Login</button>
                </li>
            </ul>
        </form>
        <p>Belum punya akun? Silahkan registrasi <a href="registrasi.php">di sini</a></p>
    </div>
</body>
</html>
