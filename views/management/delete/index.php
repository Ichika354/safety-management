<?php 
$conn = mysqli_connect('localhost', 'root', '', 'safety_management');


$id = $_GET["id"];

function deleteReport($id)
{
    global $conn;

    try {
        mysqli_query($conn, "DELETE FROM management WHERE id_management = $id");
    } catch (Exception $e) {
        echo
        "<script>
            alert('Management can't delete');
            window.location.href = '../';
        </script>";
    }

    return mysqli_affected_rows($conn);
}



if ( deleteReport($id) > 0 ) {
    echo
    "<script>
        alert('Management has been deleted');
        window.location.href = '../';
    </script>";
} else {
     echo
    "<script>
        alert('Management has been error');
        window.location.href = '../';
    </script>";
}
