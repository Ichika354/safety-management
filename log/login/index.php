<?php
session_start();


require '../../function/function.php';

if (isset($_POST['submit'])) {
    $nik = $_POST['nik']; // Pastikan $nik sudah diisi dengan nilai yang benar
    $password = $_POST['password']; // Pastikan $password sudah diisi dengan nilai yang benar

    $cekdatabase = mysqli_query($conn, "SELECT * FROM management WHERE nik='$nik'");
    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung > 0) {
        $row = mysqli_fetch_assoc($cekdatabase);
        $verif = password_verify($password, $row["password"]);
        if ($verif) {
            // Jika verifikasi berhasil, set sesi dan arahkan ke halaman yang sesuai
            $_SESSION['id'] = $row['id_management'];

            if ($row['id_role'] == 1) {
                $_SESSION['admin'] = true;
                header('location: ../../views/dashboard/');
            } elseif ($row['id_role'] == 2) {
                $_SESSION['safety'] = true;
                header('location: ../../views/dashboard/');
            } elseif ($row['id_role'] == 3) {
                $_SESSION['responsible'] = true;
                header('location: ../../response/');
            } elseif ($row['id_role'] == 4) {
                $_SESSION['reporter'] = true;
                header('location: ../../reporter/');
            }
        } else {
            header('location: ../login');
        }
    } else {
        header('location: ../login');
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
    <title>Login</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<style>
    *,
    body,
    html {
        margin: 0;
        padding: 0;
    }

    .form {
        background-color: #fff;
        display: block;
        padding: 1rem;
        max-width: 350px;
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .form-title {
        font-size: 1.25rem;
        line-height: 1.75rem;
        font-weight: 600;
        text-align: center;
        color: #000;
    }

    .input-container {
        position: relative;
    }

    .input-container input,
    .form button {
        outline: none;
        border: 1px solid #e5e7eb;
        margin: 8px 0;
    }

    .input-container input {
        background-color: #fff;
        padding: 1rem;
        padding-right: 3rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        width: 200px;
        border-radius: 0.5rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .input-container span {
        display: grid;
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        padding-left: 1rem;
        padding-right: 1rem;
        place-content: center;
    }

    .input-container span svg {
        color: #9CA3AF;
        width: 1rem;
        height: 1rem;
    }

    .submit {
        display: block;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
        padding-left: 1.25rem;
        padding-right: 1.25rem;
        background-color: #4F46E5;
        color: #ffffff;
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 500;
        width: 100%;
        border-radius: 0.5rem;
        text-transform: uppercase;
    }

    .signup-link {
        color: #6B7280;
        font-size: 0.875rem;
        line-height: 1.25rem;
        text-align: center;
    }

    .signup-link a {
        text-decoration: underline;
    }

    .login {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-image: url('../../assets/img/banner_corporate_overview_1658807829.jpg');
        background-position: center;
        background-size: cover;
    }

    .tombol {
        width: 5em;
    }
</style>

<body>

    <div class="login">

        <form class="form" method="post">
            <p class="form-title">Sign in to your account</p>
            <div class="input-container">
                <input placeholder="Enter NIK" type="text" name="nik" autocomplete="off">
            </div>
            <div class="input-container">
                <input placeholder="Enter password" type="password" id="passwordInput" name="password">
            </div>
            <input type="checkbox" id="showPasswordCheckbox" onchange="togglePasswordVisibility()">
            <label for="showPasswordCheckbox">Show Password</label>
            <button class="submit" type="submit" name="submit">
                Sign in
            </button>
            <a href="../../">Back</a>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("passwordInput");
            var showPasswordCheckbox = document.getElementById("showPasswordCheckbox");

            if (showPasswordCheckbox.checked) {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>

</html>