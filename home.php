<?php
  $page_title = 'Home Page';
  require_once('include/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect(SITE_PATH.'index.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-9">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-9">
    <div class="panel">
      <div class="jumbotron text-center">
         <h2>Bienvenido! Seleccione una opci&oacute;n en el men&uacute; de la izquierda para comenzar.</h2>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
