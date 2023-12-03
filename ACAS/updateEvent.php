<?php
if (isset($_POST['updateEvent'])) {
    $eventid = $_POST['eventID'];
    $eventname = $_POST['eventName'];
    $eventdate = $_POST['eventDate'];
    $eventstart = $_POST['eventtimeStart'];
    $eventend = $_POST['eventtimeEnd'];

    // Check if the event is changed
    $checkSql = "SELECT * FROM events WHERE eventname = '$eventname' AND eventdate = '$eventdate' AND eventstart = '$eventstart' AND eventend = '$eventend'";
    $checkExistingSql = "SELECT * FROM events WHERE eventname = '$eventname' AND eventID != $eventid";
    $resultExisting = $connection->query($checkExistingSql);
    $resultCheck = $connection->query($checkSql);

    if ($resultCheck->num_rows > 0) {
        echo "<p style='font-size: 12px; color: red;'>Change something first</p>";
    } elseif ($resultExisting->num_rows > 0) {
        echo "<p style='font-size: 12px; color: red;'>Event Name is already used</p>";
    } else {
        // Update the event
        $updateSql = "UPDATE events SET eventname = '$eventname', eventdate = '$eventdate', eventstart = '$eventstart', eventend = '$eventend' WHERE eventID = $eventid";
        $connection->query($updateSql);

        echo "<script>
        alert('The event has been updated');
        window.location.href = 'eventPage.php';
        </script>";
    }
}
?>
