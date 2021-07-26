/*  Javascript methods to complete the functionality 
 *  and user experience for the page 'media.php'
 *
 *  __________________________________
 *  (C) Yoel Monsalve, 2020-2021.
 */


function change_image(id) {

  $('#media_id').val(id)
  $('#method').val("change_image")
  $('#submit').trigger('click', true);
}

$(document).ready( function(e) {

  /* if JS is available, merge both buttons (upload + submit),
   * in a single one */
  $('#search_file').css('display', 'none');    // hide the select button
  //$('#submit').data('file_chosen', false);
  $('#file_upload').data('mode', 'new');
  $('#file_upload').data('id', 0);
  $('#submit').click( function(e, file_chosen=false) {

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
    if ($(this).data('mode') == 'new') {
      /* upload a new image */
      //$('#submit').data('file_chosen', true);
      $('#submit').trigger('click', true)
    }
    else if ($(this).data('mode') == 'change') {
      if ($(this).data('id')) {
        media_id = parseInt($(this).data('id'));
        if (media_id && media_id >= 1) {
          change_image(media_id)
        }
      }
    }
  })

  $('#search_file').click( function(e) {
    $('#file_upload').data('mode', 'new');
    $('#file_upload').click()
  });

  $('a[id^="delete_media_"]').click( function(e) {

    if (!confirm("Seguro de borrar esta imagen?")) {
      e.preventDefault();    /* exit doing nothing */
    }
  })
  /*$('[id^=delete_media_]').css("hover", "color: #f03030;")*/

  /* double click over a image: allowing user to change it */ 
  $('img[id^="img_id_"]').click( function(e) {
    var media_id;
    var str_id = $(this).attr('id')
    media_id = str_id.replace(/(?:^img_id_)(\d+?)$/,"$1")
    media_id = parseInt(media_id);
    debug(media_id)
    if (!media_id || media_id < 1) {
      //e.preventDefault()
      return
    }
    
    $('#file_upload').data('mode', 'change');
    $('#file_upload').data('id', media_id);
    $('#file_upload').click();  

    e.preventDefault()
  })
  /* ... or, by clicking on the edit icon */
  $('[id^="edit_media_id_"]').click( function(e) {
    var media_id;
    var str_id = $(this).attr('id')
    media_id = str_id.replace(/(?:edit_media_id_)(\d+?)$/,"$1")
    media_id = parseInt(media_id);
    if (!media_id || media_id < 1) {
      //e.preventDefault()
      return
    }

    $('#file_upload').data('mode', 'change');
    $('#file_upload').data('id', media_id);
    $('#file_upload').click();  

    e.preventDefault()
  })

  /* enable tooltips */
  $('[data-toggle="tooltip"]').tooltip()
});
