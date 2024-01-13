<?php
error_reporting(0);
$statusMsg = "";
$con = mysqli_connect('localhost', 'root', '', 'ns_institute');
if (isset($_POST['save'])) {
    $Id = $_POST['id'];
    $teacherId = $_POST['teacherId'];
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $query = mysqli_query($con, "SELECT * FROM `create_teacher` WHERE `teacherId`='$teacherId'");
    $ret = mysqli_fetch_array($query);
    if ($ret > 0) {
        $statusMsg = "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'This Teacher ID already exists!'
            });
        </script>";
    } else {
        $query = mysqli_query($con, "INSERT INTO `create_teacher` (`teacherId`, `firstName`, `lastName`,`email`,`phone`) VALUES ('$teacherId','$first_name','$last_name','$email','$phone')");
        if ($query) {
            $statusMsg = "<script>
                Swal.fire({
                    title: 'Teacher Created Successfully!',
                    text: '',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location = 'CreateTeacher.php';
                });
            </script>";
        } else {
            $statusMsg = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred!',
                });
            </script>";
        }
    }
}
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "edit") {
    $Id = $_GET['id'];
    $query = mysqli_query($con, "SELECT * FROM `create_teacher` WHERE `id`='$Id'");
    $row = mysqli_fetch_array($query);
    if (isset($_POST['update'])) {
        $Id = $_POST['id'];
        $teacherId = $_POST['teacherId'];
        $first_name = $_POST['firstName'];
        $last_name = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $statusMsg = "<script>
            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don\'t save`
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, proceed with the update";
        $query = mysqli_query($con, "UPDATE `create_teacher` SET  `firstName`='$first_name',`lastName`='$last_name',`email`='$email',`phone`='$phone'  WHERE `teacherId`='$teacherId'");
        if ($query) {
            $statusMsg .= "Swal.fire('Saved!', '', 'success').then(() => {
                // Redirect to 'CreateTeacher.php' after a delay
                setTimeout(function(){
                    window.location.href = 'CreateTeacher.php';
                }, 2000);
            });";
        } else {
            $statusMsg .= "Swal.fire('Error!', 'An error occurred during update.', 'error');";
        }
        $statusMsg .= "
                } else {
                    // User chose not to save changes
                    Swal.fire('Changes are not saved', '', 'info');
                }
            });
        </script>";
    }
}
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "delete") {
    $Id = $_GET['id'];
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
                // User confirmed deletion, perform redirection
                window.location.href = '?action=confirmDelete&id=" . $Id . "';
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire(
                    'Cancelled',
                    'Deletion has been canceled.',
                    'info'
                ).then(() => {
                    // Redirect to 'CreateTeacher.php' after cancel
                    window.location.href = 'CreateTeacher.php';
                });
            }
        });
    </script>";
}
echo $statusMsg;
if (isset($_GET['action']) && $_GET['action'] == "confirmDelete" && isset($_GET['id'])) {
    $Id = $_GET['id'];
    $query = mysqli_query($con, "DELETE FROM `create_teacher` WHERE id='$Id'");
    if ($query) {
        echo "<script>
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            ).then(() => {
                window.location = 'CreateTeacher.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire(
                'Error!',
                'An error occurred during deletion.',
                'error'
            ).then(() => {
                window.location = 'CreateTeacher.php';
            });
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
    <link rel="shortcut icon" href="icon.png" type="image/x-icon" style="border-radius:20%;">
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
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Create Teacher</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create Teacher</li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Create Teacher</h6>
                                    <?php echo $statusMsg; ?>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">First Name<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input required type="text" class="form-control" name="firstName"
                                                    value="<?php echo $row['firstName']; ?>" id="exampleInputFirstName">
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Last Name<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input required type="text" class="form-control" name="lastName"
                                                    value="<?php echo $row['lastName']; ?>" id="exampleInputFirstName">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Contact<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input required maxlength="10" type="tel" class="form-control"
                                                    name="phone" value="<?php echo $row['phone']; ?>"
                                                    id="exampleInputFirstName">
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Email<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input required type="text" class="form-control" name="email"
                                                    value="<?php echo $row['email']; ?>" id="exampleInputFirstName">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Teacher Id<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" name="teacherId" readonly
                                                    value="<?php echo $row['teacherId']; ?>" id="teacherId">
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
                                        <div
                                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">All Teacher</h6>
                                        </div>
                                        <div class="table-responsive p-3">
                                            <table class="table align-items-center table-flush table-hover"
                                                id="dataTableHover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Sno.</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Contact</th>
                                                        <th>Email</th>
                                                        <th>Teacher Id</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT * FROM `create_teacher`";
                                                    $result = mysqli_query($con, $sql);
                                                    $sn = 0;
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $sn = $sn + 1;
                                                        echo "<tr>
                                                        <td>" . $sn . "</td>
                                                        <td>" . $row['firstName'] . "</td>
                                                        <td>" . $row['lastName'] . "</td>
                                                        <td>" . $row['phone'] . "</td>
                                                        <td>" . $row['email'] . "</td>
                                                        <td>" . $row['teacherId'] . "</td>
                                                        <td><a href='?action=edit&id=" . $row['id'] . "'><i class='fas fa-fw fa-edit'></i>Edit</a></td>
                                                        <td><a href='?action=delete&id=". $rows['id']. "' class='delete-button'><i class='fas fa-fw fa-trash'></i>Delete</a></td>                  
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
            document.getElementById("teacherId").addEventListener("focus", function () {
                this.value = generateTeacherId();
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
        <?php echo $statusMsg; ?>
    </body>
</html>