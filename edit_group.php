<?php
  $page_title = 'Editar Grupo';
  require_once('include/load.php');
  // Checking What level user has permission to view this page
  page_require_level(1);
?>

<?php
  /* This is the first consult (using GET)
   * Allows to initialize the Userform with the current
   * data of the given group ID
   *
   * NOTE: I added the condition isset() to check the ID
   * is present in the request.
   */
  if ( isset( $_GET['id'] ) ) {
    $e_group = find_by_id('user_groups',(int)$_GET['id']);
    if(!$e_group){
      $session->msg("d","Missing Group id.");
      redirect(SITE_URL.'groups.php');
    }
  }
?>

<?php
  if(isset($_POST['update'])) 
  {
    
    $req_fields = array('group-name','group-level','group-status');
    //validate_fields($req_fields);
    
    if( validate_fields( $req_fields ) ) {
      $name = remove_junk($db->escape($_POST['group-name']));
      $level = remove_junk($db->escape($_POST['group-level']));
      $status = remove_junk($db->escape($_POST['group-status']));

      $query  = "UPDATE user_groups SET ";
      $query .= "group_name='{$name}',group_level='{$level}',group_status='{$status}'";
      $query .= " WHERE ID='{$db->escape($e_group['id'])}'";
      $result = $db->query($query);

      if( $result ) {
        if ( $db->affected_rows() === 1 ) {
          //sucess
          $session->msg('s',"Grupo se ha actualizado! ");
        }
        else {
          $session->msg('i',"No se cambio informacion");
        }
        //redirect(SITE_URL.'edit_group.php?id='.(int)$e_group['id'], false);
        redirect(SITE_URL.'groups.php', false);
      }
      else {
        //failed
        $session->msg('d','No se pudo actualizar el grupo!');

        /* changed by yoel.- 2020.06.04 */
        $session->msg('w',$db->get_last_error());
        
        redirect(SITE_URL.'edit_group.php?id='.(int)$e_group['id'], false);
      }
    } 
    else {
      // error in form fields
      $session->msg("d", $errors);
      redirect(SITE_URL.'edit_group.php?id='.(int)$e_group['id'], false);
    }
  }
?>

<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
      <h3>Editar Grupo</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="edit_group.php?id=<?php echo (int)$e_group['id'];?>" class="clearfix">
        <div class="form-group">
              <label for="name" class="control-label">Nombre del grupo</label>
              <input type="name" class="form-control" name="group-name" value="<?php echo remove_junk(ucwords($e_group['group_name'])); ?>">
        </div>
        <div class="form-group">
              <label for="level" class="control-label">Nivel del grupo</label>
              <input type="number" class="form-control" name="group-level" value="<?php echo (int)$e_group['group_level']; ?>">
        </div>
        <div class="form-group">
          <label for="status">Estado</label>
              <select class="form-control" name="group-status">
                <option <?php if($e_group['group_status'] === '1') echo 'selected="selected"';?> value="1"> Activo </option>
                <option <?php if($e_group['group_status'] === '0') echo 'selected="selected"';?> value="0">Inactivo</option>
              </select>
        </div>
        <div class="form-group clearfix">
          <button type="submit" name="update" class="btn btn-info">Actualizar</button>
        </div>
    </form>
</div>

<?php include_once('layouts/footer.php'); ?>
