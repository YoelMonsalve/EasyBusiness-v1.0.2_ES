<?php
  $page_title = 'Edit sale';
  require_once('include/load.php');
  // Checking What level user has permission to view this page
  page_require_level(1);

  //$all_categories = find_all('categories');
  $all_photos = find_all('media');

?>
<?php
  /* if sale-ID not specified, ... go back */
  if( !isset( $_GET['id'] ) )
    redirect(SITE_URL.'sales.php');

  /* Get sale record, from sale-id */
  $sale = find_by_id('sales',(int)$_GET['id']);
  $sale_time = strtotime( remove_junk($sale['date']) );

  if(!$sale) {
    $session->msg("d","Sale not found.");
    redirect(SITE_URL.'sales.php');
  }
  
  /* Get product record, from product-id */
  $product = find_by_id('products',$sale['product_id']);

  if(!$product) {
    $session->msg("d","Product not found.");
    redirect(SITE_URL.'sales.php');
  }

  /* Get category_name and media_name */
  $category_name = '';      /* default */
  if( isset($product['categorie_id']) ) {
    $category = find_by_id( 'categories', $product['categorie_id'] );
    if ( isset( $category['name'] ) )
      $category_name = $category['name'];
  }

  $media_name = '';        /* default */
  if( isset($product['media_id']) ) {
    $media = find_by_id( 'media', $product['media_id'] );
    if ( isset( $media['file_name'] ) )
      $media_name = $media['file_name'];
  }
?>

<?php
  /* UPDATING SALE
   * ====================================================== */
  if( isset($_POST['update_sale']) ) {
  
    $req_fields = array( 'quantity','sale_price','total_sale','date' );
    
    if( validate_fields($req_fields) ){

      $p_id = $product['id'];
      $s_qty     = $db->escape((int)$_POST['quantity']);
      $extra_qty = $s_qty - $sale['qty'];     /* <-- note this !!! */
      $b_price   = $product['buy_price'];
      $s_price   = $db->escape($_POST['sale_price']);
      $s_total   = $db->escape($_POST['total_sale']);
      $s_profit  = $s_total - $s_qty * $b_price;
      if (isset( $_POST['destination'] ))
        $s_dest    = $db->escape($_POST['destination']);
      else
        $s_dest    = "";

      $date      = $db->escape( $_POST['date'] );
      $s_date    = date( 'Y-m-d', strtotime( $date ) );
      $s_id      = $sale['id'];

      $sql  = "UPDATE `sales` SET";
      $sql .= " `product_id`='${p_id}'";
      $sql .= ", `qty`='${s_qty}'";
      $sql .= ", `buy_price`='${b_price}'";
      $sql .= ", `sale_price`='${s_price}'";
      $sql .= ", `total_sale`='${s_total}'";
      $sql .= ", `profit`='${s_profit}'";
      $sql .= ", `destination`='${s_dest}'";
      $sql .= ", `date`='${s_date}'";
      $sql .= " WHERE `id`=$s_id";
      
      if( $db->query($sql) ){
        if ( $extra_qty )
          substract_product_qty($extra_qty, $p_id);
        $session->msg('s',"Listo!");
        redirect(SITE_URL.'sales.php', false);
      } else {
        $session->msg( 'd','Operación falló: '.$db->get_last_error() );
        
        /* error */
        redirect(SITE_URL.'sales.php', false);
        //print( "failed" . $db->get_last_error() );
      }
    } else {
      $session->msg("d", $errors);
      
      /* error */
      redirect(SITE_URL.'sales.php',false);
    }
  }
?>

<?php include_once('layouts/header.php'); ?>
<link rel="stylesheet" href="lib/css/edit_product.css" />

<style type="text/css">
  input-group {
    margin-bottom: 1ex;
  }
  .input-group-addon {
    background-color: #f0f0f8;
  }
  .list-group li {
    background-color: #f3f9f0;
  }
  .panel {
    border-radius: 10px;
    border-width: 0;
  }
  .panel-heading {
    border-radius: 10px 10px 0 0;
    padding: 1.3em 1.3em;
    background:  #f8f9fc; /*#f5f5f5;*/
    border-bottom: 1px solid #e1e2e7;
    color: #404060;
    font-size: 130%;
    letter-spacing: 1px;
    /*padding: 15px;*/

    /*border: 1px solid gray;*/
  }
  .panel-body {
    /*border: 1px solid gray;*/
    padding: 2em;
  }
</style>

