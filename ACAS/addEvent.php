<?php
require_once('dbconnection.php');

if (isset($_POST['addEvent'])) {
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];

    $sql = "INSERT INTO events (eventname, eventdate) VALUES ('$eventName', '$eventDate')";
    $connection -> query($sql);
}
?>