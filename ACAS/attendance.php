<?php
    session_start(); // Start the session

    if (!isset($_SESSION['rfiduid'])) {
        header("Location: loginPage.php");
        exit();
    }
    
    require_once('dbconnection.php');
    require_once('addStudent.php');
?>
<!DOCTYPE html>
<html>
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
            <a href="logout.php">Log out</a>
        </nav>
    </div>
    <div class = "mainContainer">
        <div class = "navContainer">
            <form method = "POST" class = "rfidtxtBox">
                <input type = "password" placeholder = "RFID" name = "rfiduid" id = "rfiduid">
            </form>
            <?php
                require_once('eventInfo.php');
            ?>
            <script>
$('#rfiduid').on('input', function() {
    let rfidData = $(this).val();

    // Extract eventname from the current URL
    let eventName = getParameterByName('eventname');

    // Use jQuery AJAX to send data to the server
    $.ajax({
        type: 'POST',
        url: 'attendance.php?eventname=' + encodeURIComponent(eventName),
        data: { rfiduid: rfidData },
        success: function(response) {
            // Reload the page after the data is successfully sent
            console.log(rfidData);
            location.reload();
        }
    });
});

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
            </script>
        </div>
        <div class = "attendanceContainer">
                <?php
                    require_once('viewData.php');
                ?>
        </div>
    </div>
</body>
</html>