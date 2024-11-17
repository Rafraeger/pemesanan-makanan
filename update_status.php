<?php
session_start();

if (!isset($_SESSION['seller_id'])) {
    header("HTTP/1.0 403 Forbidden");
    die("Access denied");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pembayaran'], $_POST['status'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $new_status = $_POST['status'];

    $conn = mysqli_connect("localhost", "root", "", "kantin");

    if (!$conn) {
        header("HTTP/1.0 500 Internal Server Error");
        die("Connection failed: " . mysqli_connect_error());
    }

    $update_query = "UPDATE pembayaran SET status = '$new_status' WHERE id_pembayaran = $id_pembayaran";

    if (mysqli_query($conn, $update_query)) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode(['success' => false, 'message' => 'Error updating status: ' . mysqli_error($conn)]);
    }

    mysqli_close($conn);
} else {
    header("HTTP/1.0 400 Bad Request");
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
