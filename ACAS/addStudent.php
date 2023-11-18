<?php
require_once('dbconnection.php');

if (isset($_POST['rfid']) && isset($_GET['eventname'])) {
    $rfidData = mysqli_real_escape_string($connection, $_POST['rfid']); // Use prepared statements
    $eventname = mysqli_real_escape_string($connection, $_GET['eventname']);

    // Check if there's an existing record with timein
    $sqlCheck = "SELECT * FROM attendancerecord 
                 WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = '$rfidData' AND eventname = '$eventname')";
    $result = $connection->query($sqlCheck);

    if (!$result) {
        die("Error checking attendance record: " . $connection->error);
    }

    $row = $result->fetch_assoc();

    if (!$row) {
        // No existing record, so insert a new one with timein
        $sqlqueryAdd = "INSERT INTO attendancerecord (eventname, studentid, timein)
                        SELECT  '$eventname' AS eventname, studentid, TIME_FORMAT(NOW(), '%h:%i %p') AS formatted_time
                        FROM students
                        WHERE rfiduid = '$rfidData'";

        if (!$connection->query($sqlqueryAdd)) {
            die("Error adding attendance record: " . $connection->error);
        }
    } elseif ($row['timein'] !== '-' && $row['timeout'] === '-') {
        // Student has timein but no timeout, so insert a new timeout
        $sqlqueryUpdate = "UPDATE attendancerecord
                            SET timeout = TIME_FORMAT(NOW(), '%h:%i %p')
                            WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = '$rfidData')";

        if (!$connection->query($sqlqueryUpdate)) {
            die("Error updating attendance record: " . $connection->error);
        }
    } else {
        // Student already has both timein and timeout, display a message
        echo "<script>alert('Student is already recorded');</script>";
    }
}
?>
