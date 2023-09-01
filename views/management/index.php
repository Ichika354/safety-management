<?php
session_start();
require '../../function/function.php';
$id = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT a.*, b.role FROM management a INNER JOIN role b ON a.id_role = b.id_role WHERE a.id_management = '$id'");
$profile = mysqli_fetch_assoc($query);

// require 'cek.php';

$query = mysqli_query($conn, "SELECT a.*, b.name, c.role FROM management a INNER JOIN organization b ON a.id_organization = b.id_organization INNER JOIN role c ON a.id_role = c.id_role");

if (isset($_POST["submit"])) {

    if (addManagement($_POST) > 0) {
        echo
        "<script>
                alert('Management has been added');
                window.location.href = '../management/';
            </script>";
    } else {
        echo
        "<script>
                alert('Management has been error');
            </script>";
    }
}


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
                        <a class="nav-link" href="../../log/logout/" onclick="return confirm('Are you sure?..')">
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
                                                        <button class="btn btn-warning p-1" data-toggle="modal" data-target="#editModal<?= $safety['id_management']; ?>">
                                                            <i class="fa-solid fa-pen-square"></i>
                                                        </button>|
                                                        <button class="btn btn-danger p-1" data-toggle="modal" data-target="#editModal<?= $safety['id_management']; ?>">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $i++ ?>
                                                <!-- Modal Edit -->
                                                <div class="modal fade" id="editModal<?= $safety['id_management']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $safety['id_management']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel<?= $safety['id_management']; ?>">Edit Data</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Form Edit -->
                                                                <form action="update/index.php" method="post">
                                                                    <input type="hidden" name="id" value="<?= $safety['id_management']; ?>">
                                                                    <div class="mb-2">
                                                                        <label for="">Fullname</label><br>
                                                                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?= $safety['fullname']; ?>" required>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <label for="">NIK</label><br>
                                                                        <input type="text" class="form-control" id="nik" name="nik" value="<?= $safety['nik']; ?>" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="organization" style="width: 15rem;">Organization</label>
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
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="role" style="width: 15rem;">Role</label>
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
                                                                        </select>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
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
                    <label for="">Fullname</label><br>
                    <input type="text" name="name" placeholder="Full name" class="form-control" required> <br>
                    <label for="">NIK</label><br>
                    <input type="text" name="nik" placeholder="NIK" class="form-control" required> <br>
                    <label for="">Password</label><br>
                    <input type="password" name="password" placeholder="Password" class="form-control" required> <br>
                    <label for="">Organization</label><br>
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
                    <label for="">Role</label><br>
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
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
            </form>

            <!-- Modal footer -->


        </div>
    </div>
</div>