<?php
    session_start(); // Start the session

    if (!isset($_SESSION['rfiduid'])) {
        header("Location: loginPage.php");
        exit();
    }

    require_once('dbconnection.php');
    require_once('eventattendanceFetcher.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href = "./css/eventpageStyle.css">
    <script src = './script/jqueryscript.js'></script>
    <script src = './script/script.js'></script>
    <title>ACAS</title>
</head>
<body class = "eventpageBody">
    <div class = "eventheaderContainer">
        <img src = "./images/ACAS logo.png" class = "acasLogo">
        <nav>
            <a href="eventPage.php">Event</a>
            <a href="logout.php">Log out</a>
        </nav>
    </div>
    <div class = "mainContainer">
        <div class = "navContainer">
            <form method="POST" class="rfidtxtBox">
                <p>EVENTS</p>
                <div class="eventList">
                    <select name="eventname" id="eventname" required>
                        <option value="" disabled selected>Choose event</option>
                            <?php require_once('viewEvents.php');?>
                    </select>
                    <input type="submit" name="selectEvent" value="START ATTENDANCE">
                    <input type="submit" name="editEvent" value="EDIT EVENT">
                    <input type="submit" id = "deleteEvent" name="deleteEvent" value="DELETE EVENT">
                </div>
            </form>
        </div>
        <div class = "eventContainer">
            <div class = "eventForm">
                <p>NEW EVENT</p>
                <?php
                    require_once('addEvent.php');
                    require_once('updateEvent.php');
                    require_once('deleteEvent.php');
                ?>
                <form method = "POST">
                    <input type="hidden" name = "eventID" id = "eventID"
                        value = "<?php require('eventFetcher.php'); echo $eventid?>">
                    <div>
                        <label for = "eventName">Event Name:</label>
                        <input type = "text" name = "eventName" placeholder = "Event Name" id = "eventName" 
                            value = "<?php require('eventFetcher.php'); echo $eventname?>" required>
                    </div>
                    <div>
                        <label for = "eventDate">Event Date:</label>
                        <input type = "date" name = "eventDate" id = "eventDate"
                            value = "<?php require('eventFetcher.php'); echo $eventdate?>" required>
                    </div>
                    <div>
                        <label for = "eventtimeStart">Event Start:</label>
                        <input type = "time" name = "eventtimeStart" id = "eventtimeStart"
                            value = "<?php require('eventFetcher.php'); echo $eventstart?>" required>
                    </div>
                    <div>
                        <label for = "eventtimeEnd">Event End:</label>
                        <input type="time" name = "eventtimeEnd" id = "eventtimeEnd"
                            value = "<?php require('eventFetcher.php'); echo $eventend?>" required>
                    </div>
                        <input type = "submit" id = "addEvent" name = "addEvent" value = "ADD EVENT">
                        <input type = "submit" id = "updateEvent" name = "updateEvent" value = "UPDATE EVENT">
                </form>
            </div>
        </div>
    </div>
</body>
</html>