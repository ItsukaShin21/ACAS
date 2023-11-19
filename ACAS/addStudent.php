<?php
require_once('dbconnection.php');

if (isset($_POST['rfiduid']) && isset($_GET['eventname'])) {
    $rfidData = $_POST['rfiduid'];
    $eventname = mysqli_real_escape_string($connection, $_GET['eventname']);

    // Check if there's an existing record with timein
    $sqlCheck = "SELECT * FROM attendancerecord 
                 WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = '$rfidData' AND eventname = '$eventname')";
    $result = $connection->query($sqlCheck);

    $row = $result->fetch_assoc();

    if (!$row) {
        // No existing record, so insert a new one with timein
        $sqlqueryAdd = "INSERT INTO attendancerecord (eventname, studentid, timein, status)
                        SELECT  '$eventname' AS eventname, studentid, TIME_FORMAT(NOW(), '%h:%i %p') AS formatted_time, 'ABSENT' AS status
                        FROM students
                        WHERE rfiduid = '$rfidData' OR studentid = '$rfidData'";

        if (!$connection->query($sqlqueryAdd)) {
            die("Error adding attendance record: " . $connection->error);
        }
    } elseif ($row['timein'] !== '-' && $row['timeout'] === '-') {
        // Student has timein but no timeout, so insert a new timeout
        $sqlqueryUpdate = "UPDATE attendancerecord
                            SET timeout = TIME_FORMAT(NOW(), '%h:%i %p')
                            WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = '$rfidData' OR studentid = '$rfidData')";

        $sqlquerystatus = "UPDATE attendancerecord
                            SET status = (
                                SELECT 
                                    CASE 
                                        WHEN (
                                            TIME_TO_SEC(TIMEDIFF(
                                                STR_TO_DATE(attendancerecord.timeout, '%h:%i %p'), 
                                                STR_TO_DATE(attendancerecord.timein, '%h:%i %p')
                                            )) / 60
                                        ) >= (
                                            TIME_TO_SEC(TIMEDIFF(
                                                events.eventend, 
                                                events.eventstart
                                            )) / 60 * 0.7
                                        ) THEN 'PRESENT'
                                        ELSE 'ABSENT'
                                    END
                                FROM events
                                WHERE attendancerecord.eventname = events.eventname
                            )
                            WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = '$rfidData' OR studentid = '$rfidData')";

        $connection->query($sqlqueryUpdate);
        $connection->query($sqlquerystatus);
    } else {
        // Student already has both timein and timeout, display a message
        echo "<script>alert('Student is already recorded');</script>";
    }
    header("Location: attendance.php?eventname=$eventname");
}
?>
