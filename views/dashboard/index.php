<?php
session_start();
require '../../function/function.php';
$id = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT a.*, b.role FROM management a INNER JOIN role b ON a.id_role = b.id_role WHERE a.id_management = '$id'");
$profile = mysqli_fetch_assoc($query);



// require '../../log/session/index.php';

// $query = mysqli_query($conn, "SELECT * FROM report");

if (isset($_POST["submit"])) {

    if (add($_POST) > 0) {
        echo
        "<script>
                alert('Report has been Added');
                window.location.href '../dashboard';
            </script>";
    } else {
        echo
        "<script>
                alert('Report has been error');
            </script>";
    }
}

?>
<?php
if (isset($_GET['selected_month'])) {
    $selectedMonth = $_GET['selected_month'];

    // Buat tanggal awal dan akhir berdasarkan bulan yang dipilih
    $startDate = date('Y-' . $selectedMonth . '-01');
    $endDate = date('Y-' . $selectedMonth . '-t', strtotime($startDate));

    // Query untuk mengambil data berdasarkan rentang waktu
    $filter = "SELECT * FROM report WHERE date_of_submission BETWEEN '$startDate' AND '$endDate'";
    $result = mysqli_query($conn, $filter);

    // ... (proses hasil query)
}

// $filter = "SELECT * FROM report WHERE date_of_submission BETWEEN '$startDate' AND '$endDate'";
// $result = mysqli_query($conn, $filter);
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
    <link href="../../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/dashboar.css">
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
                                                <tr>
                                                    <td><?= $safety['id_report']; ?></td>
                                                    <td><?= $safety['classification']; ?></td>
                                                    <td><?= $safety['date_of_submission']; ?></td>
                                                    <td><?= $safety['date_of_hazard']; ?></td>
                                                    <td><?= $safety['location']; ?></td>
                                                    <td><?= $safety['type_operation']; ?></td>
                                                    <td><?= $safety['description']; ?></td>
                                                    <?php if ($safety['file_reporter'] > 0) { ?>
                                                        <td>
                                                            <a href="#" class="text-center open-popup-link" data-id="<?= $safety['id_report']; ?>">
                                                                <i class="fa-solid fa-image"></i>
                                                            </a>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td>Tidak Ada</td>
                                                    <?php } ?>
                                                    <td>Tidak Ada</td>
                                                    <?php // if ($safety['file_response'] > 0) { 
                                                    ?>
                                                    <?php if ($safety['respon_hazard'] > 0) { ?>
                                                        <td><?= $safety['respon_hazard']; ?></td>
                                                    <?php } else { ?>
                                                        <td>Tidak Ada</td>
                                                    <?php } ?>
                                                    <td><?= $safety['status']; ?></td>

                                                    <td class="text-center">
                                                        <a href="update/" class="text-warning">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>|
                                                        <a href="" onclick="return confirm('Yakin mau dihapus?')" class="text-danger">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
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
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/chart-area-demo.js"></script>
    <script src="../../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/demo/datatables-demo.js"></script>
    <script>
        // reporter
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
            return fetch('modal_img/index.php?id=' + id)
            console.log(response)
                .then(response => response.json())
                .then(data => {
                    var foto = data.foto;
                    showPhotoPopup('../../assets/img/' + foto);
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