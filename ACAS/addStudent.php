<?php
require_once('dbconnection.php');

if (isset($_POST['rfiduid']) && isset($_GET['eventname'])) {
    $rfidData = $_POST['rfiduid'];
    $eventname = $_GET['eventname'];

    $currentTimestamp = date('Y-m-d H:i:s');

    // Check if 10 seconds have passed since the last insert for the same RFID data
    $sqlTimestampCheck = "SELECT MAX(updated_at) AS last_updated FROM attendancerecord 
        WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = ? AND eventname = ?)";
    $stmtTimestampCheck = $connection->prepare($sqlTimestampCheck);
    $stmtTimestampCheck->bind_param("ss", $rfidData, $eventname);
    $stmtTimestampCheck->execute();
    $resultTimestampCheck = $stmtTimestampCheck->get_result();

    $lastUpdatedRow = $resultTimestampCheck->fetch_assoc();
    $lastUpdated = strtotime($lastUpdatedRow['last_updated']);
    $currentTime = strtotime($currentTimestamp);

    $timeDifference = $currentTime - $lastUpdated;

    if ($timeDifference >= 10) {
        // Continue with the rest of the logic if 10 seconds or more have passed

        $sql = "SELECT * FROM events WHERE eventname = ?";
        $stmtEvent = $connection->prepare($sql);
        $stmtEvent->bind_param("s", $eventname);
        $stmtEvent->execute();
        $result = $stmtEvent->get_result();

        $row = $result->fetch_assoc();
        $eventdate = date('m-d-Y', strtotime($row['eventdate']));

        $currentDate = date('m-d-Y');

        if ($eventdate === $currentDate) {
            // Check if there's an existing record with timein
            $sqlCheck = "SELECT * FROM attendancerecord 
                        WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = ? AND eventname = ?)";
            $stmtCheck = $connection->prepare($sqlCheck);
            $stmtCheck->bind_param("ss", $rfidData, $eventname);
            $stmtCheck->execute();
            $result = $stmtCheck->get_result();

            $row = $result->fetch_assoc();

            if (!$row) {
                // No existing record, so insert a new one with timein
                $sqlqueryAdd = "INSERT INTO attendancerecord (eventname, studentid, timein, status, updated_at)
                                SELECT  ?, studentid, NOW(), 'ABSENT', ?
                                FROM students
                                WHERE rfiduid = ? OR studentid = ?";
                $stmtAdd = $connection->prepare($sqlqueryAdd);
                $stmtAdd->bind_param("ssss", $eventname, $currentTimestamp, $rfidData, $rfidData);

                if (!$stmtAdd->execute()) {
                    die("Error adding attendance record: " . $stmtAdd->error);
                }
                header("Location: attendance.php?eventname=$eventname");
            } elseif ($row['timein'] !== '00:00:00' && $row['timeout'] === '00:00:00') {
                // Student has timein but no timeout, so insert a new timeout
                $sqlqueryUpdate = "UPDATE attendancerecord
                                    SET timeout = NOW(), updated_at = ?
                                    WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = ? OR studentid = ?)
                                    AND eventname = ?";
                $stmtUpdate = $connection->prepare($sqlqueryUpdate);
                $stmtUpdate->bind_param("ssss", $currentTimestamp, $rfidData, $rfidData, $eventname);

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
                                    WHERE studentid = (SELECT studentid FROM students WHERE rfiduid = ? OR studentid = ?)
                                    AND eventname = ?";
                $stmtStatus = $connection->prepare($sqlquerystatus);
                $stmtStatus->bind_param("ssss", $rfidData, $rfidData, $eventname);

                $stmtUpdate->execute();
                $stmtStatus->execute();

                header("Location: attendance.php?eventname=$eventname");
            } else {
                // Student already has both timein and timeout, display a message
                echo "<script>alert('Student is already recorded');</script>";
            }
        } else {
            echo "<script>alert('The event is already finished');</script>";
        }
    } else {
        echo "<script>alert('Please wait at least 10 seconds before scanning again');</script>";
    }
}
?>
