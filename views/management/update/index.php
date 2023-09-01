<?php
require '../../../function/function.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lakukan koneksi ke database

    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $nik = $_POST['nik'];
    $organization = $_POST['organization'];
    $role = $_POST['role'];
    // Ambil data dari form dan lakukan update ke database

    $query = "UPDATE management SET 
                fullname = '$fullname',
                nik = '$nik',
                id_organization = '$organization',
                id_role = '$role'

            WHERE id_management = $id
    ";

    mysqli_query($conn, $query);

    // ...

    // Setelah update, arahkan kembali ke halaman utama atau halaman yang sesuai
    echo
    "<script>
        alert('Management has been updated');
        window.location.href = '../management/'
    </script>";
    return mysqli_affected_rows($conn);
    exit();
}
