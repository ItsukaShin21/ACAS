<?php
    if(isset($_POST['eventname'])) {
        $eventname = $_POST['eventname'];

        $sql = "SELECT * FROM events WHERE $eventname = '$eventname'";
        $result = $connection->query($sql);

        while($row = $result->fetch_assoc()) {
            $eventid = $row['eventID'];
        }
    }
    echo $eventid;
?>