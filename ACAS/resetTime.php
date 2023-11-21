<?php
require_once("dbconnection.php");
if(isset($_POST['timeIn'])) {
    $timein = $_POST['timeIn'];
    $studentid = $_POST['studentid'];
 
    $sql = "UPDATE attendancerecord SET timein = '-' WHERE studentid = '$studentid'";
    if ($connection->query($sql) === TRUE) {
        echo "Record updated successfully";
     } else {
        echo "Error updating record: " . $connection->error;
     }
 }
?>