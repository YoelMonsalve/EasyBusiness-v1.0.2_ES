<?php
  $page_title = 'Agregar producto';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
?>
<?php
  if(isset($_POST['add_product'])){
    $req_fields = array('product-title','partNo', 'product-categorie','product-quantity','buying-price', 'saleing-price');
    validate_fields($req_fields);
    if (empty($errors)) {
      $p_name  = remove_junk($db->escape($_POST['product-title']));
      $partNo  = remove_junk($db->escape($_POST['partNo'])); 
      $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
      $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
      $p_buy   = remove_junk($db->escape($_POST['buying-price']));
      $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
      if( isset($_POST['location']) ) 
        $location = remove_junk($db->escape($_POST['location']));
      else
        $location = "";
      if (is_null($_POST['product-image-id']) || !($_POST['product-image-id']) || !is_numeric($_POST['product-image-id'])) {
        $media_id = '0';
      } else {
        $media_id = intval(remove_junk($db->escape($_POST['product-image-id'])));
      }
      $date    = make_date();
      $query  = "INSERT INTO products (";
      $query .=" name,partNo,quantity,buy_price,sale_price,categorie_id,media_id,location,date";
      $query .=") VALUES (";
      $query .=" '{$p_name}', '${partNo}', '{$p_qty}', '{$p_buy}', '{$p_sale}', '{$p_cat}', '{$media_id}', '${location}', '{$date}'";
      $query .=")";
      //$query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
      if($db->query($query)){
        $session->msg('s',"Producto agregado exitosamente. ");
        redirect(SITE_URL.'add_product.php', false);
      } else {
        $session->msg('d',' Lo siento, registro falló.' . $db->get_last_error());
        //$session->msg('d',' Lo siento, registro falló.');
        redirect(SITE_URL.'products.php', false);
      }
   } else{
     $session->msg("d", $errors);
     redirect(SITE_URL.'add_product.php',false);
   }
 }
?>

<?php include_once('layouts/header.php'); ?>

<!-- carousel -->
<link rel="stylesheet" href="lib/css/carousel.css">
<link rel="stylesheet" href="lib/css/edit_product.css">

<div class="row">
  <div class="col-md-9">
    <?php echo display_msg($session->msg()); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-9">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <i class="glyphicon glyphicon-plus-sign"></i>
          <span>Agregar producto</span>
       </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label for="" class="control-label">COD/Part No</label>
                  <input type="text" class="form-control form-control-primary rounded" id="partNo" name="partNo" placeholder="" autofocus>
                </div>
                <div class="col-md-6">
                  <label for="" class="control-label">Nombre/T&iacute;tulo</label>
                  <input type="text" class="form-control form-control-primary rounded" name="product-title" placeholder="">
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <span id="display-carousel" class="pull-left" style="display: block"><a href="#!">Cambiar</a></span>
                </div>
              </div>
              <div class="row">
                  <!-- Carousel ... --> 
                <div class="product-slider col-md-12">
                <!--<div class="clearfix">-->
                  <div id="thumbcarousel" class="carousel slide" data-interval="false" style="display:none">
                    <!--<ol class="carousel-indicators">
                      <li data-target="#thumbcarousel" data-slide-to="0" class="active"></li>
                      <li data-target="#thumbcarousel" data-slide-to="1"></li>
                      <li data-target="#thumbcarousel" data-slide-to="2"></li>
                    </ol>
                    -->

                    <div class="carousel-inner">
                      <div class="item active">
                        <?php for($i=0; $i<4 && $i < count($all_photo); $i++): 
                          $photo = $all_photo[$i]; ?>
                          <div data-target="#carousel" data-slide-to="<?php echo $i?>" class="thumb">
                            <img id="<?php printf("img_id_%d", $photo['id']);?>" src="uploads/products/<?php echo $photo['file_name'];?>" class="img-thumbnail img-fluid rounded" data-target="#product-image">
                          </div>
                        <?php endfor;?>
                      </div>
                      <div class="item">
                        <?php for($i=4; $i < count($all_photo); $i++): 
                          $photo = $all_photo[$i]; ?>
                          <div data-target="#carousel" data-slide-to="<?php echo $i?>" class="thumb">
                            <img id="<?php printf("img_id_%d", $photo['id']);?>" src="uploads/products/<?php echo $photo['file_name'];?>" class="img-thumbnail img-fluid rounded" data-target="#product-image">
                          </div>
                        <?php endfor;?>
                      </div>
                    </div>
                    <!-- navigation/control -->
                    <a class="carousel-control left" href="#thumbcarousel" role="button" data-slide="prev">
                      <span class="carousel-control-icon vertical-center" aria-hidden="true">
                        <!--<i class="fa fa-chevron-left"></i>-->
                        <i class="glyphicon glyphicon-chevron-left"></i>
                      </span>
                    </a>
                    <a class="carousel-control right" href="#thumbcarousel" role="button" data-slide="next">
                      <span class="carousel-control-icon" aria-hidden="true">
                        <!--<i class="fa fa-chevron-right"></i>-->
                        <i class="glyphicon glyphicon-chevron-right"></i>
                      </span>
                    </a>
                  </div>
                <!--</div>-->
                </div>

                <!-- Product image -->
                <div class="col-md-6">
                  
                  <img class="img-thumbnail" style="height: 10em;" id="product-image" src="uploads/products/no_image.jpg" alt="" data-toggle="tooltip" data-placement="right" title="doble clic para cambiar">
                  <input type="hidden" name="product-image-id" id="product-image-id" value="0">
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label for="" class="control-label">Categor&iacute;a</label>
                  <select class="form-control rounded-left" name="product-categorie">
                    <option value="">Selecciona una categor&iacute;a</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?>  
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="" class="control-label">Ubicaci&oacute;n</label>
                  <input type="text" class="form-control rounded" name="location" placeholder="">
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col-md-3">
                  <label for="" class="control-label">Cantidad</label>
                  <input type="number" class="form-control input-number rounded" name="product-quantity" placeholder="" value="1">
                </div>
                <div class="col-md-3"><!--separator--></div>
                <div class="col-md-3">
                  <label for="" class="control-label">Precio compra</label>
                  <input type="text" class="form-control rounded text-right" name="buying-price" placeholder="" value="1.00">
                </div>
                <div class="col-md-3">
                  <label for="" class="control-label">Precio venta</label>
                  <input type="text" class="form-control rounded text-right" name="saleing-price" placeholder="" value="1.00">
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row" style="margin-top: 2.5em;">
                <div class="col-md-12">
                  <button type="submit" name="add_product" class="btn btn-primary">
                  Agregar producto </button>
                </div>
              </div>
            </div>
        </form>
       </div>
      </div>
    </div>
  </div>
</div>

<!-- This is the jQuery background for this page -->
<script type="text/javascript" src="lib/js/add_product.js"></script>
<?php include_once('layouts/footer.php'); ?>
