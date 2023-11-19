<?php
    $sqlviewEvents = "SELECT * FROM events";
    $list = $connection -> query($sqlviewEvents);

    if($list -> num_rows > 0) {
        while($row = $list -> fetch_assoc()) {
            $eventname = $row['eventname'];

            echo '<option value = "'. $eventname .'">'. $eventname .'</option>';
        }
    }