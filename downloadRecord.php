<?php
error_reporting(0);
$con = mysqli_connect('localhost', 'root', '', 'ns_institute');
$filename = "Attendance_list_" . date("Y-m-d") . ".xls"; // Include the date in the filename
$cnt = 1;
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $filename);
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="5%" style="background-color:pink;">
    <thead>
        <center style="padding:5%; color:blue; background-color:pink;"><b>NS_Institute Students details</b></center>
        <tr>
            <th>Sno.</th>
            <th>First Name</th>
            <th>Father's Name</th>
            <th>Admission No</th>
            <th>Class</th>
            <th>Contact</th>
            <th>Attendance</th>
        </tr>
    </thead>
    <?php
    $dateTaken = date("Y-m-d");
    $studentQuery = "SELECT * FROM `students`";
    $studentResult = mysqli_query($con, $studentQuery);
    if (mysqli_num_rows($studentResult) > 0) {
        while ($studentRow = mysqli_fetch_array($studentResult)) {
            $studentId = $studentRow['id'];
            $studentName = $studentRow['student_name'];
            $fatherName = $studentRow['father_name'];
            $admissionNumber = $studentRow['admissionNumber'];
            $classId = $studentRow['class_id'];
            $phone = $studentRow['phone'];
            $attendanceQuery = "SELECT * FROM `attendance` WHERE student_id = $studentId AND curr_date = '$dateTaken'";
            $attendanceResult = mysqli_query($con, $attendanceQuery);
            $attendanceStatus = mysqli_num_rows($attendanceResult) > 0 ? 'Present' : 'Absent';
            echo "
<tr>
    <td>{$cnt}</td>
    <td>{$studentName}</td>
    <td>{$fatherName}</td>
    <td>{$admissionNumber}</td>
    <td>{$classId}</td>
    <td>{$phone}</td>
    <td>{$attendanceStatus}</td>
</tr>
";
            $cnt++;
        }
    } else {
        echo "<tr><td colspan='7'>No student records found</td></tr>";
    }
    ?>
</table>
<?php
mysqli_close($con);
?>