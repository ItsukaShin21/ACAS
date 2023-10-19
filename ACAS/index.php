<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href = "./css/styles.css">
    <script src = "./script/script.js"></script>
    <title>ACAS</title>
</head>
<body>
    <div class = "headerContainer">
        <img src = "./images/LNU logo.png" class = "lnuLogo">
        <img src = "./images/LNU title.png" class = "lnuTitle">
        <p class = "headerTitle">HRDC GYM AUTOMATED CONTACTLESS ATTENDANCE SYSTEM</p>
    </div>
    <div class = "mainContainer">
        <div class = "navContainer">
            <p class = "navHeader">DASHBOARD</p>
            <form method = "POST" class = "rfidtxtBox">
                <input type = "password" placeholder = "RFID" name = "rfid" id = "rfid" oninput="storeData()">
            </form>
        </div>
        <div class = "attendanceContainer">
            <div class = "attendanceheaderContainer">
                <p class = "attendanceHeader">ATTENDANCE</p>
            </div>
                <?php
                    require_once('dbconnection.php');
                    require_once('addStudent.php');
                    require_once('viewData.php');
                ?>
        </div>
    </div>
</body>
</html>