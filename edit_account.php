<?php
  $page_title = 'Editar Cuenta';
  require_once('include/load.php');
  page_require_level(3);
?>
<?php
  /* Yoel: Methods to submit           .-  2021.03.10
   *       - change_image:  change user image
   *       - update:        change other user info
   */
  if (isset($_POST['submit'])) {
    //update user image
    if (isset($_POST['method']) && $_POST['method'] == "change_image") {
      $photo = new Media();
      $user_id = (int)$_POST['user_id'];
      $photo->upload($_FILES['file_upload']);

      if ($photo->process_user_media($user_id)) {
        //$session->msg('s','Se cambió la imagen.');
        redirect(SITE_URL.'edit_account.php');
      } 
      else {
        $session->msg('d', join($photo->errors));
        redirect(SITE_URL.'edit_account.php');
      }
    }
    //update user other info
    if (isset($_POST['method']) && $_POST['method'] == "update") {
      $req_fields = array('name','username' );
      validate_fields($req_fields);
      if (empty($errors)) {
        $id = (int)$_SESSION['user_id'];
        $name = remove_junk($db->escape($_POST['name']));
        $username = remove_junk($db->escape($_POST['username']));
        $sql = "UPDATE users SET name ='{$name}', username ='{$username}' WHERE id='{$id}'";
        $result = $db->query($sql);
        if ($result) {
          if ($db->affected_rows() === 1) {
            $session->msg('s',"Cuenta actualizada");
            redirect(SITE_URL.'edit_account.php', false);
          }
          else {
            $session->msg('s',"No se cambió la cuenta");
            redirect(SITE_URL.'edit_account.php', false);
          }
        } 
        else {
          $session->msg('d',' Lo siento, actualización falló');
          redirect(SITE_URL.'edit_account.php', false);
        }
      } 
      else {
        $session->msg("d", $errors);
        redirect(SITE_URL.'edit_account.php',false);
      }
    }
  }
?>
    
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <i class="glyphicon glyphicon-camera"></i>
        <span>Cambiar mi foto</span>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12" style="text-align: center">
            <img class="img-circle img-size-2" id="user_image" data-toggle="tooltip" data-placement="right" title="doble click para cambiar" src="uploads/users/<?php echo $user['image'];?>" alt="user image">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12" style="text-align: center">
            <form class="form" action="edit_account.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <input type="file" name="file_upload" id="file_upload" style="display:none" class="btn btn-default btn-file">
              <span class="btn btn-success" id="btn_search_file" style="display: none" title="Seleccionar archivo" data-toogle="tooltip">Buscar
              </span>
            </div>

            <div class="form-group">
              <input type="hidden" name="method" value="change_image">
              <input type="hidden" name="user_id" id="user_id" value="<?php echo $user['id'];?>">
              <button type="submit" name="submit" id="btn_change_image" class="btn btn-primary">Cambiar
              </button>
            </div>
           </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <i class="glyphicon glyphicon-pencil"></i>
        <span>Editar mi cuenta</span>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_account.php?id=<?php echo (int)$user['id'];?>" class="clearfix">
          <div class="row">
          <div class="col-md-8">
          <div class="form-group">
            <label for="name" class="control-label">Nombres</label>
            <input type="name" class="form-control" name="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>">
          </div>
          </div>
          </div>
          <div class="row">
          <div class="col-md-8">
          <div class="form-group">
            <label for="username" class="control-label">Usuario</label>
            <input type="text" class="form-control" name="username" value="<?php echo remove_junk($user['username']); ?>">
          </div>
          </div>
          </div>
          <div class="form-group clearfix" style="text-align: left; margin-top: 2%;">
            <a href="change_password.php" title="change password" class="btn btn-danger">Cambiar contraseña</a>
            <input type="hidden" name="method" value="update">
            <button type="submit" name="submit" id="submit_update" class="btn btn-primary">Actualizar</button>
          </div>  
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="lib/js/edit_account.js"></script>
<?php include_once('layouts/footer.php'); ?>
