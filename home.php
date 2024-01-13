<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'ns_institute');
if (isset($_SESSION["user"]))
{
} else {
  $_SESSION['error'] = "Login";
  $_SESSION['emsg'] = "Please Login First";
  header('location: index.php');
  exit(0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="icon.png" type="image/x-icon" style="border-radius:20%;">
  <title>NS_Institute - Dashboard</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>
<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "Includes/sidebar.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include "Includes/topbar.php"; ?>
        <?php
        $con = mysqli_connect('localhost', 'root', '', 'ns_institute');
        $query1 = mysqli_query($con, "SELECT * FROM `signup` WHERE `sno`='{$_SESSION['user']}' ");
        $login = mysqli_fetch_array($query1);
        ?>
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Welcome
              <?php echo $login["name"];?> !
            </h1>
            <h3 class="h3 mb-0 text-gray-800"></h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>
          <div class="row mb-3">
            <!-- Students Card -->
            <?php
            $query1 = mysqli_query($con, "SELECT * FROM students");
            $students = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Students</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2">
                          <h3 class="counter" data-target="<?php echo $students; ?>"></h3>
                        </span>
                        <span>Since last month</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Class Card -->
            <?php
            $query1 = mysqli_query($con, "SELECT * from `createclass`");
            $class = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Courses</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2">
                          <h3 class="counter" data-target="<?php echo $class; ?>"></h3>
                        </span>
                        <span>Since last month</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chalkboard fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- attendance cards -->
            <?php
            $query1 = mysqli_query($con, "SELECT * from `attendance`");
            $totAttendance = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Student Attendance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-danger mr-2">
                          <h3 class="counter" data-target="<?php echo "$totAttendance"; ?>"></h3>
                        </span>
                        <span>Since yesterday</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-secondary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Teachers Card  -->
            <?php
            $query1 = mysqli_query($con, "SELECT * from create_teacher");
            $classTeacher = mysqli_num_rows($query1);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Class Teachers</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success mr-2">
                          <h3 class="counter" data-target="<?php echo $classTeacher; ?>"></h3>
                        </span>
                        <span>Since last years</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chalkboard-teacher fa-2x text-danger"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Footer -->
        <div>
          <?php include 'Includes/footer.php'; ?>
        </div>
      </div>
      <!-- Scroll to top -->
      <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
      </a>
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="js/ruang-admin.min.js"></script>
      <script src="vendor/chart.js/Chart.min.js"></script>
      <script src="js/demo/chart-area-demo.js"></script>
      <script>
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
          counter.innerText = '0';
          const updateCounter = () => {
            const target = +counter.getAttribute('data-target')
            const c = +counter.innerText
            const increment = 1
            if (c < target) {
              counter.innerText = `${Math.ceil(c + increment)}`
              setTimeout(updateCounter, 200)
            } else {
              counter.innerText = target
            }
          }
          updateCounter()
        })
      </script>
      <?php 
      if (!empty($_SESSION['user'])) {
        if (!empty($_SESSION['sutitle'])) {
          echo "<script>
              Swal.fire({
                  title: '{$_SESSION['sutitle']}',
                  text: '{$_SESSION['sumsg']}',
                  icon: 'success',
                  confirmButtonText: 'OK'
              });
            </script>";
          $_SESSION['sutitle'] = null;
          $_SESSION['sumsg'] = null;
        }
      }
      ?>
    </div>
  </body>
</html>