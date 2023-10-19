<?php
require_once('dbconnection.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rfidData = $_POST['rfid'];

        $sqlqueryAdd = "INSERT INTO attendancerecord (idnumber, name, program, timein)
        SELECT studentid, name, program, TIME_FORMAT(NOW(), '%h:%i %p') AS formatted_time
        FROM students
        WHERE rfiduid = '$rfidData';";
        $connection -> query($sqlqueryAdd);
    }

?>