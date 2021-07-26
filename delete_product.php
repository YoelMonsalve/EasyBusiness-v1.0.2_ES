<?php
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $product = find_by_id('products',(int)$_GET['id']);
  if(!$product){
    $session->msg("d","ID vacío");
    redirect(SITE_URL.'products.php');
  }
?>
<?php
  $delete_id = delete_by_id('products',(int)$product['id']);
  if($delete_id){
      $session->msg("s","Producto eliminado");
      redirect(SITE_URL.'products.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect(SITE_URL.'products.php');
  }
?>
