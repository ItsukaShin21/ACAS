<?php
$eventid = $eventname = $eventdate = $eventstart = $eventend = '';

if (isset($_POST['editEvent'])) {
    $eventname = $_POST['eventname'];

    $sql = "SELECT * FROM events WHERE eventname = '$eventname'";
    $result = $connection->query($sql);

            // Assuming there's only one result since event names are usually unique
            $row = $result->fetch_assoc();
            $eventid = $row['eventID'];
            $eventname = $row['eventname'];
            $eventdate = $row['eventdate'];
            $eventstart = $row['eventstart'];
            $eventend = $row['eventend'];
}
?>
