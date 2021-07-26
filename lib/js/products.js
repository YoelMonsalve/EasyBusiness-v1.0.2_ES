/** PRODUCTS_JS
 *  JavaScript background to the page 'products.php'
 *
 *  __________________________________
 *  (C) Yoel Monsalve, 2020-2021.
 */

function update_quantity()
{
  p_data = []

  items = $('#tbl_products tbody tr')
  if (!items) return
  items.each(function() {
    q_control = $(this).find('[name="quantity"]').first()
    if ((q_id = q_control.data('id')) && parseInt(q_id)) {
      p_data.push({
        'id':       q_id, 
        'quantity': q_control.data('quantity')
      })
    }
  })

  if (!p_data || !p_data.length) {
    // no data to update
    alert("No han cambiado datos")
    return
  }

  payload = {
    'method': 'update',
    'data':   p_data
  }
  $.ajax({
    type:    'POST',
    url:     'products.php',
    timeout: '10000',
    data:    payload,
    //dataType : 'json',
    //encode   : true
  })
  .done(function(resp) {
    alert("Actualizado")
  })
  .fail(function() {
    ;
  })
  //location.reload(true)
}

function configure_product_quantity_controls() 
{
  elems = $('#tbl_products tbody tr')
  if (!elems) return
  elems.each(function() {
    q_control = $(this).find('[name="quantity"]').first()
    q_control.change(function(){
      elem_id = $(this).attr('id')
      q_id = elem_id.replace(/(?:^q_id_)(\d+?)$/,"$1")
      if ((q_id = parseInt(q_id))) $(this).data('id', q_id)
      $(this).data('quantity', $(this).val())
    })
  })
}

function configure_btn_update() 
{
  $('#btn_update').click(function(e) {
    update_quantity()
    e.preventDefault()
  })
}

function init_form() 
{
  configure_btn_update()
  configure_product_quantity_controls()
}

$(document).ready(function() {

  /* configure the userform */
  init_form()

  $('#tbl_products').DataTable({
    "scrollY": 200,
    "scrollX": true
  })
  $('[data-toggle="tooltip"]').tooltip()
})