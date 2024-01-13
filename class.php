<?php
$con = mysqli_connect('localhost', 'root', '', 'ns_institute');
$statusMsg = "";
error_reporting(0);
if (isset($_POST['save'])) {
  $className = $_POST['className'];
  $query = mysqli_query($con, "SELECT * from   `CreateClass` where className ='$className'");
  $ret = mysqli_fetch_array($query);
  if ($ret > 0) {
    $statusMsg = "<script>
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'This class is already created!'
          });
      </script>";
  } else {
    $query = mysqli_query($con, "INSERT into `CreateClass`(className) value('$className')");
    if ($query) {
      $statusMsg = "<script>
        Swal.fire({
            title: 'Class Created Successfully!',
            text: '',
            icon: 'success',
            confirmButtonText: 'OK'
        });
      </script>";
    } else {
      $statusMsg = " <script> Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',);  </script>";
    }
  }
}
if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['Id'];
  $query = mysqli_query($con, "SELECT * FROM `CreateClass` WHERE Id ='$Id'");
  $row = mysqli_fetch_array($query);
  if (isset($_POST['update'])) {
    $className = $_POST['className'];
    if (mysqli_query($con, "UPDATE `CreateClass` SET className='$className' WHERE Id='$Id'")) {
      $statusMsg = "<script>
              Swal.fire({
                  title: 'Do you want to save the changes?',
                  showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: 'Save',
                  denyButtonText: `Don\'t save`,
                  icon: 'question'
              }).then((result) => {
                  if (result.isConfirmed) {
                      // User confirmed, proceed with redirection
                      Swal.fire({
                          title: 'Changes saved!',
                          icon: 'success'
                      }).then(() => {
                          // Redirect to 'class.php' after a delay
                          setTimeout(function(){
                              window.location = 'class.php';
                          }, 2000);
                      });
                  } else if (result.isDenied || result.dismiss === Swal.DismissReason.cancel) {
                      // The user chose not to save changes or canceled the operation
                      Swal.fire({
                          title: 'Operation canceled',
                          icon: 'info'
                      }).then(() => {
                          // Optional: Rollback the update by redirecting to the original page
                          window.location = 'class.php?Id=' + $Id + '&action=edit';
                      });
                  }
              });
          </script>";
    }
  }
}
if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = $_GET['Id'];
  $statusMsg = "<script>
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed deletion, perform deletion logic
                    window.location.href = '?action=confirmDelete&Id=" . $Id . "';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'Deletion has been canceled.',
                        'info'
                    );
                }
            });
        </script>";
}
if (isset($_GET['action']) && $_GET['action'] == "confirmDelete" && isset($_GET['Id'])) {
  $Id = $_GET['Id'];
  $query = mysqli_query($con, "DELETE FROM `CreateClass` WHERE Id='$Id'");
  if ($query) {
    $statusMsg = "<script>
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                ).then(() => {
                    window.location = 'class.php';
                });
            </script>";
  } else {
    $statusMsg = "<div class='alert alert-danger' style='margin-right: 700px;'>An error occurred!</div>";
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
  <style>
  .delete-button {
    color: red;
  }
</style>

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
            <h1 class="h3 mb-0 text-gray-800">Create Course</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Course</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Course</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Course Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" required class="form-control" name="className"
                          value="<?php echo $row['className']; ?>" id="exampleInputFirstName" placeholder="i.e BCA part1">
                      </div>
                    </div>
                    <?php
                    if (isset($Id)) {
                      ?>
                      <button type="submit" name="update" class="btn btn-warning">Update</button>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php
                    } else {
                      ?>
                      <button type="submit" name="save" class="btn btn-primary">Save</button>
                      <?php
                    }
                    ?>
                  </form>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-primary">All Course</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>Sno.</th>
                            <th>Course Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $query = "SELECT * FROM `CreateClass`";
                          $rs = $con->query($query);
                          $num = $rs->num_rows;
                          $sn = 0;
                          if ($num > 0) {
                            while ($rows = $rs->fetch_assoc()) {
                              $sn = $sn + 1;
                              echo "
                              <tr>
                                <td>" . $sn . "</td>
                                <td>" . $rows['className'] . "</td>
                                <td><a href='?action=edit&Id=" . $rows['Id'] . "'><i class='fas fa-fw fa-edit' ></i>Edit</a></td>
                                <td><a href='?action=delete&Id=". $rows['Id']. "' class='delete-button'><i class='fas fa-fw fa-trash'></i>Delete</a></td>                                </tr>";
                            }
                          }
                           else {
                            echo
                              "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
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
    <a class="scroll-to-top rounded" href="#page-top" style="color:blue !important;">
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
        $('#dataTable').DataTable(); // ID From dataTable 
        $('#dataTableHover').DataTable(); // ID From dataTable with Hover
      });
    </script>
  </body>
</html>