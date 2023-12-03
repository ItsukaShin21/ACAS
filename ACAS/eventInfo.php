<?php
if(isset($_GET['eventname'])) {
    $eventname = $_GET['eventname'];

    $sql = "SELECT * FROM events WHERE eventname = '$eventname'";
    $result = $connection->query($sql);

    while($row = $result->fetch_assoc()) {
        $event = $row['eventname'];
        $eventstart = date("g:i A", strtotime($row['eventstart'])); // Format to display time with AM/PM
        $eventend = date("g:i A", strtotime($row['eventend'])); // Format to display time with AM/PM
        $eventdate = date("m-d-Y", strtotime($row['eventdate']));

        echo "
            <div class = 'eventInfo'>
                <h4>Event Info</h4>
                <p>Event Name</p>
                <p>".$event."</p>
                <p>Event Date</p>
                <p>".$eventdate."</p>
                <p>Event Start</p>
                <p>".$eventstart."</p>
                <p>Event End</p>
                <p>".$eventend."</p>
            </div>
        ";
    }
}
?>