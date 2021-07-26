<?php
  $page_title = 'Lista de categorías';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_categories = find_all('categories')
?>
<?php
 if(isset($_POST['add_cat'])){
   $req_field = array('categorie-name');
   validate_fields($req_field);
   $cat_name = remove_junk($db->escape($_POST['categorie-name']));
   if(empty($errors)){
      $sql  = "INSERT INTO categories (name)";
      $sql .= " VALUES ('{$cat_name}')";
      if ($db->query($sql)) {
        $session->msg("s", "Categoría agregada exitosamente.");
        redirect(SITE_URL.'categorie.php', false);
      } else {
        $session->msg("d", "Lo siento, registro falló");
        redirect(SITE_URL.'categorie.php', false);
      }
   } else {
     $session->msg("d", $errors);
     redirect(SITE_URL.'categorie.php', false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>

  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
  </div>
   <div class="row">
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <i class="glyphicon glyphicon-plus-sign"></i>
            <span>Agregar categoría</span>
          </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="categorie.php">
            <div class="form-group">
                <input type="text" class="form-control" name="categorie-name" placeholder="Nombre de la categoría" required>
            </div>
            <button type="submit" name="add_cat" class="btn btn-primary">Agregar categoría</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <i class="glyphicon glyphicon-list"></i>
          <span>Lista de categorías</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;"></th>
                    <th>Categorías</th>
                    <th class="text-center" style="width: 100px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_categories as $cat):?>
                <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td><?php echo remove_junk(ucfirst($cat['name'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="edit_categorie.php?id=<?php echo (int)$cat['id'];?>" data-toggle="tooltip" title="Editar">
                          <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="delete_categorie.php?id=<?php echo (int)$cat['id'];?>" data-toggle="tooltip" title="Eliminar">
                          <span class="glyphicon glyphicon-trash"></span>
                        </a>
                      </div>
                    </td>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
       </div>
    </div>
    </div>
   </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
