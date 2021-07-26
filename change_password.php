<?php
  $page_title = 'Cambiar contraseña';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php $user = current_user(); ?>
<?php
  if(isset($_POST['update'])){

    $req_fields = array('new-password','old-password','id' );
    validate_fields($req_fields);

    if(empty($errors)){

             if(sha1($_POST['old-password']) !== current_user()['password'] ){
               $session->msg('d', "Tu antigua contraseña no coincide");
               redirect(SITE_PATH.'change_password.php',false);
             }

            $id = (int)$_POST['id'];
            $new = remove_junk($db->escape(sha1($_POST['new-password'])));
            $sql = "UPDATE users SET password ='{$new}' WHERE id='{$db->escape($id)}'";
            $result = $db->query($sql);
                if($result && $db->affected_rows() === 1):
                  $session->logout();
                  $session->msg('s',"Inicia sesión con tu nueva contraseña.");
                  redirect(SITE_PATH.'index.php', false);
                else:
                  $session->msg('d',' Lo siento, actualización falló.');
                  redirect(SITE_PATH.'change_password.php', false);
                endif;
    } else {
      $session->msg("d", $errors);
      redirect(SITE_PATH.'change_password.php',false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
       <h3>Cambiar contraseña</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="change_password.php" class="clearfix">
        
        <div class="form-group">
              <label for="oldPassword" class="control-label">Antigua contraseña</label>
              <input type="password" class="form-control" name="old-password" placeholder="Antigua contraseña">
        </div>
        
        <div class="form-group">
              <label for="newPassword" class="control-label">Nueva contraseña</label>
              <input type="password" class="form-control" name="new-password" placeholder="Nueva contraseña">
        </div>
        <div class="form-group clearfix">
               <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
                <button type="submit" name="update" class="btn btn-info">Cambiar</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
