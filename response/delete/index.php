<?php 
$conn = mysqli_connect('localhost', 'root', '', 'safety_management');


$id = $_GET["id"];

function deleteReport($id)
{
    global $conn;

    try {
        mysqli_query($conn, "DELETE FROM report WHERE id_report = $id");
    } catch (Exception $e) {
        echo
        "<script>
            alert('Report can't delete');
            window.location.href = '../';
        </script>";
    }

    return mysqli_affected_rows($conn);
}



if ( deleteReport($id) > 0 ) {
    echo
    "<script>
        alert('Report has been deleted');
        window.location.href = '../';
    </script>";
} else {
     echo
    "<script>
        alert('Report has been error');
        window.location.href = '../';
    </script>";
}
