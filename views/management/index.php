<?php

require '../../function/function.php';
// require 'cek.php';

$query = mysqli_query($conn, "SELECT a.*, b.name, c.role FROM management a INNER JOIN organization b ON a.id_organization = b.id_organization INNER JOIN role c ON a.id_role = c.id_role");




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Management</title>
    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color:#005586;">
        <div style="width: 17em;">
            <a class="navbar-brand" href="index.php">SAFETY MANAGEMENT</a>
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
                        <a class="nav-link" href="../dashboard/">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-warning"></i></div>
                            Reporter
                        </a>
                        <a class="nav-link" href="../safety/">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-shield"></i>
                            </div>
                            Departement Safety
                        </a>
                        <a class="nav-link" href="../respons/">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-file-pen"></i>
                            </div>
                            Responsible
                        </a>
                        <a class="nav-link" href="../management/">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            Management
                        </a>
                        <a class="nav-link" href="../role/">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-list"></i>
                            </div>
                            Role
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
                    <h1 class="mt-4">Management</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- <a href="create/" class="btn btn-primary">Add +</a> -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Add +
                            </button>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NIK</th>
                                                <th>Fullname</th>
                                                <th>Organization</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php while ($safety = mysqli_fetch_assoc($query)) : ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td><?= $safety['nik']; ?></td>
                                                    <td><?= $safety['fullname']; ?></td>
                                                    <td><?= $safety['name']; ?></td>
                                                    <td><?= $safety['role']; ?></td>
                                                    <td class="text-center">
                                                        <a href="update/" class="text-warning">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>|
                                                        <a href="" onclick="confirm('Yakin mau dihapus?')" class="text-danger">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $i++ ?>
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
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/datatables-demo.js"></script>
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

<!-- Add Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Management</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="text" name="hazardDescription" placeholder="Full name" class="form-control" required> <br>
                    <input type="text" name="hazardDescription" placeholder="NIK" class="form-control" required> <br>
                    <input type="password" name="hazardDescription" placeholder="Password" class="form-control" required> <br>
                    <select class="form-control" id="organization" name="organization" required>
                        <option value="" selected disabled>Select Organization</option>
                        <?php
                        $ambildata = mysqli_query($conn, "SELECT * FROM organization");
                        while ($fetcharray = mysqli_fetch_array($ambildata)) {
                            $organization = $fetcharray['name'];
                            $id = $fetcharray['id_organization'];
                        ?>
                            <option value="<?= $id; ?>"><?= $organization; ?></option>
                        <?php
                        }
                        ?>
                    </select> <br>
                    <select class="form-control" id="role" name="role" required>
                        <option value="" selected disabled>Select Role</option>
                        <?php
                        $ambildata = mysqli_query($conn, "SELECT * FROM role");
                        while ($fetcharray = mysqli_fetch_array($ambildata)) {
                            $role = $fetcharray['role'];
                            $id = $fetcharray['id_role'];
                        ?>
                            <option value="<?= $id; ?>"><?= $role; ?></option>
                        <?php
                        }
                        ?>
                    </select> <br>
                    <input type="file" name="foto" class="form-control" accept="image/*" required> <br>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
            </form>

            <!-- Modal footer -->


        </div>
    </div>
</div>