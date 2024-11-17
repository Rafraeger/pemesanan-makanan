<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

header("Location: umbkantin_login_seller.php");
exit;
?>