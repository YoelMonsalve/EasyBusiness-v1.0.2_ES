<?php
  require_once('../includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect(SITE_URL.'index.php', false);}
?>

<?php
 // Auto suggestion
  $html = '';
  if(isset($_POST['product_name']) && strlen($_POST['product_name']))
  {
    
    /* this in an error here, as this will contamine the HTML */
    //echo display_msg( array('info', "Buscando " . $_POST['product_name'] ) );

    $products = find_product_by_title($_POST['product_name']);
    if($products){
      $i=0;
      foreach ($products as $product):
        $i++;
        $html .= "<li id=\"product_list_item_${i}\" class=\"list-group-item\">";
        $html .= $product['name'];
        $html .= "</li>";
      endforeach;
    } else {
      // ... WFT ?
      //$html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
      
      $html .= '<li class=\"list-group-item\">';
      $html .= 'No encontrado';
      $html .= "</li>";
    }

    //echo json_encode($html);
    echo $html;
   }
 ?>
 <?php
 // find all product
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));
    if($results = find_all_product_info_by_title($product_title)){
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
    } else {
        $html ='<tr><td>El producto no se encuentra registrado en la base de datos</td></tr>';
    }

    //echo json_encode($html);
    echo $html;
  }
 ?>
