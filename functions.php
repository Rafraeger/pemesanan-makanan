<?php 

 $conn = mysqli_connect("localhost", "root", "", "kantin");

 function query($query){
    global  $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
     return $rows;
}



function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_row($result)){
        echo"
        <script>
            alert('username sudah terdaftar');
        </script>
    ";
    return false;
    }


    if($password !== $password2){
        echo"
            <script>
                alert('konfirmasi password tidak sesuai');
            </script>
        ";
        return false;

    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO user Values('','$username', '$password')");
    
    return mysqli_affected_rows($conn);
}



?>

