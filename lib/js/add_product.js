/** ADD_PRODUCT_JS
 *  JavaScript background to the page 'add_product.php'
 *
 *  __________________________________
 *  (C) Yoel Monsalve, 2020-2021.
 */

function configure_carousel() {

  /* set image click */
  elems = $('[id^="img_id_"]')
  elems.each(function() {
    $(this).click(function(){
      elem_id = $(this).attr('id')
      img_id = elem_id.replace(/(?:^img_id_)(\d+?)$/,"$1")
      if ((img_id = parseInt(img_id))) {
        $('#product-image-id').val(img_id)
        $('#product-image').attr('src', $(this).attr('src'))
        hide_carousel()
      }
    })
  })

  $('#display-carousel').click(function(e) {
    show_carousel()
    e.preventDefault()    
  })

  $('#product-image').dblclick(function(e) {
    show_carousel()
    e.preventDefault()
  })
}

function show_carousel() {
  $('#thumbcarousel').css('display', 'block');
}
function hide_carousel() {
  $('#thumbcarousel').css('display', 'none');
}

/* to execute on document load */
$(document).ready(function() {

  configure_carousel()

  /* enable tooltips */
  $('[data-toggle="tooltip"]').tooltip();
})