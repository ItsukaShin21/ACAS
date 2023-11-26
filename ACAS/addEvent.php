<?php
if (isset($_POST['addEvent'])) {
    $eventID = $_POST['eventID'];
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventStart = $_POST['eventtimeStart'];
    $eventEnd = $_POST['eventtimeEnd'];

    // Check if the event already exists
    $checkSql1 = "SELECT * FROM events WHERE eventID = ?";
    $checkSql2 = "SELECT * FROM events WHERE eventname = ?";
    $checkSql3 = "SELECT * FROM events WHERE eventname = ? AND eventdate = ? AND eventstart = ? AND eventend = ?";

    // Using prepared statements
    $stmt1 = $connection->prepare($checkSql1);
    $stmt1->bind_param("i", $eventID);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    
    $stmt2 = $connection->prepare($checkSql2);
    $stmt2->bind_param("s", $eventName);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $stmt3 = $connection->prepare($checkSql3);
    $stmt3->bind_param("ssss", $eventName, $eventDate, $eventStart, $eventEnd);
    $stmt3->execute();
    $result3 = $stmt3->get_result();

    if ($result1->num_rows > 0) {
        echo "<p style='color: red; font-size: 11px;'>Don't add if you want to edit</p>";
    } elseif ($result2->num_rows > 0) {
        echo "<p style='color: red; font-size: 11px;'>Event Name is already used</p>";
    } elseif ($result3->num_rows > 0) {
        echo "<p style='color: red; font-size: 11px;'>Event already exists</p>";
    } else {
        // Event does not exist, proceed with insertion
        $insertSql = "INSERT INTO events (eventname, eventdate, eventstart, eventend) VALUES (?, ?, ?, ?)";
        $stmtInsert = $connection->prepare($insertSql);
        $stmtInsert->bind_param("ssss", $eventName, $eventDate, $eventStart, $eventEnd);
        $stmtInsert->execute();

        header("Location: eventPage.php");
    }
}
?>
