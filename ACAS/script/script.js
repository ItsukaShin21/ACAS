function keepFocus () {
$('#rfiduid').focus();
}
setInterval(keepFocus, 100);

$(document).ready(function() {
    $('#rfid').focus();
})

function exportToExcel(attendanceTable) {
    // Get the table
    var table = document.getElementById(attendanceTable);

    // Check if the table exists
    if (!table) {
        alert("No records to export.");
        return;
    }

    // Get the table data
    var rows = Array.from(table.rows);
    var headers = Array.from(rows.shift().cells).map(function(cell) {
        return cell.innerText;
    });
    var data = rows.map(function(row) {
        return Array.from(row.cells).map(function(cell) {
            return cell.innerText;
        });
    });

    // Group data by program
    var groupedData = {};
    data.forEach(function(row) {
        var program = row[headers.indexOf('Program')];
        if (!groupedData[program]) {
            groupedData[program] = [];
        }
        groupedData[program].push(row);
    });

    // Create a new workbook
    var wb = XLSX.utils.book_new();

    // Create worksheets for each program
    Object.keys(groupedData).forEach(function(program) {
        var wsData = [headers].concat(groupedData[program]);
        var ws = XLSX.utils.aoa_to_sheet(wsData);
        XLSX.utils.book_append_sheet(wb, ws, program);
    });

    // Write the workbook to an Excel file
    XLSX.writeFile(wb, 'attendance.xlsx');
}

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

function hide() {
    var modal = document.getElementById('modalBg');
    var overlay = document.querySelector('.overlay');
    modal.style.display = 'none';
    overlay.style.display = 'none';
}
function show() {
    
}