<?php
if(isset($_POST['clearAttendance']) && isset($_GET['eventname'])) {
    $eventname = $_GET['eventname'];

    $sql = "DELETE FROM attendancerecord WHERE eventname = '$eventname'";

    if($connection->query($sql)) {
        header("Location: attendance.php?eventname=$eventname");
    }
}
?>