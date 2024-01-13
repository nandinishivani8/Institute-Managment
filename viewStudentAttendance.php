<?php
$con = mysqli_connect('localhost', 'root', '', 'ns_institute');
session_start();
$searchErr = '';
$employee_details = '';
if (isset($_GET['save'])) {
  if (!empty($_GET['search_name']) || !empty($_GET['search_date'])) {
    $search_name = $_GET['search_name'];
    $search_date = $_GET['search_date'];
    $stmt = $con->prepare("SELECT students.id, students.student_name, attendance.curr_date, attendance.attendance
                              FROM students
                              INNER JOIN attendance ON students.id = attendance.student_id
                              WHERE students.student_name LIKE '%$search_name%' AND attendance.curr_date LIKE '%$search_date%'");
    // $search_name = "%" . $search_name . "%";
    // $stmt->bind_param("ss", $search_name, $search_date);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      $employee_details = $result->fetch_all(MYSQLI_ASSOC);
    } else {
      $searchErr = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'No data found for the given name and date!',
                    text: '',
                    confirmButtonText: 'OK'
                  });
              </script>";
    }
  } else {
    $searchErr = "<script>
    Swal.fire('Please enter the name or date!');
    </script>";
  }
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
  <title>NS_Institute - Dashboard</title>
  <link rel="shortcut icon" href="icon.png" type="image/x-icon" style="border-radius:20%;">
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
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Student Attendance</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">View Student Attendance</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Search particular student attendance</h6>
                </div>
                <div class="table-responsive p-3">
                  <form method="GET">
                    <div class="form-group row mb-3">
                      <div class="col-xl-3">
                        <input type="text" class="form-control" name="search_name" placeholder="Search by student name">
                      </div>
                      <div class="col-xl-3">
                        <input type="date" class="form-control" name="search_date" placeholder="Search by date">
                      </div>
                      <button type="submit" name="save" class="btn btn-primary">Search</button>
                    </div>
                  </form>
                </div>
                <div class="table-responsive p-3">
                  <div>
                    <div class="form-group">
                      <?php echo $searchErr; ?>
                    </div>
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                      <thead class="thead-light">
                        <tr>
                          <th>Sno.</th>
                          <th>student Name</th>
                          <th>date</th>
                          <th>status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (!$employee_details) {
                          echo '<tr><td colspan="4">No data found</td></tr>';
                        } else {
                          foreach ($employee_details as $key => $value) {
                            ?>
                            <tr>
                              <td><?php echo $value['id']; ?></td>
                               <td><?php echo $value['student_name']; ?></td> 
                               <td><?php echo $value['curr_date']; ?></td>
                              <td
                                style='background-color: <?php echo getColorBasedOnStatus($value['attendance']); ?>; color:white'>
                                <?php echo $value['attendance']; ?>
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
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php include "Includes/footer.php"; ?>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable();  
      $('#dataTableHover').DataTable(); 
    });
  </script>
</body>
</html>
<?php
function getColorBasedOnStatus($attendanceStatus)
{
  switch ($attendanceStatus) {
    case 'Present':
      return 'green';
    case 'Absent':
      return 'red';
    default:
      return ''; 
  }
}
?>