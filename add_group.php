<?php
  $page_title = 'Agregar grupo';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  if (isset($_POST['add'])) {

    $req_fields = array('group-name','group-level');
    validate_fields($req_fields);

    if (find_by_groupName($_POST['group-name']) === false) {
      $session->msg('d','<b>Error!</b> El nombre de grupo realmente existe en la base de datos');
      redirect(SITE_URL.'add_group.php', false);
    } elseif (find_by_groupLevel($_POST['group-level']) === false) {
      $session->msg('d','<b>Error!</b> El nombre de grupo realmente existe en la base de datos ');
      redirect(SITE_URL.'add_group.php', false);
    }
    if (empty($errors)) {
      $name = remove_junk($db->escape($_POST['group-name']));
      $level = remove_junk($db->escape($_POST['group-level']));
      $status = remove_junk($db->escape($_POST['status']));

      $query  = "INSERT INTO user_groups (";
      $query .="group_name,group_level,group_status";
      $query .=") VALUES (";
      $query .=" '{$name}', '{$level}','{$status}'";
      $query .=")";
      if ($db->query($query)) {
        //sucess
        $session->msg('s',"Grupo ha sido creado! ");
        redirect(SITE_URL.'groups.php', false);
      } else {
        //failed
        //$session->msg('d','Lamentablemente no se pudo crear el grupo!');
        redirect(SITE_URL.'add_group.php', false);
      }
    } else {
      $session->msg("d", $errors);
      redirect(SITE_URL.'add_group.php',false);
    }
  }
?>

<?php include_once('layouts/header.php'); ?>

<div class="login-page">
  <div class="text-center">
    <h3>Agregar nuevo grupo de usurios</h3>
  </div>
  <?php echo display_msg($session->msg()); ?>
  <form method="post" action="add_group.php" class="clearfix">
    <div class="form-group">
      <label for="name" class="control-label">Nombre del grupo</label>
      <input type="name" class="form-control" name="group-name" required>
    </div>
    <div class="form-group">
      <label for="level" class="control-label">Nivel del grupo</label>
      <input type="number" class="form-control" name="group-level" required>
    </div>
    <div class="form-group">
      <label for="status">Estado</label>
        <select class="form-control" name="status">
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
        </select>
    </div>
    <div class="form-group clearfix">
      <button type="submit" name="add" class="btn btn-info">Guardar</button>
    </div>
  </form>
</div>

<?php include_once('layouts/footer.php'); ?>
