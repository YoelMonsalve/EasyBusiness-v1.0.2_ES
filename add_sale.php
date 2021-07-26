<?php
  $page_title = 'Procesar Venta';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);

  //$all_categories = find_all('categories');
  //$all_photos = find_all('media');
?>

<?php
  if (isset($_POST['add_sale'])) {
    /* at least one, partNo, or productName is required */
    if ( !validate_fields( array('partNo') ) && !validate_fields( array('product_name') ) ) {
      $session->msg("d", $errors);
      redirect(SITE_URL.'add_sale.php', false);
    }
    $req_fields = array( 'quantity','sale_price','total_sale','date' );
    
    //if(empty($errors)){
    if( validate_fields($req_fields) ){

      if ( isset( $_POST['partNo'] ) && $_POST['partNo'] ) {
        $product = find_product_by_partNo( $_POST['partNo'] );
        if ( !$product || !sizeof($product) ) {
          $session->msg("d", sprintf("No se encontró partNo='%s'", $_POST['partNo'] ) );
          redirect(SITE_URL.'add_sale.php', false);
        }
      }
      $p_id = $product['id'];
      $s_qty     = $db->escape((int)$_POST['quantity']);
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

      $sql  = "INSERT INTO sales (";
      $sql .= " product_id,qty,buy_price,sale_price,total_sale,profit,destination,date";
      $sql .= ") VALUES (";
      $sql .= "'${p_id}','${s_qty}','${b_price}','${s_price}','${s_total}','${s_profit}','${s_dest}','${s_date}'";
      $sql .= ")";

      if( $db->query($sql) ){
        substract_product_qty($s_qty, $p_id);
        $session->msg('s',"Listo!");
        
        /* error */
        redirect(SITE_URL.'add_sale.php', false);
      } else {
        $session->msg( 'd','Operación falló: '.$db->get_last_error() );
        
        /* error */
        redirect(SITE_URL.'add_sale.php', false);
      }
    } else {
      $session->msg("d", $errors);
      
      /* error */
      redirect(SITE_URL.'add_sale.php',false);
    }
  }
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-9">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-9">
    <!--<div class="panel panel-default">-->
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <i class="glyphicon glyphicon-plus"></i>
          <span>Procesar Venta</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
        <form method="post" action="add_sale.php" class="clearfix">

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <!--<div class="input-group">
                  <span class="input-group-addon"></span>-->
                <label for="" class="control-label">COD/Part No</label>
                <input type="text" class="form-control form-control-lg form-control-primary rounded" id="partNo" name="partNo" placeholder="COD/Part No" autofocus>
                <div id="lst_partNo" style="cursor: pointer;" class="list-group"></div>
              </div>
              
              <div class="col-md-6">
                <label for="" class="control-label">Nombre producto</label>
                <input type="text" class="form-control form-control-lg form-control-primary rounded" id="product_name" name="product_name" placeholder="Nombre producto">
                <div id="lst_product_name" style="cursor: pointer;" class="list-group"></div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <img class="img-thumbnail" id="product_image" src="" style="height: 10em; display:none", alt="">
                </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="" class="control-label">Categor&iacute;a</label>
                <span class="form-control rounded" id="category"></span>
              </div>
              <div class="col-md-6">
                <label for="" class="control-label">Ubicaci&oacute;n</label>
                <span class="form-control rounded" id="location"></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <label for="" class="control-label">Fecha</label>
                <div class="input-group">
                  <!--<input type="date" class="form-control datePicker" name="date" id="date" data-date data-date-format="yyyy-mm-dd" value="2021-03-15">-->
                  <input type="text" class="form-control rounded" name="date" id="date" data-date data-date-format="yyyy-mm-dd" placeholder="aaaa-mm-dd">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
              <div class="col-md-2">
                <!-- column separator -->
              </div>
              <div class="col-md-6">
                <label for="destination">Destino/Cliente</label>
                <input type="text" class="form-control rounded" id="destination" name="destination" placeholder="">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-3">
                <label for="" class="control-label">Disponible</label>
                <span class="form-control rounded" id="stock">0</span>
              </div>
              <div class="col-md-3">
                <!-- column separator -->
              </div>
              <div class="col-md-3">
                <label for="" class="control-label">Cantidad</label>
                <input type="number" class="form-control input-number rounded" id="quantity" name="quantity" placeholder="0">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <!--<div class="col-md-3">
                <label for="" class="control-label">Precio compra</label> 
                <span class="form-control rounded" id="buy_price">0.00</span>
              </div>-->
              <div class="col-md-3">
                <label for="" class="control-label">Precio venta</label> 
                <input type="text" class="form-control rounded" id="sale_price" name="sale_price" placeholder="0.00">
              </div>
              <div class="col-md-3">
                <!-- column separator -->
              </div>
              <div class="col-md-3">
                <label for="" class="control-label">Total Venta</label>
                <input type="text" class="form-control rounded" id="total_sale" name="total_sale" placeholder="0.00">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row" style="margin-top: 2.5em;">
              <div class="col-md-12">
                <button type="submit" name="add_sale" id="btn_add_sale" class="btn btn-primary pull-left">Procesar Venta</button>
                <button class="btn btn-warning pull-left" id="refresh">Limpiar</button>
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
<script type="text/javascript" src="lib/js/add_sale.js"></script>
<?php include_once('layouts/footer.php'); ?>
