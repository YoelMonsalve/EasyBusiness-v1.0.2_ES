/** EDIT_ACCOUNT_JS
 *  JavaScript background to the page 'edit_account.php'
 *  Completing the best user experience.
 *
 *  __________________________________
 *  (C) Yoel Monsalve, 2020-2021.
 */


function change_image(id) {

  debug("change image")
  //$('#user_id').val(id)
  $('#btn_change_image').trigger('click', true);
}

$(document).ready( function(e) {

  /* if JS is available, merge both buttons (upload + submit),
   * in a single one */
  $('#btn_search_file').css('display', 'none');    // hide the select button
  $('#btn_change_image').data('file_chosen', false);
  $('#file_upload').data('mode', 'new');
  $('#file_upload').data('id', 0);
  $('#btn_change_image').click( function(e, file_chosen=false) {

    //if (!$(this).data('file_chosen')) {
    if (!file_chosen) {
      $('#file_upload').click()
      e.preventDefault()
    }
    else {
      //$(this).data('file_chosen', false)
      // continue normal execution, via FORM/POST
      ;
    }
  })

  $('#file_upload').click( function() {
    if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
      alert('The File APIs are not fully supported in this browser.');
      return;
    } 
  })

  $('#file_upload').change( function() {
    $('#btn_change_image').trigger('click', true)
  })

  $('#btn_search_file').click( function(e) {
    $('#file_upload').data('mode', 'new');
    $('#file_upload').click()
  });

  /* double click over a image: allowing user to change it */ 
  $('#user_image').dblclick( function(e) {
    // not sure here (?)
    /*var user_id;
    var str_id = $(this).attr('id')
    var pattern = "user_image_id_"
    var tail = str_id.substring(str_id.indexOf(pattern) + pattern.length)
    user_id = parseInt(tail);
    if (!user_id || user_id < 1) {
      return
    }
    */

    $('#file_upload').data('mode', 'change');
    //$('#file_upload').data('id', user_id);
    $('#file_upload').click();  

    e.preventDefault()
  })

  /* enable tooltips */
  $('[data-toggle="tooltip"]').tooltip()
});
