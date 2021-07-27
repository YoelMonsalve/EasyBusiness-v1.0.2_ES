<?php
  $page_title = 'Cambiar contraseña';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);

  $user = current_user();
?>
<?php
  if (isset($_POST['update'])) {

    $req_fields = array('new-password','old-password','id' );

    if (validate_fields($req_fields)) {

      $old_p = remove_junk($_POST['old-password']);
      $new_p = remove_junk($_POST['new-password']);
      $u_id  = remove_junk($_POST['id']);

      /* NOTE: validating further fields
       * 2021.07.27.- */
      if (!is_numeric($u_id) || ($u_id = intval($u_id)) <= 0) {
        // bad user id
        $session->msg('d',' Incorrecto user ID.');
        redirect(SITE_URL.'change_password.php', false);
      }

      /* NOTE: changed to SHA512 algorithm. 
       * 2021.07.27.- */
      if (hash("sha512", $_POST['old-password']) !== current_user()['password'] ) {
        $session->msg('d', "Tu antigua contraseña no coincide");
        redirect(SITE_URL.'change_password.php',false);
      }

      $id = (int)$_POST['id'];
      $new = remove_junk($db->escape(hash("sha512", $_POST['new-password'])));
      $sql = "UPDATE users SET password ='{$new}' WHERE id='{$db->escape($id)}'";
      
      $result = $db->query($sql);
      if ($result) {
        if ($db->affected_rows() > 0) {
          $session->logout();
          $session->msg('s',"Inicia sesión con tu nueva contraseña.");
          redirect(SITE_URL.'index.php', false);
        }
        else {
          $session->msg('w',"No se cambió la contraseña.");
          redirect(SITE_URL.'change_password.php', false);
        }
      }
      else {
        $session->msg('d', $db->get_last_error());
        redirect(SITE_URL.'change_password.php', false);
      }
    } else {
      $session->msg("d", $errors);
      redirect(SITE_URL.'change_password.php',false);
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
        <input type="password" class="form-control" name="old-password" placeholder="">
      </div>
      
      <div class="form-group">
        <label for="newPassword" class="control-label">Nueva contraseña</label>
        <input type="password" class="form-control" name="new-password" placeholder="">
      </div>
      <div class="form-group clearfix">
        <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
        <button type="submit" name="update" class="btn btn-info">Cambiar</button>
      </div>
    </form>
  </div>
<?php include_once('layouts/footer.php'); ?>
