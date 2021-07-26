<?php
  require_once('../include/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect(SITE_URL.'index.php', false);}
?>

<?php
  $results = array();
  $html = '';

  if( isset($_POST['partNo']) && strlen($_POST['partNo']) )
  {
    
    /* this in an error here, as this will contamine the HTML */
    //echo display_msg( array('info', "Buscando " . $_POST['product_name'] ) );
    if ( isset($_POST['match']) && strtolower($_POST['match']) === "full" ) {
      /* return full info for product */
      $results = find_product_by_partNo( $_POST['partNo'], 0 );

      /* add category_name and media_name */
      $results['category_name'] = '';        /* default */
      if( isset($results['categorie_id']) ) {
        $category = find_by_id( 'categories', $results['categorie_id'] );
        if ( isset( $category['name'] ) )
          $results['category_name'] = $category['name'];
      }

      $results['media_name'] = '';        /* default */
      if( isset($results['media_id']) ) {
        $media = find_by_id( 'media', $results['media_id'] );
        if ( isset( $media['file_name'] ) )
          $results['media_name'] = $media['file_name'];
      }
    }
    else {
      /* partial match: looks coincidences for partNo */
      $items = find_product_by_partNo( $_POST['partNo'], 1 );
      if ( $items ) {
        foreach( $items as $item ) {
          $results[] = $item['partNo'];
        }
      }
    }
    //
    //print_r( $results );
    if( !$results ) {
      $results[] = "(no encontrado)";
    }
    echo json_encode( $results );
   }

  /* Query by product_name (partial product name) */
  if(isset($_POST['product_name']) && strlen($_POST['product_name']))
  {
    
    /* this in an error here, as this will contamine the HTML */
    //echo display_msg( array('info', "Buscando " . $_POST['product_name'] ) );

    $products = find_product_by_title($_POST['product_name']);
    if($products){
      $i=0;
      foreach ($products as $product):
        $i++;

        /* === DEPRECATED ===
         * by Yoel.- 2020.06.05
         *
        $html .= "<li id=\"product_list_item_${i}\" class=\"list-group-item\">";
        $html .= $product['name'];
        $html .= "</li>";
         */
        $results[] = $product['name'];
      endforeach;
    } else {
      // ... WFT ?
      //$html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
      
      /* === DEPRECATED ===
       * by Yoel.- 2020.06.05
      $html .= '<li class=\"list-group-item\">';
      $html .= 'No encontrado';
      $html .= "</li>";
       */
      $results[] = "(no encontrado)";
    }

    echo json_encode( $results );
   }
 ?>

 <?php
  /* Query by p_name (full product name) */
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));

    //print_r( find_product_by_partNo( 'TOR_HEX_001' ) );

    if($results = find_all_product_info_by_title($product_title)){

      if ( sizeof($results) > 0 ) $results = $results[0];

      $results['category_name'] = '';        /* default */
      if( isset($results['categorie_id']) ) {
        $category = find_by_id( 'categories', $results['categorie_id'] );
        if ( isset( $category['name'] ) )
          $results['category_name'] = $category['name'];
      }

      $results['media_name'] = '';        /* default */
      if( isset($results['media_id']) ) {
        $media = find_by_id( 'media', $results['media_id'] );
        if ( isset( $media['file_name'] ) )
          $results['media_name'] = $media['file_name'];
      }

      /* === DEPRECATED ===
       * by Yoel.- 2020.06.05
      foreach ($results as $result) {

        $html .= "<tr>";

        $html .= "<td id=\"s_name\">".$result['name']."</td>";
        $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\">";
        $html  .= "<td>";
        $html  .= "<input type=\"text\" class=\"form-control\" name=\"price\" value=\"{$result['sale_price']}\">";
        $html  .= "</td>";
        $html .= "<td id=\"s_qty\">";
        $html .= "<input type=\"text\" class=\"form-control\" name=\"quantity\" value=\"1\">";
        $html  .= "</td>";
        $html  .= "<td>";
        $html  .= "<input type=\"text\" class=\"form-control\" name=\"total\" value=\"{$result['sale_price']}\">";
        $html  .= "</td>";
        $html  .= "<td>";
        $html  .= "<input type=\"text\" class=\"form-control\" name=\"destination\" value=\"\">";
        $html  .= "</td>";
        $html  .= "<td>";
        $html  .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\">";
        $html  .= "</td>";
        $html  .= "<td>";
        $html  .= "<button type=\"submit\" name=\"add_sale\" class=\"btn btn-primary\">Procesar</button>";
        $html  .= "</td>";
        $html  .= "</tr>";
      }
       */
    } else {

      //$html ='<tr><td>El producto no se encuentra registrado en la base de datos</td></tr>';
      $results = array( );
    }

    /* Deprecated --> changed to JSON */
    //echo json_encode($html);
    //echo $html;

    print( json_encode($results) );
  }
?>
