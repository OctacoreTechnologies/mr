window.ReportExport = {

    getCleanTableData: function (tableId) {
        console.log(tableId)
        const table = document.getElementById(tableId);
        if (!table) return null;

        // headers (remove last column = Actions)
        const headers = Array.from(table.querySelectorAll("thead th"))
            .map(th => th.innerText.trim())
            .slice(0, -1);

        // rows (remove last column)
        const rows = Array.from(table.querySelectorAll("tbody tr")).map(tr =>
            Array.from(tr.cells)
                .map(td => td.innerText.trim())
                .slice(0, -1)
        );

        return { headers, rows };
    },

    exportExcel: function (tableId, fileName = 'report.xlsx') {
        const table = document.getElementById(tableId);
        if (!table) return;

        const clonedTable = table.cloneNode(true);

        clonedTable.querySelectorAll('tr').forEach(tr => {
            tr.deleteCell(-1); // remove Actions
        });

        const wb = XLSX.utils.table_to_book(clonedTable, { sheet: 'Report' });
        XLSX.writeFile(wb, fileName);
    },

    exportCSV: function (tableId, fileName = 'report.csv') {
        const data = this.getCleanTableData(tableId);
        if (!data) return;

        const csvData = [data.headers, ...data.rows];
        const csv = Papa.unparse(csvData);

        const blob = new Blob([csv], { type: 'text/csv' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = fileName;
        link.click();
    },

    exportPDF: function (tableId, title = 'Report', fileName = 'report.pdf') {
        const data = this.getCleanTableData(tableId);
        if (!data) return;

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l');

        doc.setFontSize(14);
        doc.text(title, 14, 15);

        doc.autoTable({
            startY: 20,
            head: [data.headers],
            body: data.rows,
            styles: {
                fontSize: 9,
                cellPadding: 3,
                valign: 'middle',
                overflow: 'linebreak'
            },
            headStyles: {
                fillColor: [0, 123, 255],
                textColor: 255,
                fontStyle: 'bold',
                halign: 'center'
            },
            columnStyles: {
                0: { cellWidth: 15, halign: 'center', overflow: 'visible' } // SR NO fix
            },
            theme: 'striped'
        });

        doc.save(fileName);
    }
};

