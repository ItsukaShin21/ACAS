function keepFocus() {
    $("#rfid").focus();
}
setInterval(keepFocus, 100);

function storeData() {
    $(document).ready(function() {
        $('#rfid').on('input', function() {
            let rfidData = $(this).val();
            
                // Use jQuery AJAX with a slight delay to account for paste operations
                setTimeout(function() {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php',
                        data: { rfid: rfidData },
                        success: function(response) {
                            location.reload();
                        },
                    });
                }, 100);
        });
    });
}

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
    XLSX.writeFile(wb, 'exported_table.xlsx');
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