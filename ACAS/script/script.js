function keepFocus() {
    $("#rfiduid").focus();
}
setInterval(keepFocus, 100);

function exportToExcel(attendanceTable) {
    // Get the table data
    var table = document.getElementById(attendanceTable);
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
    // Listen for the change event on the eventname select element
    $('#eventname').change(function() {
        // Get the selected event name
        var selectedEvent = $(this).val();

        // Use AJAX to send a request to the server
        $.ajax({
            type: 'POST',
            url: 'eventidFetcher.php',
            data: { eventname: selectedEvent },
            success: function(data) {
            },
        });
    });
});

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

// $('#rfiduid').on('input', function() {
//     let rfidData = $(this).val();

//     // Extract eventname from the current URL
//     let eventName = getParameterByName('eventname');

//     // Use jQuery AJAX to send data to the server
//     $.ajax({
//         type: 'POST',
//         url: 'addStudent.php',
//         data: { rfiduid: rfidData },
//         success: function(response) {
//                 alert("success");
//                 location.reload();
//         }
//     });
// });

// function getParameterByName(name, url) {
//     if (!url) url = window.location.href;
//     name = name.replace(/[\[\]]/g, '\\$&');
//     var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
//         results = regex.exec(url);
//     if (!results) return null;
//     if (!results[2]) return '';
//     return decodeURIComponent(results[2].replace(/\+/g, ' '));
// }

function handleClick(event) {
    // Get the content of the clicked cell
    let cellContent = $(event.target).text();

    // Find the closest row from the clicked element
    let row = $(event.target).closest('tr');
    let studentId = row.find('[name="studentid"]').text();

    $.ajax({
        type: 'POST',
        url: 'resetTime.php',
        data: {
            studentid: studentId,
            timeIn: cellContent
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
        }
    });
}