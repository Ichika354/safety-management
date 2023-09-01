<?php
require '../../../function/function.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lakukan koneksi ke database

    $id = $_POST['id'];
    $status = $_POST['status'];
    $mitigation = $_POST['mitigation'];
    // Ambil data dari form dan lakukan update ke database

    $query = "UPDATE report SET 
                status = '$status',
                post_mitigation = '$mitigation'

            WHERE id_report = $id
    ";

    mysqli_query($conn, $query);

    // ...

    // Setelah update, arahkan kembali ke halaman utama atau halaman yang sesuai
    echo
    "<script>
        alert('Report has been updated');
        window.location.href = '../'
    </script>";
    return mysqli_affected_rows($conn);
    exit();
}
