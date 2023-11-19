<?php
$eventname = $eventdate = $eventstart = $eventend = '';

if (isset($_POST['editEvent'])) {
    $eventname = $_POST['eventname'];

    $sql = "SELECT * FROM events WHERE eventname = '$eventname'";
    $result = $connection->query($sql);

    while ($row = $result->fetch_assoc()) {
        $eventid = $row['eventID'];
        $eventname = $row['eventname'];
        $eventdate = $row['eventdate'];
        $eventstart = $row['eventstart'];
        $eventend = $row['eventend'];
    }
}
?>