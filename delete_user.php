<?php
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  $delete_id = delete_by_id('users',(int)$_GET['id']);
  if($delete_id){
      $session->msg("s","Usuario eliminado");
      redirect(SITE_URL.'users.php');
  } else {
      $session->msg("d","Se ha producido un error en la eliminación del usuario");
      redirect(SITE_URL.'users.php');
  }
?>
