<?php
    session_start();
    require_once('dbconnection.php');

    $rfid = "";
    $password = "";
    $errorMessage = "";

    if(isset($_POST['login'])) {
        $rfid = $_POST['rfid'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM accounts WHERE rfiduid = '$rfid'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password === $row['password']) {
                // Login successful, redirect
                $_SESSION['rfiduid'] = $rfid;
                echo "<script>
                alert('Login Successfully');
                window.location.href = 'eventPage.php';
                </script>";
                exit();
            } else {
                $errorMessage = "Invalid password";
            }
        } else {
            $errorMessage = "User not found";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href = "./css/loginpageStyle.css">
    <script src = "./script/jqueryscript.js"></script>
    <script src = "./script/script.js"></script>
    <title>ACAS</title>
</head>
<body class = "loginBody">
    <div class = "loginContainer">
        <img src = "./images/ACAS logo.png" class = "acasLogo">
    </div>
    <div class = "mainSection">
            <div class = "loginForm">
                <p>LOGIN</p>
                <?php
                    if (!empty($errorMessage)) {
                        echo '<p style = "font-size: 12px; color: red">' . $errorMessage . '</p>';
                        $rfid = "";
                        $password = "";
                    }
                ?>
                <form method = "POST">
                    <input type = "password" name = "rfid" placeholder = "RFID" id = "rfid" value = "<?php echo $rfid; ?>" required>
                    <input type = "password" name = "password" placeholder = "Password" id = "password" value = "<?php echo $password; ?>" required>
                    <input type = "submit" id = "login" name = "login" value = "LOGIN">
                </form>
            </div>
        </div>
</body>
</html>