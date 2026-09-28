import { DataTable } from 'simple-datatables';

// Tables marked with data-search-table get a search field; sorting and pagination stay off.
document.querySelectorAll('table[data-search-table]').forEach((table) => {
    new DataTable(table, {
        searchable: true,
        sortable: false,
        paging: false,
        labels: {
            searchLabel: '',
            placeholder: table.dataset.placeholder ?? 'Search…',
            searchTitle: 'Search within table',
            noRows: 'No entries found.',
            noResults: 'No results match your search.',
        },
    });
});
