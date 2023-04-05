 //Initialize Select2 Elements
 $('.select2').select2()
 $("#example2").DataTable({
     "paging": true,
     "lengthChange": false,
     "searching": true,
     "ordering": false,
     "info": true,
     "autoWidth": false,
     "responsive": true,
 })

 $('#tgl1,#tgl2').datepicker({
     dateFormat: 'yy-mm-dd',
     autoclose: true
 });
 $('#tgl13').datepicker({
     dateFormat: 'yy-mm-dd',
     autoclose: true
 });
 $('#tgl23').datepicker({
     dateFormat: 'yy-mm-dd',
     autoclose: true
 });

 $(document).ready(function() {
     // Setup - add a text input to each footer cell
     $('#example thead tr')
         .clone(true)
         .addClass('filters')
         .appendTo('#example thead');

     var table = $('#example').DataTable({
         orderCellsTop: true,
         fixedHeader: true,
         "paging": true,
         "lengthChange": false,
         "searching": true,
         "ordering": false,
         "info": true,
         "autoWidth": false,
         "responsive": true,
         initComplete: function() {
             var api = this.api();

             // For each column
             api
                 .columns()
                 .eq(0)
                 .each(function(colIdx) {
                     // Set the header cell to contain the input element
                     var cell = $('.filters th').eq(
                         $(api.column(colIdx).header()).index()
                     );
                     var title = $(cell).text();
                     $(cell).html('<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />');

                     // On every keypress in this input
                     $(
                             'input',
                             $('.filters th').eq($(api.column(colIdx).header()).index())
                         )
                         .off('keyup change')
                         .on('change', function(e) {
                             // Get the search value
                             $(this).attr('title', $(this).val());
                             var regexr = '({search})'; //$(this).parents('th').find('select').val();

                             var cursorPosition = this.selectionStart;
                             // Search the column for that value
                             api
                                 .column(colIdx)
                                 .search(
                                     this.value != '' ?
                                     regexr.replace('{search}', '(((' + this.value + ')))') :
                                     '',
                                     this.value != '',
                                     this.value == ''
                                 )
                                 .draw();
                         })
                         .on('keyup', function(e) {
                             e.stopPropagation();

                             $(this).trigger('change');
                             $(this)
                                 .focus()[0]
                                 .setSelectionRange(cursorPosition, cursorPosition);
                         });
                 });
         },
     });

     
 });