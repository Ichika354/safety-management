<?php

require '../function/function.php';
// require 'cek.php';

$query = mysqli_query($conn, "SELECT * FROM report WHERE status = 'accept'");



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color:#005586;">
        <div style="width: 17em;">
            <a class="navbar-brand" href="index.php">SAFETY EQUIPMENT STOCK</a>
        </div>
        <div class="">
            <button class="btn btn-link btn-sm order-1 order-lg-0 ms-5" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </div>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading"></div>

                        <a class="nav-link" href="../respons/">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-file-pen"></i>
                            </div>
                            Responsible
                        </a>
                        <a class="nav-link" href="../../log/logout/">
                            Logout
                        </a>
                    </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Responsible</h1>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NUMBER</th>
                                            <th>Classification</th>
                                            <th>Date of Submission</th>
                                            <th>Date of Hazard Identification</th>
                                            <th>Location</th>
                                            <th>Type Operation</th>
                                            <th>Description</th>
                                            <th>File Reporter</th>
                                            <th>File Response</th>
                                            <th>Respon Hazard</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($safety = mysqli_fetch_assoc($query)) : ?>
                                            <tr>
                                                <td><?= $safety['id_report']; ?></td>
                                                <td><?= $safety['classification']; ?></td>
                                                <td><?= $safety['date_of_submission']; ?></td>
                                                <td><?= $safety['date_of_hazard']; ?></td>
                                                <td><?= $safety['location']; ?></td>
                                                <td><?= $safety['type_operation']; ?></td>
                                                <td><?= $safety['description']; ?></td>
                                                <td><?= $safety['file_reporter']; ?></td>
                                                <td><?= $safety['file_response']; ?></td>
                                                <td><?= $safety['respon_hazard']; ?></td>
                                                <td><?= $safety['status']; ?></td>
                                                <td class="text-center">
                                                    <a href="update/?id=<?= $safety['id_report']; ?>" class="text-warning">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>|
                                                    <a href="" onclick="confirm('Yakin mau dihapus?')" class="text-danger">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/datatables-demo.js"></script>
    <script>
        // Fungsi untuk membuka popup dan menampilkan foto
        function showPhotoPopup(photoSrc) {
            var photoPopup = document.getElementById("photoPopup");
            var photoPopupImage = document.getElementById("photoPopupImage");
            photoPopupImage.src = photoSrc;
            photoPopup.style.display = "block";
        }

        // Fungsi untuk menutup popup
        function closePopup() {
            document.getElementById("photoPopup").style.display = "none";
        }

        // Menambahkan event listener untuk tautan buka popup
        var popupLinks = document.querySelectorAll(".open-popup-link");
        popupLinks.forEach(function(link) {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                var id = this.getAttribute("data-id");
                fetchPhoto(id);
            });
        });

        // Fungsi untuk mengambil data foto dari database
        function fetchPhoto(id) {
            fetch('../modal_img/index.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    var foto = data.foto;
                    showPhotoPopup('assets/img/' + foto);
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>



</html>

<div class="popup" id="photoPopup">
    <span class="close-popup-btn" onclick="closePopup()">&times;</span>
    <img src="" alt="Foto" class="popup-image" id="photoPopupImage">
</div>