<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'ns_institute');
$firstDayOfMonth = date("1-m-Y");
$totalDaysInMonth = date("t", strtotime($firstDayOfMonth)); 
$fetchingStudents = mysqli_query($con, "SELECT * FROM students") or die(mysqli_error($con));
$totalNumberOfStudents = mysqli_num_rows($fetchingStudents);
$studentsNamesArray = array();
$studentsIDsArray = array();
$counter = 0;
while ($students = mysqli_fetch_assoc($fetchingStudents)) {
    $studentsNamesArray[] = $students['student_name'];
    $studentsIDsArray[] = $students['id'];
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
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include "Includes/sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "Includes/topbar.php"; ?>
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">view Attendance (Today's Date :
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
                                            <div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="card mb-4">
                                                            <div
                                                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                                <h6 class="m-0 font-weight-bold text-primary">All
                                                                    Student Attendance</h6>
                                                            </div>
                                                            <div class="table-responsive p-3">
                                                                <table
                                                                    class="table align-items-center table-flush table-hover"
                                                                    id="dataTableHover">
                                                                    <thead class="thead-light">
                                                                        <tr>
                                                                            <?php
                                                                            for ($i = 1; $i <= $totalNumberOfStudents + 2; $i++) {

                                                                                if ($i == 1) {
                                                                                    echo "<tr>";
                                                                                    echo "<td rowspan='2'>Students Name</td>";
                                                                                    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                                                                                        echo "<td>$j</td>";
                                                                                    }
                                                                                    echo "</tr>";
                                                                                } else if ($i == 2) {
                                                                                    echo "<tr>";
                                                                                    for ($j = 0; $j < $totalDaysInMonth; $j++) {
                                                                                        echo "<td>" . date("D", strtotime("+$j days", strtotime($firstDayOfMonth))) . "</td>";
                                                                                    }
                                                                                    echo "</tr>";
                                                                                } else {
                                                                                    echo "<tr>";
                                                                                    echo "<td>" . $studentsNamesArray[$counter] . "</td>";
                                                                                    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                                                                                        $dateOfAttendance = date("Y-m-$j");
                                                                                        $fetchingStudentsAttendance = mysqli_query($con, "SELECT attendance FROM attendance WHERE student_id = '" . $studentsIDsArray[$counter] . "' AND curr_date = '" . $dateOfAttendance . "'") or die(mysqli_error($con));
                                                                                        $isAttendanceAdded = mysqli_num_rows($fetchingStudentsAttendance);
                                                                                        if ($isAttendanceAdded > 0) {
                                                                                            $studentAttendance = mysqli_fetch_assoc($fetchingStudentsAttendance);
                                                                                            if ($studentAttendance['attendance'] == "Present") {
                                                                                                $color = "green";
                                                                                            } else if ($studentAttendance['attendance'] == "Absent") {
                                                                                                $color = "red";
                                                                                            }
                                                                                            echo "<td style='background-color: $color; color:white'>" . $studentAttendance['attendance'] . "</td>";
                                                                                        } else {
                                                                                            echo "<td></td>";
                                                                                        }
                                                                                    }
                                                                                    echo "</tr>";
                                                                                    $counter++;
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
</body>
</html>