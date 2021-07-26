/*  This module defines all the JavaScript needed to manage the 
 *  auto-completion of name of products.
 *
 *  ________________________
 *  Author: Yoel Monsalve
 */

function refresh_form( ) {
  // photo
  $('#product_image').css("display", "none" );
  // category
  $('#category').html('');
  // location
  $('#location').html('');
  // date
  $('#date').datepicker( 'setDate', new Date() )
  // destination
  $('#destination').val('');
  // stock/available
  $('#stock').html('0');
  // quantity
  $('#quantity').val('0');
  // buying price
  $('#buy_price').html('0.00');
  // saleing price
  $('#sale_price').val('0.00');
  // total sale
  $('#total_sale').val('0.00');
}

function check_by_partNo( ) {

  var formData = {
    //'partNo' : $('#partNo').val()
    'partNo' : $('input[name=partNo]').val(),
    'match'  : 'full'
  };

 //debug( "formData" );
 //debug( formData );

  $.ajax({
    type        : 'POST',
    url         : 'ajax/query_add_sale.php',
    data        : formData,
    dataType    : 'json',
    encode      : true
  })
  .done(function(data) {
    var results = data;
   //debug( "results" )
   //debug( results )

    if ( !results || results.length == 0 ) { refresh_form(); return }

    // partNo
    //$('#partNo').val(results['partNo']);
    // product name
    $('#product_name').val(results['name']);
    // photo
    $('#product_image').attr("src", "uploads/products/" + results['media_name'] );
    $('#product_image').css("display", "block" );
    // category
    $('#category').html(results['category_name']);
    // location
    $('#location').html(results['location']);
    // stock/available
    $('#stock').html(results['quantity']);
    // buying price
    $('#buy_price').html(results['buy_price']);
    // saleing price
    $('#sale_price').val(results['sale_price']);
    
    //$('.datePicker').datepicker('update', new Date());

  })
  .fail(function() {
    //$('#product_info').html(data).show();
    refresh_form();
  });
}

function check_by_product_name( ) {

  var formData = {
    'p_name' : $('input[name=product_name]').val()
  };

 //debug( "formData" );
 //debug( formData );

  $.ajax({
    type        : 'POST',
    url         : 'ajax/query_add_sale.php',
    data        : formData,
    dataType    : 'json',
    encode      : true
  })
  .done(function(data) {
    //console.log(data);
    //$('#product_info').html(data).show();
    var results = data;
   //debug( "results" )
   //debug( results )

    if ( !results || results.length == 0 ) { refresh_form(); return }

    // partNo
    $('#partNo').val(results['partNo']);
    // photo
    $('#product_image').attr("src", "uploads/products/" + results['media_name'] );
    $('#product_image').css("display", "block" );
    // category
    $('#category').html(results['category_name']);
    // location
    $('#location').html(results['location']);
    // stock/available
    $('#stock').html(results['quantity']);
    // buying price
    $('#buy_price').html(results['buy_price']);
    // saleing price
    $('#sale_price').val(results['sale_price']);
        
    $('.datePicker').datepicker('update', new Date());

  })
  .fail(function() {
    //$('#product_info').html(data).show();
    refresh_form();
  });  
}

/** Searches partial coincidences of partNo (using a POST request)
 *  and fills the dropdown
 */
function suggest_partNo( ) 
{
  var formData = {
     'partNo'  :  $('input[name=partNo]').val(),
     'match'   :  'partial'
  };

  if( formData['partNo'].length >= 1 ) {

    // process the form
    $.ajax({
      type   : 'POST',
      url    : 'ajax/query_add_sale.php',
      data   : formData,

      dataType    : 'json',     
      encode      : true
    })
    .done(function(data) {
      if ( data.length > 1 ) {
        /* Generate dinamically the HTML content for the list */
        var html_content = "";
        for( item in data ) {
          html_content += "<li class=\"list-group-item\">" + data[item] + "</li>\n";
        }

        $('#lst_partNo').html(html_content).fadeIn();
      
        $('#lst_partNo li').click(function() {
          $('#partNo').val($(this).text())
          check_by_partNo();      // autocomplete the other fields
          $('#lst_partNo').fadeOut(200)
          $('#product_name').focus()
        });
      }
      else if ( data.length == 1 && $('#partNo').val() == data[0]) {
        $('#partNo').val( data[0] )
        check_by_partNo();      // autocomplete the other fields
        $('#lst_partNo').html("").fadeOut(200);
        $('#destination').focus()
      }
    })
    .fail( function(data) {
      $("#lst_partNo").hide();
    });

  } else {
    $("#lst_partNo").hide();
  };
}

