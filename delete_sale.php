<?php
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php
  $d_sale = find_by_id('sales',(int)$_GET['id']);
  if(!$d_sale){
    $session->msg("d","ID vacío.");
    redirect(SITE_URL.'/sales.php');
  }
?>
<?php

  /* substraer del inventario aqui */
  $p_id = $d_sale['product_id'];
  $qty  = $d_sale['qty'];
  add_product_qty($qty, $p_id);
  
  $delete_id = delete_by_id('sales',(int)$d_sale['id']);
  if($delete_id){
      $session->msg("s","Venta eliminada.");
      redirect(SITE_URL.'/sales.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect(SITE_URL.'/sales.php');
  }
?>
