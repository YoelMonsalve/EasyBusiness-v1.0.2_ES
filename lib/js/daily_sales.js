/** DAILY_SALES_JS
 *  JavaScript background to the page 'daily_sales.php'
 *
 *  __________________________________
 *  (C) Yoel Monsalve, 2020-2021.
 */

$(document).ready(function() {

  /* enable tooltips */
  $('[data-toggle="tooltip"]').tooltip()

  /* date picker control */
  $('#date')
    .datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    autoclose: true
  });

  if ( !$('#date').val() ) {
    $('#date').datepicker( 'setDate', new Date() )  
  }
});