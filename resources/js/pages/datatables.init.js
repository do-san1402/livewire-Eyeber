/*
Template Name: Minible - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Datatables Js File
*/

$(document).ready(function() {
    $('#datatable').DataTable();

    //Buttons examples
    
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        
        $(".dataTables_length select").addClass('form-select form-select-sm');


        
    $(document).on('change', '.dataTable input.checkbox_all', function(e) {
        $(this).closest('.dataTable').find('input.single_checkbox').prop('checked', this.checked).trigger('change');
    });
    
    $(document).on('change', '.filter_datatable_wrap .dataTable input.single_checkbox', function(e) {
        var _parent = $(this).closest('.filter_datatable_wrap');
        var checkboxs = _parent.find("input.single_checkbox:checked");
        if(checkboxs.length > 0) {
            _parent.find('button.active_with_checkbox').prop('disabled', false);
        } else {
            _parent.find('button.active_with_checkbox').prop('disabled', true);
        } 
    });
}
);