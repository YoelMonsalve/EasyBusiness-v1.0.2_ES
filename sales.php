<?php
  $page_title = 'Ver Ventas';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>

<?php
  $sales = find_all_sales();
?>
<div class="row">
  <div class="col-md-9">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span> Ventas </span>
        </strong>
        <div class="pull-right">
          <a href="add_sale.php" class="btn btn-primary">Agregar</a>
        </div>
      </div>
      <div class="panel-body">
        <table id="tbl-sales" class="table table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;"></th>
              <th> Nombre del producto </th>
              <th class="text-center" style="width: 15%;"> Cantidad</th>
              <th class="text-center" style="width: 15%;"> P. Unit.</th>
              <th class="text-center" style="width: 15%;"> Total</th>
              <th class="text-center" style="width: 15%;"> Destino </th>
              <th class="text-center" style="width: 15%;"> Fecha </th>
              <th class="text-center" style="width: 100px;"> Acciones </th>
           </tr>
          </thead>
         <tbody>
           <?php foreach ($sales as $sale):?>
           <tr>
             <td class="text-center"><?php echo count_id();?></td>
             <td><?php echo remove_junk($sale['name']); ?></td>
             <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
             <td class="text-center"><?php echo $sale['sale_price']; ?></td>
             <td class="text-center"><?php echo $sale['total_sale']; ?></td>
             <td class="text-center"><?php echo remove_junk($sale['destination']); ?></td>
             <td class="text-center"><?php echo $sale['date']; ?></td>
             <td class="text-center">
                <div class="btn-group">
                  <a href="edit_sale.php?id=<?php echo (int)$sale['id'];?>" data-toggle="tooltip" title="Editar">
                     <span class="glyphicon glyphicon-pencil"></span>
                  </a>
                  <a href="delete_sale.php?id=<?php echo (int)$sale['id'];?>" data-toggle="tooltip" title="Borrar">
                    <span class="glyphicon glyphicon-trash"></span>
                  </a>
                </div>
             </td>
           </tr>
           <?php endforeach;?>
         </tbody>
       </table>
      </div>
    </div>
  </div>
</div>

<!-- This is the jQuery background for this page -->
<script type="text/javascript" src="lib/js/sales.js"></script>

<?php include_once('layouts/footer.php'); ?>
