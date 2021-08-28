<?php
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $find_media = find_by_id('media',(int)$_GET['id']);
  $photo = new Media();
  if($photo->media_destroy($find_media['id'],$find_media['file_name'])){
    $session->msg("s","Se ha eliminado la foto.");
    redirect(SITE_URL.'media.php');
  } 
  else {
    $err_msg = $db->get_last_error();
    //die("MySQL error: ".$err_msg);
    $session->msg("d", $err_msg);
    //$session->msg("d","Se ha producido un error en la eliminación de fotografías.");

    redirect(SITE_URL.'media.php');
  }
?>
