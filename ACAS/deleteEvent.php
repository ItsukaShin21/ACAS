<?php
    if(isset($_POST['deleteEvent'])) {
        $eventname = $_POST['eventname'];

        $sql1 = "DELETE FROM events WHERE eventname = '$eventname'";
        $sql2 = "DELETE FROM attendancerecord WHERE eventname = '$eventname'";
        $connection->query($sql1);
        $connection->query($sql2);

        $sql3 = "SELECT * FROM events WHERE eventname = '$eventname'";

        $result = $connection -> query($sql3);

        $row = $result->fetch_assoc();
            $eventid = $row['eventid'];
            $eventname = $row['eventname'];

            $sql = "DELETE FROM events WHERE eventid = '$eventid'";
            $sql2 = "DELETE FROM attendancerecord WHERE eventname = '$eventname'";

            $connection -> query($sql);
            $connection -> query($sql2);

            header("Location: eventPage.php");
    }
?>