<div class="row">
  <div class="col-md-9">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-9">

    <!--<div class="panel panel-default">-->
    <div class="panel">
      <div class="panel-heading clearfix">
        <strong>
          <i class="glyphicon glyphicon-pencil"></i>
          <span>Editar Venta</span>
        </strong>
        <div class="pull-right">
          <a href="sales.php" class="btn btn-success"><i class="glyphicon glyphicon-arrow-left" style="margin-right: 4px"></i> Regresar</a>
        </div>
      </div>
      <div class="panel-body">
       <div class="col-md-12">
        <form method="post" action="edit_sale.php?id=<?php echo (int)$sale['id']?>" class="clearfix">

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="" class="control-label">COD/Part No</label>
                <span class="form-control rounded">
                  <!-- COD/PartNo is NON-editable -->
                  <?php echo remove_junk($product['partNo']); ?>
                </span>
              </div>
              <div class="col-md-6">
                <label for="" class="control-label">Nombre producto</label>
                <span class="form-control rounded">
                  <!-- Product-Name is NON-editable -->
                  <?php echo remove_junk($product['name']); ?>
                </span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <!-- Product image -->
              <div class="col-md-6">
                <?php if($product['media_id'] === 0): ?>
                  <img class="img-thumbnail" id="product-image" src="uploads/products/no_image.jpg" alt="" data-toggle="tooltip" data-placement="right" title="doble clic para cambiar">
                  <input type="hidden" name="product_image_id" id="product_image_id" value="0">
                <?php else:
                  foreach ($all_photos as $photo) {
                    if ($product['media_id'] === $photo['id']) {
                      printf("<img class=\"img-thumbnail\" id=\"product-image\" src=\"uploads/products/{$photo['file_name']}\" alt=\"{$photo['file_name']}\" >");
                    }
                  }
                endif;?>
              </div>

            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="" class="control-label">Categor&iacute;a</label>
                <span class="form-control rounded" id="category">
                  <!-- Category is NON-editable -->
                  <?php echo remove_junk($category_name); ?>
                </span>
              </div>
              <div class="col-md-6">
                <label for="" class="control-label">Ubicaci&oacute;n</label>
                <span class="form-control rounded" id="location">
                  <!-- Location is NON-editable -->
                  <?php echo remove_junk($product['location']); ?>
                </span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <label for="" class="control-label">Fecha</label>
                <div class="input-group">
                  <input type="text" class="form-control rounded" name="date" id="date" data-date data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" value="<?php echo date('Y-m-d', $sale_time );?>" >
                  
                  <!--<input type="date" class="form-control datePicker" name="date" id="date" data-date data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d', $sale_time );?>" >-->
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
              <div class="col-md-2">
                <!-- column separator -->
              </div>
              <div class="col-md-4">
                <label for="destination" class="control-label">Destino/cliente</label>
                <input type="text" class="form-control rounded" id="destination" name="destination" 
                  placeholder="" value="<?php echo remove_junk($sale['destination']); ?>" >
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-3">
                <label for="" class="control-label">Disponible <i>(antes de vender)</i></label>
                <span class="form-control rounded" id="stock">
                  <?php echo remove_junk($product['quantity']) + remove_junk($sale['qty']); ?>
                </span>
              </div>
              <div class="col-md-3">
                <!-- column separator -->
              </div>
              <div class="col-md-3">
                <label for="" class="control-label">Cantidad</label>
                <input type="number" class="form-control input-number rounded" id="quantity" name="quantity" 
                value="<?php echo remove_junk($sale['qty']); ?>" placeholder="0">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-3">
                <label for="" class="control-label">Precio compra</label> 
                <span class="form-control rounded" id="buy_price">
                  <?php echo remove_junk($sale['buy_price']); ?>
                </span>
              </div>
              <div class="col-md-3"><!-- column separator --></div>
              <div class="col-md-3">
                <label for="" class="control-label">Precio venta</label> 
                <input type="text" class="form-control rounded" id="sale_price" name="sale_price" value="<?php echo remove_junk($sale['sale_price']); ?>">
              </div>
              <div class="col-md-3">
                <label for="" class="control-label">Total Venta</label>
                <input type="text" class="form-control rounded" id="total_sale" name="total_sale" value="<?php echo remove_junk($sale['total_sale']); ?>">
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <div class="row" style="margin-top: 3em;">
              <div class="col-md-2">
                <div class="input-group">
                  <button type="submit" name="update_sale" class="btn btn-primary">Actualizar</button>
                </div>
              </div>
              <div class="col-md-2">
                <!-- column separator -->
              </div>
              <!-- DISABLED --
              <div class="col-md-1">
                <div class="input-group">
                  <button class="btn btn-warning" id="refresh">Limpiar</button>
                </div>
              </div>
            -->
            </div>
          </div>

        </form>
       </div>
      </div>
    </div>
  </div>
</div>

<!-- This is the jQuery background for this page -->
<script type="text/javascript" src="lib/js/add_sale.js"></script>

<?php include_once('layouts/footer.php'); ?>
