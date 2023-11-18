<?php
    require_once('dbconnection.php');
    require_once('addEvent.php');
    require_once('eventattendanceFetcher.php');
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href = "./css/styles.css">
    <script src = "./script/jqueryscript.js"></script>
    <script src = "./script/script.js"></script>
    <title>ACAS</title>
</head>
<body class = "indexBody">
    <div class = "eventheaderContainer">
        <img src = "./images/ACAS logo.png" class = "acasLogo">
        <nav>
            <a href="">Event</a>
            <a href="">Log out</a>
        </nav>
    </div>
    <div class = "mainContainer">
        <div class = "navContainer">
            <form method="POST" class="rfidtxtBox">
                <p>EVENTS</p>
                <div class="eventList">
                    <select name="eventname" id="eventname">
                        <option value="" disabled selected>Choose event</option>
                            <?php require_once('viewEvents.php');?>
                    </select>
                    <input type="hidden" name="selectedEvent" id="selectedEvent" value="">
                    <input type="submit" name="selectEvent" value="START ATTENDANCE">
                </div>
            </form>
        </div>
        <div class = "eventContainer">
            <div class = "eventForm">
                <p>NEW EVENT</p>
                <form method = "POST">
                    <input type = "text" name = "eventName" class = "eventtxtBox" placeholder = "Event Name">
                    <input type = "date" name = "eventDate" class = "eventtxtBox" placeholder = "Event Date">
                    <input type = "submit" id = "addEvent" name = "addEvent" class = "eventSubmit" value = "ADD EVENT">
                </form>
            </div>
        </div>
    </div>
</body>
</html>