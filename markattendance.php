<?php
$con = mysqli_connect('localhost', 'root', '', 'ns_institute');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>NS_Institute - Dashboard</title>
  <link rel="shortcut icon" href="icon.png" type="image/x-icon" style="border-radius:20%;">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include "Includes/sidebar.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "Includes/topbar.php"; ?>
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Take Attendance (Today's Date :
              <?php echo $todaysDate = date("d-m-Y"); ?>)
            </h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">All Student in Class</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <form method="post">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="card mb-4">
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">All Student in (
                          <?php ?>) Class
                        </h6>
                        <h6 class="m-0 font-weight-bold text-danger">Note: <i>Click on the checkboxes besides each
                            student to take attendance!</i></h6>
                      </div>
                      <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush table-hover" cellspacing="0">
                          <form method="POST">
                            <tr class="thead-light">
                              <th>Student Name</th>
                              <th> Present </th>
                              <th> Absent </th>
                            </tr>
                            <?php
                            $fetchingStudents = mysqli_query($con, "SELECT * FROM students") or die(mysqli_error($con));
                            while ($data = mysqli_fetch_assoc($fetchingStudents)) {
                              $student_name = $data['student_name'];
                              $student_id = $data['id'];
                              ?>
                              <tr>
                                <td>
                                  <?php echo $student_name; ?>
                                </td>
                                <td> <input type="checkbox" name="studentPresent[]" value="<?php echo $student_id; ?>" />
                                </td>
                                <td> <input type="checkbox" name="studentAbsent[]" value="<?php echo $student_id; ?>" />
                                </td>
                              </tr>
                              <?php
                            }
                            ?>
                            <tr>
                              <input type="date" name="selected_date" hidden />
                            <tr>
                              <td>
                                <button required type="submit" name="addAttendanceBTN" class="btn btn-success">Take
                                  Attendence</button>
                              </td>
                            </tr>
                          </form>
                        </table>
                        <?php
                        if (isset($_POST['addAttendanceBTN'])) {
                          date_default_timezone_set("Asia/Karachi");
                          if ($_POST['selected_date'] == null) {
                            $selected_date = date("Y-m-d");
                          } else {
                            $selected_date = $_POST['selected_date'];
                          }
                          $attendance_month = date("M", strtotime($selected_date));
                          $attendance_year = date("Y", strtotime($selected_date));
                          if (isset($_POST['studentPresent'])) {
                            $studentPresent = $_POST['studentPresent'];
                            $attendance = "Present";
                            foreach ($studentPresent as $atd) {
                              mysqli_query($con, "INSERT INTO attendance(student_id, curr_date, attendance_month, attendance_year, attendance) VALUES('" . $atd . "', '" . $selected_date . "', '" . $attendance_month . "', '" . $attendance_year . "', '" . $attendance . "')") or die(mysqli_error($con));
                            }
                          }
                          if (isset($_POST['studentAbsent'])) {
                            $studentAbsent = $_POST['studentAbsent'];
                            $attendance = "Absent";
                            foreach ($studentAbsent as $atd) {
                              mysqli_query($con, "INSERT INTO attendance(student_id, curr_date, attendance_month, attendance_year, attendance) VALUES('" . $atd . "', '" . $selected_date . "', '" . $attendance_month . "', '" . $attendance_year . "', '" . $attendance . "')") or die(mysqli_error($con));
                            }
                          }
                          if (isset($_POST['addAttendanceBTN'])) {
                            echo '<script>
                                      Swal.fire({
                                      position: "top-end",
                                      icon: "success",
                                      title: "Attendance added successfully",
                                      showConfirmButton: false,
                                      timer: 1500
                                      }).then((result) => {
                                      // You can add additional actions here if needed
                                    });
                                  </script>';
                          }
                        }
                        ?>
  <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
  </a>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  </body>
</html>