function auto_form() 
{
  // TESTING ... DON'T USE THIS
  //
  /* based in method "on" (advanced) */
  //$('#product_name').on( 'keypress', function(e) {    
  /*
  $('#product_name').keypress( function(e) {
    debug( "keypress: " + this.value + ", " + this.type );
    debug( "code: " + _keyCode(e) );
  });
  $('#product_name').keydown( function(e) {
    debug( "keydown: " + this.value );
    debug( "code: " + _keyCode(e) );
  });
  $('#product_name').keyup( function(e) {
    debug( "keyup: " + this.value );
    debug( "code: " + _keyCode(e) );
  });
  */

  /* Setting control partNo
   * =========================================== */
  // blur
  $("#partNo").blur(function(){
    //debug( "blur")
    $("#lst_partNo").fadeOut(200);
  });
  // focus
  $("#partNo").focus(function(){
    //debug( "focus")
    $("#lst_partNo").fadeIn();
  });
  // keyup (auto-sugegstion)
  $('#partNo').keyup(function(e) {
    suggest_partNo()
  });
  // click (full search) -- EXPERIMENTAL
  $('#check-partNo').click(function(e) {
    debug( "partNo click")
    check_by_partNo()
    $('#lst_partNo').fadeOut(200)
    $('#product_name').focus()
    e.preventDefault()
  });
  

  /* Setting control product_name
   * =========================================== */
  // blur
  $("#product_name").blur(function(){
    //debug( "blur")
    $("#lst_product_name").fadeOut(200);
  });
  // focus
  $("#product_name").focus(function(){
    //debug( "focus")
    $("#product_name").fadeIn();
  });
  $('#product_name').keyup(function(e) {
  
    if (event.defaultPrevented) {
      return; // Do nothing if the event was already processed
    }

    var formData = {
       'product_name' : $('input[name=product_name]').val()
    };
    
    //debug( formData );

    if(formData['product_name'].length >= 1){

      // process the form
      $.ajax({
        type        : 'POST',
        url         : 'ajax/query_add_sale.php',
        data        : formData,

        dataType    : 'json',     
        encode      : true
      })
      .done(function(data) {
        /* === debugging === */
        //debug( "SUCCESS" );
        //debug( data );

        /* Generate dinamically the HTML content for the list */
        var html_content = "";
        if ( data.length > 1 ) {
          for( item in data ) {
            html_content += "<li class=\"list-group-item\">" + data[item] + "</li>\n";
          }

          /* === debugging === */
          //debug( html_content );

          $('#lst_product_name').html(html_content).fadeIn();
        
          $('#lst_product_name li').click(function() {
            $('#product_name').val($(this).text());
            check_by_product_name();      // autocomplete the other fields
            $('#lst_product_name').fadeOut(200);
            $('#destination').focus();
          });
        }
        if ( data.length == 1 && $('#product_name').val() == data[0] ) {
          $('#product_name').val( data[0] )
          check_by_product_name();      // autocomplete the other fields
          $('#lst_product_name').html("").fadeOut(200)
          $('#destination').focus()
        }
      })
      .fail( function(data) {
        $("#lst_product_name").hide();
      });

    } else {
     $("#lst_product_name").hide();
    };
  });

  $('#refresh').click(function(e) {  
    
    refresh_form()
    e.preventDefault();
  })
  
  $('#check-product-name').click(function(e) {

    check_by_product_name()
    e.preventDefault();
  });

  $('#quantity').change( function(e) {
    var price = +$('#sale_price').val() || 0;
    var qty   = +$('#quantity').val() || 0;
    var total = qty * price ;

    /* if you change price or qty, updates 'total' */
    $('#total_sale').val(total.toFixed(2));
    });

  $('#sale_price').change( function(e) {
    var price = +$('#sale_price').val() || 0;
    var qty   = +$('#quantity').val() || 0;
    var total = qty * price ;

    /* if you change price or qty, updates 'total' */
    $('#total_sale').val(total.toFixed(2));
    });
}


$(document).ready(function() {

  // enable tooltips
  $('[data-toggle="tooltip"]').tooltip()

  /* === debugging === */
  //console.log('IEEdge ' + detectIEEdge());

  // Set all elements in the form
  auto_form();

  /* including date picker */
  $('#date')
    .datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    autoclose: true
  });

  if ( !$('#date').val() ) {
    $('#date').datepicker( 'setDate', new Date() )  
  }

  //ans = confirm( "are you sure?")
  
});