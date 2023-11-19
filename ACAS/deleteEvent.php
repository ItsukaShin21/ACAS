<?php
    if(isset($_POST['deleteEvent'])) {
        $eventname = $_POST['eventname'];

        $sql = "DELETE FROM events WHERE eventname = '$eventname'";
        $connection->query($sql);
    }
?>