import './bootstrap';
import 'simple-datatables/dist/style.css';


import $ from 'jquery';
import 'datatables.net';

$(document).ready(function() {
    if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        const dataTable = new simpleDatatables.DataTable("#default-table", {
            searchable: true,
            sortable: false
        });
    }
});