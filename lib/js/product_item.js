/*  This module defines all the JavaScript needed to manage the 
 *  auto-completion of name of products.
 *
 *  ________________________
 *  Author: Yoel Monsalve
 */

function product_suggestion() 
{
  // TESTING ... DON'T USE THIS
  //
  /* based in method "on" (advanced) */
  //$('#sug_input').on( 'keypress', function(e) {    
  /*
  $('#sug_input').keypress( function(e) {
    //debug( "keypress: " + this.value + ", " + this.type );
    //debug( _keyCode(e) );
  });
  $('#sug_input').keydown( function(e) {
    //debug( "keydown");
    //debug( _keyCode(e) );
  });
  $('#sug_input').keyup( function(e) {
    //debug( "keyup");
  });
  */
  
  $('#sug_input').keyup(function(e) {
  
    debug( "keyup");

    if (event.defaultPrevented) {
      return; // Do nothing if the event was already processed
    }

    var formData = {
       'product_name' : $('input[name=hint]').val()
    };
    
    //debug( formData );

    if(formData['product_name'].length >= 1){

      // process the form
      $.ajax({
        type        : 'POST',
        url         : 'ajax/product_item.php',
        data        : formData,

        /* NOTE by Yoel.-
        /* This was causing the AJAX to fail.
         * HTML content has not to be delivered as JSON,
         * and normally the server won't do that 
         */
        //dataType    : 'json',     
        //encode      : true
      })
      .done(function(data) {
        $('#result').html(data).fadeIn();
      
        /* I specified this in the HTML document, not with JS */
        /*$("#result").hover(function() {
          $(this).css('cursor','pointer');
          }, function() {
          $(this).css('cursor','auto');
        });*/

        $('#result li').click(function() {
          $('#sug_input').val($(this).text());
          $('#result').fadeOut(500);
        });

        $("#sug_input").blur(function(){
          $("#result").fadeOut(500);
        });

        /* === added by Yoel on 2020.05.25 === */
        $("#sug_input").focus(function(){
          $("#result").fadeIn();
        });

      })
      .fail( function(data){
        debug( "failed: ".$data );
        $("#result").hide();
      });

    } else {
     $("#result").hide();
    };

  });

  $('#sug_form').submit(function(e) {

    var formData = {
        'p_name' : $('input[name=hint]').val()
    };

    //debug( formData );

    /* NOTE by Yoel.-
    /* This was causing the AJAX to fail.
     * HTML content has not to be delivered as JSON,
     * and normally the server won't do that 
     */
    $.ajax({
      type        : 'POST',
      url         : 'ajax/product_item.php',
      data        : formData,
      //dataType    : 'json',
      //encode      : true
    })
    .done(function(data) {
      //console.log(data);
      $('#product_info').html(data).show();
      total();
      $('.datePicker').datepicker('update', new Date());

    }).fail(function() {
      $('#product_info').html(data).show();
      });
    e.preventDefault();
  });
};

/* Calculates the monetary amount of the sell/outcome */
function total() {
  $('#product_info input').change(function(e)  {
    var price = +$('input[name=price]').val() || 0;
    var qty   = +$('input[name=quantity]').val() || 0;
    var total = qty * price ;

    /* if you change price or qty, updates 'total' */
    $('input[name=total]').val(total.toFixed(2));
  });
};


$(document).ready(function() {

  /* I don't know what this is (?) */
  //tooltip
  //$('[data-toggle="tooltip"]').tooltip();

  //console.log('IEEdge ' + detectIEEdge());

  $('.submenu-toggle').click(function () {
     $(this).parent().children('ul.submenu').toggle(200);
  });

  //suggestion for finding product names
  product_suggestion();

  // Calculate total ammont
  total();

  /* date picker */    
  $('.datepicker')
    .datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    autoclose: true
  });
});