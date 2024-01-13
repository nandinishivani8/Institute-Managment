<?php
$con = mysqli_connect('localhost', 'root', '', 'ns_institute');
error_reporting(E_ALL);
$statusMsg = "";
session_start();
if (!empty($_POST['login'])) {
    $user = $_POST['email'];
    $pass = $_POST['password'];
    $usert = $_POST['userType'];
    $q = mysqli_query($con, "SELECT * FROM signup WHERE email='$user' AND `password`='$pass' AND userType='$usert'");
    $count = mysqli_num_rows($q);
    if ($count == 1) {
        $row = mysqli_fetch_array($q);
        $_SESSION['user'] = $row['sno'];
        $_SESSION['sutitle'] = 'successfully login';
        $_SESSION['sumsg'] = 'Congratulations';
        header('location: home.php');
        exit(0);
    } else {
        $q_check_email = mysqli_query($con, "SELECT * FROM signup WHERE email='$user'");
        $count_email = mysqli_num_rows($q_check_email);
        $q_check_usertype = mysqli_query($con, "SELECT * FROM signup WHERE userType='$usert'");
        $count_usertype = mysqli_num_rows($q_check_usertype);
        $_SESSION['error'] = 'please enter correct password and email';
        $_SESSION['msg'] = 'please enter correct password and email';
        header('location:index.php');
        exit(0);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="cache-control" content="no-store" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="icon.png" rel="icon">
    <title>NS_Institute - Login</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="icon.png" type="image/x-icon" style="border-radius:20%;">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
<body class="bg-gradient-login" style="background-image: url('img/logo/loral1.jpe00g');">
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-14 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <b>
                                        <h1 align="center" ;>NS_Institute</h1>
                                    </b><br>
                                    <div class="text-center">
                                        <img src="icon.png" style="width:150px;height:130px; border-radius:100%;">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">Login Panel</h1>
                                    </div>
                                    <form class="user" method="Post">
                                        <div class="form-group">
                                            <select name="userType" required class="form-control mb-3">
                                                <option value="">--Select User Roles--</option>
                                                <option value="Administrator">Administrator</option>
                                                <option value="ClassTeacher">ClassTeacher</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="email"
                                                id="exampleInputEmail" placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" required class="form-control"
                                                id="exampleInputPassword" placeholder="Enter Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small"
                                                style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success btn-block" value="Login"
                                                name="login" />
                                        </div>
                                    </form>
                                    <hr><a href="index.php" class="btn btn-google btn-block">
                                        <i class="fab fa-google fa-fw"></i> Login with Google
                                    </a>
                                    <a href="index.php" class="btn btn-facebook btn-block">
                                        <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                    </a>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <?php
    if (empty($_SESSION['user'])) {
        if (!empty($_SESSION['error'])) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: '{$_SESSION['error']}',
                    text: '{$_SESSION['emsg']}',
                    confirmButtonText: 'OK'
                  });
              </script>";
            $_SESSION['error'] = null;
            $_SESSION['msg'] = null;
        }
    }
    ?>
</body>
</html>