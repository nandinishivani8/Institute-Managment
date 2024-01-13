<?php
error_reporting(0);
session_start();
$con = mysqli_connect('localhost', 'root', '', 'ns_institute');
$statusMsg = "";
if (isset($_POST['save'])) {
  $Id = $_POST['id'];
  $first_name = $_POST['student_name'];
  $last_name = $_POST['father_name'];
  $admission_number = $_POST['admissionNumber'];
  $class_id = $_POST['class_id'];
  $email = $_POST['email_address'];
  $phone = $_POST['phone'];
  $query = mysqli_query($con, "SELECT * from   `students` where `admissionNumber` ='$admission_number'");
  $ret = mysqli_fetch_array($query);
  if ($ret > 0) {
    $statusMsg = "<script>
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'This Admission number is already created!'
          });
      </script>";
  } else {
    $query = mysqli_query($con, "INSERT INTO `students` (`id`, `student_name`, `father_name`, `admissionNumber`, `class_id` ,`email_address`,`phone`) VALUES ('$Id','$first_name','$last_name','$admission_number','$class_id','$email','$phone')");
    if ($query) {
      $statusMsg = "<script>
        Swal.fire({
            title: 'Student  Created Successfully!',
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
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
  $Id = $_GET['id'];
  $query = mysqli_query($con, "SELECT * from `students` where `id` ='$Id'");
  $row = mysqli_fetch_array($query);
  if (isset($_POST['update'])) {
    $Id = $_POST['id'];
    $first_name = $_POST['student_name'];
    $last_name = $_POST['father_name'];
    $admission_number = $_POST['admissionNumber'];
    $class_id = $_POST['class_id'];
    $email = $_POST['email_address'];
    $phone = $_POST['phone'];
    $query = mysqli_query($con, "UPDATE `students` SET `student_name`='$first_name',`father_name`='$last_name',`class_id`='$class_id' ,`email_address`='$email',`phone`='$phone' WHERE  `admissionNumber`='$admission_number'");
    if ($query) {
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
                              window.location = 'CreateStu.php';
                          }, 2000);
                      });
                  } else if (result.isDenied || result.dismiss === Swal.DismissReason.cancel) {
                      // The user chose not to save changes or canceled the operation
                      Swal.fire({
                          title: 'Operation canceled',
                          icon: 'info'
                      }).then(() => {
                          // Optional: Rollback the update by redirecting to the original page
                          window.location = 'CreateStu.php?Id=' + $Id + '&action=edit';
                      });
                  }
              });
          </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
  $Id = mysqli_real_escape_string($con, $_GET['id']);
  $statusMsg = "
        <script>
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
                window.location.href = '?action=confirmDelete&id={$Id}';
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
if (isset($_GET['action']) && $_GET['action'] == "confirmDelete" && isset($_GET['id'])) {
  $Id = mysqli_real_escape_string($con, $_GET['id']);
  $query = mysqli_query($con, "DELETE FROM `students` WHERE `id`='$Id'");
  if ($query) {
    $statusMsg = "
            <script>
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            ).then(() => {
                window.location = 'CreateStu.php';
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
  <link rel="shortcut icon" href="icon.png" type="image/x-icon" style="border-radius:20%;">
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
    <?php include "Includes/sidebar.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "Includes/topbar.php"; ?>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Students</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Students</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Create Students</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Student Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="student_name"
                          value="<?php echo $row['student_name']; ?>" id="exampleInputFirstName">
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Father's Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="father_name"
                          value="<?php echo $row['father_name']; ?>" id="exampleInputFirstName">
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Email <span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="email_address"
                          value="<?php echo $row['email_address']; ?>" id="exampleInputFirstName">
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">phone<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" maxlength="10" name="phone"
                          value="<?php echo $row['phone']; ?>" id="exampleInputFirstName">
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Admission Number<span
                            class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" required name="admissionNumber" readonly
                          value="<?php echo $row['admissionNumber']; ?>" id="admissionNumber">
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label" for="class_id">Select Class:</label>
                        <select class="form-control mb-3" name="class_id" required multiselect>
                          <option value="<?php echo $row['class_id']; ?>">-- Select Class --</option>
                          <?php
                          $class_query = "SELECT * FROM `createclass`"; 
                          $class_result = mysqli_query($con, $class_query);
                          while ($class_row = mysqli_fetch_assoc($class_result)) {
                            echo "<option value='" . $class_row['className'] . "'>" . $class_row['className'] . "</option>";
                          }
                          ?>
                        </select>
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
                      <h6 class="m-0 font-weight-bold text-primary">All Student</h6>
                    </div>
                    <div class="table-responsive p-3">
                      <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                          <tr>
                            <th>Sno.</th>
                            <th>Student Name</th>
                            <th>Father's Name</th>
                            <th>Admission Number</th>
                            <th>classes</th>
                            <th>Email</th>
                            <th>phone</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = "SELECT * FROM `students`";
                          $result = mysqli_query($con, $sql);
                          $sn = 0;
                          while ($row = mysqli_fetch_assoc($result)) {
                            $sn = $sn + 1;
                            echo "
              <tr>
                <td>" . $sn . "</td>
                <td>" . $row['student_name'] . "</td>
                <td>" . $row['father_name'] . "</td>
                <td>" . $row['admissionNumber'] . "</td>
                <td>" . $row['class_id'] . "</td>
                <td>" . $row['email_address'] . "</td>
                <td>" . $row['phone'] . "</td>
                <td><a href='?action=edit&id=" . $row['id'] . "'><i class='fas fa-fw fa-edit'></i>Edit</a></td>
                <td><a href='?action=delete&id=". $row['id']. "' class='delete-button'><i class='fas fa-fw fa-trash'></i>Delete</a></td>       
              </tr>";
              
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
        <?php include "Includes/footer.php"; ?>
      </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <script>
      function generateTeacherId() {
        return Math.floor(1000 + Math.random() * 9000);
      }
      document.getElementById("admissionNumber").addEventListener("focus", function () {
        this.value = generateTeacherId();
      });
    </script>
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