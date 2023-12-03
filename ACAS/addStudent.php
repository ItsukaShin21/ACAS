<?php
if (isset($_POST['rfiduid']) && isset($_GET['eventname'])) {
    $rfidData = $_POST['rfiduid'];
    $eventname = $_GET['eventname'];

    date_default_timezone_set('Etc/GMT+8');
    $currentTimestamp = date('Y-m-d H:i:s');

    // Check if there's an existing record with timein
    $sqlCheck = "SELECT * FROM attendancerecord 
                WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = '$rfidData' OR studentid = '$rfidData')
                AND eventname = '$eventname'";
    $result = $connection->query($sqlCheck);

    $row = $result->fetch_assoc();

    if (!$row) {
        // No existing record, so insert a new one with timein
        // Check if the event is still ongoing based on the event date
        $sqlEventDateCheck = "SELECT eventdate FROM events WHERE eventname = '$eventname'";
        $resultEventDate = $connection->query($sqlEventDateCheck);
        $rowEventDate = $resultEventDate->fetch_assoc();

        $eventdate = date('Y-m-d', strtotime($rowEventDate['eventdate']));
        date_default_timezone_set('Etc/GMT+8');
        $currentDate = date('Y-m-d');

        if ($eventdate === $currentDate) {
            // Check if the last insertion for the same rfiduid was within the last 10 seconds
            $sqlLastInsertionCheck = "SELECT MAX(updated_at) AS last_insertion_time FROM attendancerecord 
                                      WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = '$rfidData' OR studentid = '$rfidData' AND eventname = '$eventname')";
            $resultLastInsertion = $connection->query($sqlLastInsertionCheck);
            $rowLastInsertion = $resultLastInsertion->fetch_assoc();

            $lastInsertionTime = strtotime($rowLastInsertion['last_insertion_time']);
            date_default_timezone_set('Etc/GMT+8');
            $currentTime = strtotime(date('H:i:s'));

            $timeDifference = $currentTime - $lastInsertionTime;

            if ($timeDifference >= 10) {
                $sqlqueryAdd = "INSERT INTO attendancerecord (eventname, studentid, timein, status, updated_at)
                                SELECT  '$eventname', studentid, NOW(), 'ABSENT', '$currentTimestamp'
                                FROM students
                                WHERE rfiduid = '$rfidData' OR studentid = '$rfidData'";

                $connection->query($sqlqueryAdd);

                header("Location: attendance.php?eventname=$eventname");
            } else {
                echo "<script>alert('Please wait for 10 seconds before inserting the same RFID UID again.');</script>";
            }
        } else {
            echo "<script>alert('The event is already finished');</script>";
        }
    } elseif ($row['timein'] !== '00:00:00' && $row['timeout'] === '00:00:00') {
        // Student has timein but no timeout, so insert a new timeout

        // Check if the event is still ongoing based on the event date
        $sqlEventDateCheck = "SELECT eventdate FROM events WHERE eventname = '$eventname'";
        $resultEventDate = $connection->query($sqlEventDateCheck);
        $rowEventDate = $resultEventDate->fetch_assoc();

        $eventdate = date('Y-m-d', strtotime($rowEventDate['eventdate']));
        date_default_timezone_set('Etc/GMT+8');
        $currentDate = date('Y-m-d');

        if ($eventdate === $currentDate) {

            $sqlLastInsertionCheck = "SELECT MAX(updated_at) AS last_insertion_time FROM attendancerecord 
                                        WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = '$rfidData' OR studentid = '$rfidData' AND eventname = '$eventname')";
            $resultLastInsertion = $connection->query($sqlLastInsertionCheck);
            $rowLastInsertion = $resultLastInsertion->fetch_assoc();

            $lastInsertionTime = strtotime($rowLastInsertion['last_insertion_time']);
            date_default_timezone_set('Etc/GMT+8');
            $currentTime = strtotime(date('H:i:s'));

            $timeDifference = $currentTime - $lastInsertionTime;

            if ($timeDifference >= 10) {
                $sqlqueryUpdate = "UPDATE attendancerecord
                SET timeout = NOW(), updated_at = '$currentTimestamp'
                WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = '$rfidData' OR studentid = '$rfidData')
                AND eventname = '$eventname'";

                $sqlquerystatus = "UPDATE attendancerecord
                    SET status = (
                        SELECT 
                            CASE 
                                WHEN (
                                    TIME_TO_SEC(TIMEDIFF(
                                        attendancerecord.timeout, 
                                        attendancerecord.timein
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
                    WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = '$rfidData' OR studentid = '$rfidData')
                    AND eventname = '$eventname'";

                $connection->query($sqlqueryUpdate);
                $connection->query($sqlquerystatus);

                header("Location: attendance.php?eventname=$eventname");
            } else {
                echo "<script>alert('Please wait for 10 seconds to scan the same RFID');</script>";
            }
        } else {
            echo "<script>alert('The event is already finished');</script>";
        }
    } else {
        // Student already has both timein and timeout, display a message
        echo "<script>alert('Student is already recorded');</script>";
    }
}
?>