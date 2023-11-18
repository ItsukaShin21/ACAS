<?php
require_once('dbconnection.php');

if(isset($_POST['selectEvent'])) {
    $eventname = $_POST['eventname'];

    $sql = "SELECT * FROM attendancerecord WHERE eventname = '$eventname'";
    $result = $connection->query($sql);

    $url = "index.php?eventname=$eventname";
    header("Location: $url");
    exit();
}
?>
