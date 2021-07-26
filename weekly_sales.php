<?php
  $page_title = 'Ventas semanales';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>

<?php

  /* take the current date */
  $year  = date('Y');
  $month = date('m');
  $day   = date('d');
  
  if (isset($_POST['btn_build_report'])) {
    if (isset($_POST['date'])) {
      $date = $_POST['date'];
      if ($date = strptime($date,'%Y-%m-%d')) {
        /* valid date */
        if (isset($date['tm_year']) && isset($date['tm_mon']) && isset($date['tm_mday'])) { 
          $year  = sprintf('%04d', $date['tm_year'] + 1900);
          $month = sprintf('%02d', $date['tm_mon']  + 1);
          $day   = sprintf('%02d', $date['tm_mday']);
        }
      }
    }
    else {
      /* continue normally */    
    }
  }

  /* retrieve sales */
  $sales = weeklySales($year, $month, $day);
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($session->msg()); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <i class="glyphicon glyphicon-tasks"></i>
          <?php
            if (is_numeric($year) && is_numeric($month) && is_numeric($day))
              $target = strtotime($year.'-'.$month.'-'.$day);
            else
              $target = time();

            $day_of_week = date('w', $target);
            $monday = date('d-m-Y', strtotime('-'.($day_of_week-1).' days', $target));
            $sunday = date('d-m-Y', strtotime('+'.(7-$day_of_week).' days', $target));
          ?>
          <span>
            Reporte de salidas de la semana del <?php echo $monday; ?> al <?php echo $sunday; ?>
          </span>
        </strong>
      </div>
      <div class="panel-body">
        
        <form method="post" action="weekly_sales.php" class="clearfix">
          <div class="form-group d-block" style="">
            <div class="form-row border-0">
              <div class="col border-0 d-inline-block" style="">
                <label for="date" class="control-label">Fecha</label>
                  <input type="text" class="form-control rounded" name="date" id="date" data-date data-date-format="yyyy-mm-dd" placeholder="aaaa-mm-dd" value="<?php
                  if ($year > 0 && $month > 0 && $day > 0) echo $year.'-'.$month.'-'.$day; else echo ''; ?>">
              </div>
              <div class="col border-0 d-inline-block" style="margin-left: 2em;">
                <button type="submit" name="btn_build_report" id="btn_build_report" class="btn btn-primary rounded">Generar</button>
              </div>
            </div>
          </div>
        </form>

        <table class="table table-striped" id="tbl-sales">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;"></th>
              <th style="width: 10%;"> Part No. </th>
              <th> Nombre del producto </th>
              <th> Cliente/destino </th>
              <th> Fecha </th>
              <th class="text-center" style="width: 10%;"> Cantidad </th>
              <th class="text-right" style="width: 10%;"> Total Venta </th>
              <th class="text-right" style="width: 10%;"> Profit </th>
           </tr>
          </thead>
          <tbody>
            <?php 
              $total_qty = 0; 
              $total_sale = 0; 
              $total_profit = 0; 
            ?>
            <?php foreach ($sales as $sale):?>
            <tr>
              <td class="text-center"><?php echo count_id(); ?></td>
              <td><?php echo remove_junk($sale['partNo']); ?></td>
              <td><?php echo remove_junk($sale['name']); ?></td>
              <td><?php echo remove_junk($sale['destination']); ?></td>
              <td><?php echo remove_junk($sale['date']); ?></td>
              <td class="text-center"><?php echo (int)$sale['total_qty']; ?></td>
              <td class="text-right"><?php echo number_format( $sale['total_sale'], 2 ); ?></td>
              <td class="text-right"><?php echo number_format( $sale['total_profit'], 2 ); ?></td>
            </tr>
            <?php 
              $total_qty += (int)$sale['total_qty']; 
              $total_sale += $sale['total_sale'];
              $total_profit += $sale['total_profit'];
            ?>
            <?php endforeach;?>
            <tr>
              <td class="text-center"><?php echo count_id(); ?></td>
              <td><strong>Total</strong></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="text-center"><strong><?php echo (int)$total_qty; ?></strong></td>
              <td class="text-right"><strong><?php echo number_format($total_sale, 2); ?></strong></td>
              <td class="text-right"><strong><?php echo number_format($total_profit, 2); ?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- This is the jQuery background for this page -->
<script type="text/javascript" src="lib/js/daily_sales.js"></script>

<!-- DataTable (only for more than 10 items)-->
<?php if (count_id() > 10): ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#tbl-sales').DataTable({
    })
  })
</script>
<?php endif; ?>

<?php include_once('layouts/footer.php'); ?>
