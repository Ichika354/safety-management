<?php
require '../../../function/function.php';
// require 'cek.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  // Query untuk mengambil data foto berdasarkan ID dari tabel di database
  $query = "SELECT file_reporter FROM report WHERE id_report = $id";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $foto = $row['file_reporter'];

    // Keluarkan data foto sebagai respon JSON
    header('Content-Type: application/json');
    echo json_encode(array('foto' => $foto));
    exit;
  }
}
?>
