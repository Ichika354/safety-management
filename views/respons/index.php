<?php
session_start();
require '../../function/function.php';
require '../../log/session/index.php';
$id = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT a.*, b.role FROM management a INNER JOIN role b ON a.id_role = b.id_role WHERE a.id_management = '$id'");
$profile = mysqli_fetch_assoc($query);

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
    <title>Responsible</title>
    <link href="../../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color:#005586;">
        <div style="width: 17em;">
            <a class="navbar-brand" href="index.php">SAFETY MANAGEMENT</a>
        </div>
        <div class="">
            <button class="btn btn-link btn-sm order-1 order-lg-0 ms-5" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </div>
        <div class="ms-auto text-end pe-4 text-white">
            <p class="mb-0"><?= $profile["fullname"]; ?> (<?= $profile["role"]; ?>)</p>
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
                    <h1 class="mt-4">Responsible</h1>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
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
                                            <th>Post Mitigation</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($safety = mysqli_fetch_assoc($query)) : ?>
                                            <?php $angka = $safety['id_report'];
                                            $done = sprintf('%03d', $angka); ?>
                                            <tr>
                                                <td><?= 'HR' . $done . '/' . date('d') . '/' . date('m'); ?></td>
                                                <td><?= $safety['classification']; ?></td>
                                                <td><?= $safety['date_of_submission']; ?></td>
                                                <td><?= $safety['date_of_hazard']; ?></td>
                                                <td><?= $safety['location']; ?></td>
                                                <td><?= $safety['type_operation']; ?></td>
                                                <td><?= $safety['description']; ?></td>
                                                <?php if ($safety['file_reporter'] > 0) { ?>
                                                    <td>
                                                        <a href="#" class="text-center open-popup-link" data-id="<?= $safety['id_report']; ?>" data-file="<?= $safety['file_reporter']; ?>">
                                                            <i class="fa-solid fa-image"></i>
                                                        </a>
                                                    </td>
                                                <?php } else { ?>
                                                    <td>Tidak Ada</td>
                                                <?php } ?>
                                                <?php if ($safety['file_response'] > 0) { ?>
                                                    <td>
                                                        <a href="#" class="text-center open-popup-link" data-id="<?= $safety['id_report']; ?>" data-file="<?= $safety['file_response']; ?>">
                                                            <i class="fa-solid fa-image"></i>
                                                        </a>
                                                    </td>
                                                <?php } else { ?>
                                                    <td>Tidak Ada</td>
                                                <?php } ?>
                                                <?php if ($safety['respon_hazard'] > 0) { ?>
                                                    <td><?= $safety['respon_hazard']; ?></td>
                                                <?php } else { ?>
                                                    <td>Tidak Ada</td>
                                                <?php } ?>
                                                <td><?= $safety['status']; ?></td>
                                                <?php if ($safety['post_mitigation'] > 0) { ?>
                                                    <td><?= $safety['post_mitigation']; ?></td>
                                                <?php } else { ?>
                                                    <td>Tidak Ada</td>
                                                <?php } ?>
                                                <td class="text-center">
                                                    <button class="btn btn-warning p-1" data-toggle="modal" data-target="#editModal<?= $safety['id_report']; ?>">
                                                        <i class="fa-solid fa-pen-square"></i>
                                                    </button>|
                                                    <a href="delete/?id=<?= $safety['id_report']; ?>" onclick="return confirm('Are you sure want to delete this data?..')" class="btn btn-danger p-1">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="editModal<?= $safety['id_report']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $safety['id_report']; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel<?= $safety['id_report']; ?>">Edit Data</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form Edit -->
                                                            <form action="update/index.php" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" value="<?= $safety['id_report']; ?>">
                                                                <div class="mb-2">
                                                                    <label for="">Date of Submission</label><br>
                                                                    <input type="text" class="form-control" id="" name="" value="<?= date('Y-m-d'); ?>" disabled required>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="">Date of Hazard Identification</label><br>
                                                                    <input type="text" class="form-control" id="" name="" value="<?= $safety['date_of_hazard'] ?>" disabled required>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="">Location</label><br>
                                                                    <input type="text" class="form-control" id="" name="" value="<?= $safety['location'] ?>" disabled required>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="">Type of Operation</label><br>
                                                                    <input type="text" class="form-control" id="" name="" value="<?= $safety['type_operation'] ?>" disabled required>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="">Hazard Description</label><br>
                                                                    <input type="text" class="form-control" id="" name="" value="<?= $safety['description'] ?>" disabled required>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="">File Upload</label><br>
                                                                    <input type="file" class="form-control" id="" name="foto" required>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="">Respon Hazard</label><br>
                                                                    <input type="text" class="form-control" id="" name="respon" required>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Edit</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Edit End -->

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
        $(document).ready(function() {
            $('.open-popup-link').click(function() {
                var fileId = $(this).data('file');
                var imageUrl = '../../assets/img/' + fileId; // Ganti dengan path ke folder gambar Anda

                $('#modalImage').attr('src', imageUrl);
                $('#imageModal').modal('show');
            });
        });
    </script>
</body>



</html>

<!-- Modal untuk menampilkan gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body d-flex justify-content-center">
                <img id="modalImage" src="" alt="Gambar Laporan" width="775">
            </div>
        </div>
    </div>
</div>