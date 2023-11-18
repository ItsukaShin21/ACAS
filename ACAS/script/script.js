function keepFocus() {
    $("#rfid").focus();
}
setInterval(keepFocus, 100);

function storeData() {
    $(document).ready(function() {
        $('#rfid').on('change', function() {
            let rfidData = $(this).val();

                // Use jQuery AJAX
                $.ajax({
                    type: 'POST',
                    url: 'index.php',
                    data: { rfid: rfidData },
                    success: function(response) {
                        location.reload();
                    },
                });
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
 
    // Create a new workbook and a worksheet from the data
    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.aoa_to_sheet([headers].concat(data));
 
    // Append the worksheet to the workbook
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
 
    // Write the workbook to an Excel file
    XLSX.writeFile(wb, 'exported_table.xlsx');
 }