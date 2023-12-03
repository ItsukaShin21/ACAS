function keepFocus () {
$('#rfiduid').focus();
}
setInterval(keepFocus, 100);

$(document).ready(function() {
    $('#rfid').focus();
})

$(document).ready(function() {
    // Iterate over each td element in the table
    $('table td').each(function() {
        // Get the text content of the current td
        let status = $(this).text().trim();

        // Add a class based on the status
        if (status === 'ABSENT') {
            $(this).addClass('absent');
        } else if (status === 'PRESENT') {
            $(this).addClass('present');
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

    $('#rfiduid').on('input', function() {
        let rfidData = $(this).val();
    
        // Extract eventname from the current URL
        let eventName = getParameterByName('eventname');
    
        // Use jQuery AJAX to send data to the server
        $.ajax({
            type: 'POST',
            url: 'addStudent.php',
            data: { rfiduid: rfidData },
            success: function(response) {
                location.reload();
            }
        });
    });

$(document).ready(function() {
    $('#deleteEvent').on('click', function(event) {
        var confirmation = confirm('Delete this event?');
        
        if (confirmation) {
            var eventName = $('#eventName').text();
            
            // Make an Ajax request to delete the customer
            $.ajax({
                type: 'POST',
                url: 'deleteEvent.php',
                data: { eventname: eventName },
                success: function(response) {
                    location.reload();
                }
            });
        } else {
            event.preventDefault();
        }
    });
});

$(document).ready(function() {
    $('#clearAttendance').on('click', function(event) {
        var confirmation = confirm('Clear all records?');
        
        if (confirmation) {
            var eventName = getParameterByName('eventname');
            
            // Make an Ajax request to delete the customer
            $.ajax({
                type: 'POST',
                url: 'clearAttendance.php',
                data: { eventname: eventName },
                success: function(response) {
                    location.reload();
                }
            });
        } else {
            event.preventDefault();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Initially disable the delete button if the default option is selected
    checkEventName();

    // Listen for changes in the eventname select element
    document.getElementById('eventname').addEventListener('change', function () {
        checkEventName();
    });

    function checkEventName() {
        var eventNameValue = document.getElementById('eventname').value;

        // Enable or disable the delete button based on the selected value
        var deleteEventButton = document.getElementById('deleteEvent');
        if (eventNameValue === '') {
            deleteEventButton.disabled = true;
        } else {
            deleteEventButton.disabled = false;
        }
    }
});