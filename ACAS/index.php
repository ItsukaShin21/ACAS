<?php
    require_once('dbconnection.php');
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href = "./css/styles.css">
    <script src = "./script/jqueryscript.js"></script>
    <script src = "./script/sheetjs.js"></script>
    <script src = "./script/script.js"></script>
    <title>ACAS</title>
</head>
<body class = "indexBody">
    <div class = "headerContainer">
        <img src = "./images/ACAS logo.png" class = "acasLogo">
        <nav>
            <a href="eventPage.php">Event</a>
            <button class = "exportBtn" onclick = "exportToExcel('attendanceTable')">Export</button>
            <a href="">Log out</a>
        </nav>
    </div>
    <div class = "mainContainer">
        <div class = "navContainer">
            <form method = "POST" class = "rfidtxtBox">
                <input type = "password" placeholder = "RFID" name = "rfid" id = "rfid" oninput = "storeData()">
            </form>
        </div>
        <div class = "attendanceContainer">
                <?php
                    require_once('addStudent.php');
                    require_once('viewData.php');
                ?>
        </div>
    </div>
</body>
</html>