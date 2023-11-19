<?php
require_once('dbconnection.php');

if(isset($_POST['selectEvent'])) {
    $eventname = $_POST['eventname'];

    $sql = "SELECT * FROM attendancerecord WHERE eventname = '$eventname'";
    $result = $connection->query($sql);

    header("Location: attendance.php?eventname=$eventname");
}
?>
