<?php
if (isset($_POST['addEvent'])) {
    $eventId = $_POST['eventID'];
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventStart = $_POST['eventtimeStart'];
    $eventEnd = $_POST['eventtimeEnd'];

    // Check if the event already exists
    $checkSql2 = "SELECT * FROM events WHERE eventname = '$eventName' AND eventdate = '$eventDate' AND eventstart = '$eventStart' AND eventend = '$eventEnd'";
    $checkSql3 = "SELECT * FROM events WHERE eventname = '$eventName'";

    // Using regular SQL queries
    $result2 = $connection->query($checkSql2);
    $result3 = $connection->query($checkSql3);
    if ($eventId !== '') {
        echo "<p style='color: red; font-size: 11px;'>Don't add if you want to edit</p>";
    } elseif ($result3->num_rows > 0) {
        echo "<p style='color: red; font-size: 11px;'>Event Name is already used</p>";
    } elseif ($result2->num_rows > 0) {
        echo "<p style='color: red; font-size: 11px;'>Event is already existing</p>";
    } else {
        // Event does not exist, proceed with insertion
        $insertSql = "INSERT INTO events (eventname, eventdate, eventstart, eventend) VALUES ('$eventName', '$eventDate', '$eventStart', '$eventEnd')";
        $connection->query($insertSql);

        echo "<script>
                alert('Event added successfully');
                window.location.href = 'eventPage.php';
              </script>";
    }
}
?>
