<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'safety_management');

function add($data)
{
    global $conn;

    $dateHazard = $data['dateHazard'];
    $location = $data['location'];
    $type = $data['type'];
    $hazardDescription = $data['hazardDescription'];
    $image = upload();

    if (!$image) {
        return false;
    }

    $query = "INSERT INTO report (classification, date_of_submission,date_of_hazard,location,type_operation,description,file_reporter,status) VALUES('SMS',CURDATE(),'$dateHazard','$location','$type','$hazardDescription','$image','close')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

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




    move_uploaded_file($tmpName, '../assets/img/' . $namaFileBaru);

    return $namaFileBaru;
}

$id = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT a.*, b.role FROM management a INNER JOIN role b ON a.id_role = b.id_role WHERE a.id_management = '$id'");
$profile = mysqli_fetch_assoc($query);
// require '../log/session/index.php';

$query = mysqli_query($conn, "SELECT * FROM report");

if (isset($_POST["submit"])) {

    if (add($_POST) > 0) {
        echo
        "<script>
                alert('Report has been Added');
                window.location.href '../reporter/';
            </script>";
    } else {
        echo
        "<script>
                alert('Report has been error');
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
    <title>Reporter</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/dashboar.css">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<style>

</style>

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
                        <a class="nav-link" href="../log/logout/">
                            Logout
                        </a>
                    </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">List Reporter</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- <a href="create/" class="btn btn-primary">Add +</a> -->
                            <div class="row d-flex justify-content-between">
                                <button type="button" class="btn btn-primary col-sm-6 h-25" data-toggle="modal" data-target="#myModal" style="width: 100px;">
                                    Add +
                                </button>
                                <form method="get" class="col-sm-6 d-flex flex-row-reverse">
                                    <button type="submit" class="btn btn-success ms-2">Filter</button>
                                    <select name="selected_month" class="form-select" style="width: 210px;">
                                        <?php
                                        $selectedMonth = isset($_GET['selected_month']) ? $_GET['selected_month'] : date('m');
                                        $months = [
                                            "01" => "January", "02" => "February", "03" => "March", "04" => "April",
                                            "05" => "May", "06" => "June", "07" => "July", "08" => "August",
                                            "09" => "September", "10" => "October", "11" => "November", "12" => "December"
                                        ];

                                        foreach ($months as $monthNumber => $monthName) {
                                            $selected = ($selectedMonth == $monthNumber) ? "selected" : "";
                                            echo "<option value='$monthNumber' $selected>$monthName</option>";
                                        }
                                        ?>
                                    </select>
                                    <select name="selected_year" class="form-select" style="width: 100px;">
                                        <?php
                                        $selectedYear = isset($_GET['selected_year']) ? $_GET['selected_year'] : date('Y');
                                        $startYear = 2022;
                                        $endYear = 2030;

                                        for ($year = $startYear; $year <= $endYear; $year++) {
                                            $selected = ($selectedYear == $year) ? "selected" : "";
                                            echo "<option value='$year' $selected>$year</option>";
                                        }
                                        ?>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 15px;">
                                    <thead>
                                        <tr>
                                            <th scope="col">Number</th>
                                            <th scope="col">Classification</th>
                                            <th scope="col">Date of Submission</th>
                                            <th scope="col">Date of Hazard Identification</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Type Operation</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">File Reporter</th>
                                            <th scope="col">File Response</th>
                                            <th scope="col">Respon Hazard</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Post Mitigation</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        if (isset($_GET['selected_month']) && isset($_GET['selected_year'])) {
                                            $selectedMonth = $_GET['selected_month'];
                                            $selectedYear = $_GET['selected_year'];

                                            // Query untuk mengambil data berdasarkan bulan dan tahun yang dipilih
                                            if ($selectedMonth == '08') { // Agustus
                                                $query = "SELECT * FROM report WHERE MONTH(date_of_submission) = 8 AND YEAR(date_of_submission) = '$selectedYear'";
                                            } else {
                                                $query = "SELECT * FROM report WHERE MONTH(date_of_submission) = '$selectedMonth' AND YEAR(date_of_submission) = '$selectedYear'";
                                            }

                                            $result = mysqli_query($conn, $query);



                                            // Proses hasil query
                                            while ($safety = mysqli_fetch_assoc($result)) {
                                                // Tampilkan data dalam baris tabel
                                        ?>
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
                                                        <a href="delete/?id=<?= $safety['id_report']; ?>" onclick="return confirm('Are you sure want to delete this data?..')" class="btn btn-danger p-1" >
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
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
                                                                    <input type="hidden" name="oldImage" value="<?= $safety['file_reporter']; ?>">
                                                                    <div class="mb-2">
                                                                        <label for="">Date of Submission</label><br>
                                                                        <input type="text" class="form-control" id="" name="" value="<?= date('Y-m-d'); ?>" disabled required>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <label for="">Date of Hazard Identification</label><br>
                                                                        <input type="date" class="form-control" id="" name="dateHazard" value="<?= $safety['date_of_hazard'] ?>" required>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <label for="">Location</label><br>
                                                                        <input type="text" class="form-control" id="" name="location" value="<?= $safety['location'] ?>" required>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <label for="">Type of Operation</label>
                                                                        <select class="form-select" id="type" name="type" required>
                                                                            <option value="" selected disabled>Select Operation</option>
                                                                            <option value="Aircraft Maintenace">Aircraft Maintenace</option>
                                                                            <option value="Aircraft Component/Interior Maintenance">Aircraft Component/Interior Maintenance</option>
                                                                            <option value="Dismantling">Dismantling</option>
                                                                            <option value="Minor/Major Repair">Minor/Major Repair</option>
                                                                            <option value="Ground Run">Ground Run</option>
                                                                            <option value="Functional Test(Ground & Flight Test)">Functional Test(Ground & Flight Test)</option>
                                                                            <option value="Aircart Modification">Aircart Modification</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <label for="">Hazard Description</label><br>
                                                                        <input type="text" class="form-control" id="" name="hazard" value="<?= $safety['description'] ?>" required>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <label for="">File Upload</label><br>
                                                                        <input type="file" class="form-control" id="" name="foto">
                                                                        <br>
                                                                        <img src="../assets/img/<?= $safety['file_reporter']; ?>" alt="" width="100">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>

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
        $(document).ready(function() {
            $('.open-popup-link').click(function() {
                var fileId = $(this).data('file');
                var imageUrl = '../assets/img/' + fileId; // Ganti dengan path ke folder gambar Anda

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


<!-- Add Modal -->

<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="date" name="" placeholder="Date Of Submission" class="form-control" value="<?= date('Y-m-d')  ?>" required disabled> <br>
                    <input type="date" name="dateHazard" placeholder="Date Of Hazard Identification" class="form-control" required> <br>
                    <input type="text" name="location" placeholder="Location" class="form-control" required> <br>
                    <select class="form-control" id="type" name="type" required>
                        <option value="" selected disabled>Select Operation</option>
                        <option value="Aircraft Maintenace">Aircraft Maintenace</option>
                        <option value="Aircraft Component/Interior Maintenance">Aircraft Component/Interior Maintenance</option>
                        <option value="Dismantling">Dismantling</option>
                        <option value="Minor/Major Repair">Minor/Major Repair</option>
                        <option value="Ground Run">Ground Run</option>
                        <option value="Functional Test(Ground & Flight Test)">Functional Test(Ground & Flight Test)</option>
                        <option value="Aircart Modification">Aircart Modification</option>
                    </select><br>
                    <input type="text" name="hazardDescription" placeholder="Hazard Description" class="form-control" required> <br>
                    <input type="file" name="foto" class="form-control" accept="image/*" required> <br>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
            </form>

            <!-- Modal footer -->


        </div>
    </div>
</div>