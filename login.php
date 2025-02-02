<?php
session_start(); // Memulai session
include("controller/koneksi.php");

error_reporting(0);
if (isset($_POST['masuk'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Prepare the statement
    $stmt = $conn->prepare("SELECT * FROM karyawan WHERE Username=? AND Password=?");
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    $stmt->execute();

    // Check if there's a match
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION["login"] = false;
        // Set session variables
        $row = $result->fetch_assoc();
        $_SESSION["username"] = $row["Username"];
        $_SESSION["nama"] = $row["Nama_Karyawan"];
        $_SESSION['role'] = $row["Hak_Akses"];
        sleep(3);
        header("location:index.php");
    } else {
        $eror = true;
    }
}




?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
    <meta property="og:title" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
    <meta property="og:description" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
    <meta property="og:image" content="https://fillow.dexignlab.com/xhtml/social-image.png">
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>Admin Dashboard</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link href="css/style.css" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="vendor/toastr/css/toastr.min.css">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href=""><img src="/images/ssp (2).jpeg" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4">Login</h4>
                                    <form action="" method="post">
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Username</strong></label>
                                            <input type="text" class="form-control" name="username"
                                                placeholder="Username" autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" class="form-control" id="input" name="password"
                                                placeholder="Password">

                                        </div>
                                        <div class="row d-flex justify-content-between mt-4 mb-2">
                                            <div class="mb-3">
                                                <div class="form-check custom-checkbox ms-1">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="basic_checkbox_1" onclick="check()">
                                                    <label class="form-check-label" for="basic_checkbox_1">Tampilkan
                                                        Password</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div claszs="text-center">
                                            <button type="submit" name="masuk" class="btn btn-primary btn-block">Sign
                                                In</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary"
                                                href="register.php">Register</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="js/showpassword.js"></script>
    <script src="vendor/global/global.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/dlabnav-init.js"></script>
    <script src="js/demo.js"></script>

    <script src="js/styleSwitcher.js"></script>
    <!-- Toastr -->
    <script src="vendor/toastr/js/toastr.min.js"></script>
    <script src="/js/"></script>
    <script>
        <?php if (isset($eror)): ?>
            toastr.error("Password anda salah", "WRONG !", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            })
        <?php endif; ?>
    </script>
</body>

</html>