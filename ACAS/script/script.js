function storeData() {
    let rfidData = document.getElementById("rfid").value;
    // Create a new AJAX request
    var xmlRequest = new XMLHttpRequest();

    // Configure the request
    xmlRequest.open('POST', 'index.php', true);
    xmlRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    // Send the request
    xmlRequest.send("rfid =" + rfidData);
}

function keepFocus() {
    document.getElementById("rfid").focus();
}
setInterval(keepFocus, 100);