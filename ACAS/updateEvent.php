<?php
    if(isset($_POST['updateEvent'])) {
        $eventid = $_POST['eventID'];
        $eventname = $_POST['eventName'];
        $eventdate = $_POST['eventDate'];
        $eventstart = $_POST['eventtimeStart'];
        $eventend = $_POST['eventtimeEnd'];

        $sql = "SELECT * FROM events WHERE eventname = '$eventname'";
        $checkResult = $connection->query($sql);

        if ($checkResult && $checkResult->num_rows > 0) {
            echo "<p style = 'font-size: 12px; color: red;'>Event Name is already used</p>";
        } else {
            $sql = "UPDATE events SET eventname = '$eventname', eventdate = '$eventdate', eventstart = '$eventstart', eventend = '$eventend'
            WHERE eventID = '$eventid'";

            $connection->query($sql);
            header("Location: eventPage.php");
            exit();
        }
    }
?>