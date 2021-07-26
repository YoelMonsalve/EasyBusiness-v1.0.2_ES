/** DAILY_SALES_JS
 *  JavaScript background to the page 'daily_sales.php'
 *
 *  __________________________________
 *  (C) Yoel Monsalve, 2020-2021.
 */
$(document).ready(function() {

  /* enable tooltips */
  $('[data-toggle="tooltip"]').tooltip()

  /* date pickers */
  $('#date-start')
    .datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    autoclose: true
  });

  $('#date-end')
    .datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    autoclose: true
  });

  if ( !$('#date-start').val() ) {
    $('#date-end').datepicker( 'setDate', new Date() )  
  }
});