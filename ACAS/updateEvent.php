<?php
if(isset($_POST['updateEvent'])) {
    $eventid = $_POST['eventID'];
    $eventname = $_POST['eventName'];
    $eventdate = $_POST['eventDate'];
    $eventstart = $_POST['eventtimeStart'];
    $eventend = $_POST['eventtimeEnd'];

    // Check if the event name is already used
    $checkSql = "SELECT * FROM events WHERE eventname = ? AND eventdate = ? AND eventstart = ? AND eventend = ?";
    $stmtCheck = $connection->prepare($checkSql);
    $stmtCheck->bind_param("ssss", $eventname, $eventdate, $eventstart, $eventend);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        echo "<p style='font-size: 12px; color: red;'>Event Name is already used</p>";
    } else {
        // Update the event
        $updateSql = "UPDATE events SET eventname = ?, eventdate = ?, eventstart = ?, eventend = ? WHERE eventID = ?";
        $stmtUpdate = $connection->prepare($updateSql);
        $stmtUpdate->bind_param("ssssi", $eventname, $eventdate, $eventstart, $eventend, $eventid);
        $stmtUpdate->execute();

        header("Location: eventPage.php");
        exit();
    }
}
?>
