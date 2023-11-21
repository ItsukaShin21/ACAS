<?php
if (isset($_POST['addEvent'])) {
    $eventName = mysqli_real_escape_string($connection, $_POST['eventName']);
    $eventDate = mysqli_real_escape_string($connection, $_POST['eventDate']);
    $eventStart = mysqli_real_escape_string($connection, $_POST['eventtimeStart']);
    $eventEnd = mysqli_real_escape_string($connection, $_POST['eventtimeEnd']);

    // Check if the event already exists
    $checkSql = "SELECT * FROM events WHERE eventname = '$eventName' AND eventdate = '$eventDate' AND eventstart = '$eventStart' AND eventend = '$eventEnd'";
    $checkResult = $connection->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo "<p style='color: red; font-size: 11px;'>Event Name is already used</p>";
    } else {
        // Event does not exist, proceed with insertion
        $sql = "INSERT INTO events (eventname, eventdate, eventstart, eventend) VALUES ('$eventName', '$eventDate', '$eventStart', '$eventEnd')";
        $connection->query($sql);
    }
}
?>
