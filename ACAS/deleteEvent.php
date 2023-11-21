<?php
    if(isset($_POST['deleteEvent'])) {
        $eventname = $_POST['eventname'];

        $sql = "DELETE FROM events WHERE eventname = '$eventname'";
        $sql = "DELETE FROM attendancerecord WHERE eventname = '$eventname'";
        $connection->query($sql);
        $connection->query($sql);
    }
?>