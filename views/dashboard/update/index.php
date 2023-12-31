<?php
$conn = mysqli_connect('localhost','root','','safety_management');

function upload()
{
    $namaFile = $_FILES["foto"]["name"];
    $error = $_FILES["foto"]["error"];
    $tmpName = $_FILES["foto"]["tmp_name"];

    //cek apakah ada foto yg di upload atau tidak
    if ($error === 4) {
        echo
        "<script>
                alert('Upload image first!!');
            </script>";
        return false;
    }

    //cek apakah yang di upload foto atau bukan
    $ekstensiFotoValid = ["jpg", "jpeg", "png"];
    $ekstensiFoto = explode('.', $namaFile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));

    if (!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo
        "<script>
             alert('Upload your image');
         </script>";
        return false;
    }
    //lolos semua pengecekan
    //generate nama foto baru

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiFoto;




    move_uploaded_file($tmpName, '../../../assets/img/' . $namaFileBaru);

    return $namaFileBaru;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lakukan koneksi ke database

    $id = $_POST['id'];
    $oldImage = $_POST['oldImage'];
    $dateHazard = $_POST['dateHazard'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $hazardDescription = $_POST['hazard'];


    if ($_FILES["foto"]["error"] === 4) {
        $foto = $oldImage;
    } else {
        $foto = upload();
    }
    // Ambil data dari form dan lakukan update ke database

    $query = "UPDATE report SET 
                date_of_hazard = '$dateHazard',
                location = '$location',
                type_operation = '$type',
                description = '$hazardDescription',
                file_reporter = '$foto'

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
