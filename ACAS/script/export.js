function exportToExcel(attendanceTable) {
    var table = document.getElementById(attendanceTable);

    if (!table) {
        alert("No records to export.");
        return;
    }

    var headers = Array.from(table.rows[0].cells).map(cell => cell.innerText);
    var data = Array.from(table.rows).slice(1).map(row =>
        Array.from(row.cells).map(cell => cell.innerText)
    );

    var groupedData = data.reduce((result, row) => {
        var program = row[headers.indexOf('Program')];
        result[program] = result[program] || [];
        result[program].push(row);
        return result;
    }, {});

    var wb = XLSX.utils.book_new();

    // Add the "All Records" sheet first
    var allRecordsData = [headers, ...data];
    var allRecordsWs = XLSX.utils.aoa_to_sheet(allRecordsData);

    // Set the width of each column in "All Records" sheet based on character length and add 2
    var columnWidths = headers.map((header) => {
        var maxColumnLength = Math.max(...allRecordsData.map(row => (row[headers.indexOf(header)] || '').toString().length));
        return { width: maxColumnLength + 2 };
    });
    allRecordsWs['!cols'] = columnWidths;

    XLSX.utils.book_append_sheet(wb, allRecordsWs, 'All Records');

    // Add other sheets based on grouped data
    Object.entries(groupedData).forEach(([program, programData]) => {
        var wsData = [headers, ...programData];
        var ws = XLSX.utils.aoa_to_sheet(wsData);

        // Set the width of each column in the current sheet based on character length and add 2
        ws['!cols'] = columnWidths;

        XLSX.utils.book_append_sheet(wb, ws, program);
    });

    XLSX.writeFile(wb, 'attendance.xlsx');
}