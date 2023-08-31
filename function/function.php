<?php
$conn = mysqli_connect('localhost', 'root', '', 'safety_management');

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $row = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Add Report

function add($data){
    global $conn;

    $dateHazard = $data['dateHazard'];
    $location = $data['location'];
    $type = $data['type'];
    $hazardDescription = $data['hazardDescription'];
    $image = upload();

    if (!$image){
        return false;
    }

    $query = "INSERT INTO report (classification, date_of_submission,date_of_hazard,location,type_operation,description,file_reporter,status) VALUES('SMS',CURDATE(),'$dateHazard','$location','$type','$hazardDescription','$image','close')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}

// Add Report End


// Edit Safety

function editSafety($data){
    global $conn;

    $id = $data['id'];
    $status = $data['status'];

    $query = "UPDATE report SET 
                status = '$status'

            WHERE id_report = $id
    ";

    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

// Edit Safety End

// Edit Respons

function editRespon($data){
    global $conn;

    $id = $data['id'];
    $respon = $data['respon'];
    $oldImage = $data['oldImage'];
    if ($_FILES["foto"]["error"] === 4) {
        $image = $oldImage;
    } else {
        $image = upload();
    }

    $query = "UPDATE report SET
                file_response = '$image', 
                respon_hazard = '$respon'

            WHERE id_report = $id
    ";

    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

// Edit Respons End

// Add Management

function addManagement($data){

    global $conn;

    $fullname = $data['name'];
    $nik = $data['nik'];
    $password = $data['password'];
    $organization = $data['organization'];
    $role = $data['role'];

    $hash = password_hash($password, PASSWORD_DEFAULT);


    $query = ("INSERT INTO management(id_organization,id_role,nik,fullname,password) VALUES ('$organization','$role','$nik','$fullname','$hash')");

    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

// Add Management End



// Upload Image

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




    move_uploaded_file($tmpName, '../../assets/img/' . $namaFileBaru);

    return $namaFileBaru;
}

// Upload Image End

?>