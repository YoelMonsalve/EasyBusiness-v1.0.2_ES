<?php
  $page_title = 'Ventas mensuales';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>

<?php
  /* converts a numeric month [1-12] into a string,
   * in the current language */
  function month_to_string($i) 
  {
    if (!is_numeric($i)) return "";
    $str = Array(
      1 => 'Enero',
      2 => 'Febrero',
      3 => 'Marzo',
      4 => 'Abril',
      5 => 'Mayo',
      6 => 'Junio',
      7 => 'Julio',
      8 => 'Agosto',
      9 => 'Septiembre',
      10 => 'Octubre',
      11 => 'Noviembre',
      12 => 'Diciembre'
    );
    if (isset($str[intval($i)])) 
      return $str[intval($i)];
    else
      return "";
  }
?>

<?php

  /* default to the current date */
  $year  = date('Y');
  $month = date('m');

  if (isset($_POST['btn_build_report'])) {
    if (isset($_POST['year']) && isset($_POST['month'])) {
      if (is_numeric($_POST['year']) && is_numeric($_POST['month'])) {
        $year = $_POST['year'];
        $month = $_POST['month'];
      }
    }
  }
  if (($sales = monthlySales($year, $month)) == NULL) {
    /*$session->msg("w", sprintf("No se encontraron ventas para {$month}/{$year}"));*/
  }
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
          <span>Reporte de salidas del mes <?php echo month_to_string($month).'-'.$year;?></span>
        </strong>
      </div>

      <div class="panel-body">
        <form method="post" action="monthly_sales.php" class="clearfix">

          <div class="form-group d-block" style="">
            <div class="form-row border-0">
              <div class="col border-0 d-inline-block" style="">
                <label for="year" class="control-label">A&ntilde;o</label>
                <select class="form-control rounded" name="year" id="year" value="<?php echo ($year ? $year : date('Y')); ?>" placeholder="" style="width: 8em">
                  <?php 
                    for ($i=intval(date('Y'))-9; $i<=date('Y'); $i++) {
                      echo "<option value=\"{$i}\"";
                      if (intval($year ? $year : date('Y')) == $i) echo "selected";
                      echo ">{$i}</option>\n";
                    }
                  ?>
                </select>
              </div>
              <div class="col border-0 d-inline-block" style="margin-left: 2em">
                <label for="month" class="control-label">Mes</label>
                <select class="form-control rounded" name="month" id="month" value="<?php echo ($month ? $month : date('m')); ?>" placeholder="" style="width: 8em">
                  <?php 
                  for ($i=1; $i<=12; $i++) {
                    printf("<option value=\"%02d\"%s> %s </option>\n", 
                    $i, 
                    intval($month ? $month : date('m')) == $i ? " selected" : "",
                    month_to_string($i));
                  }
                  ?>
                </select>
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
              <td class="text-center"><?php echo count_id();?></td>
              <td><?php echo remove_junk($sale['partNo']); ?></td>
              <td><?php echo remove_junk($sale['name']); ?></td>
              <td class="text-center"><?php echo (int)$sale['total_qty']; ?></td>
              <td class="text-right"><?php echo number_format( $sale['total_sale'], 2 ); ?></td>
              <td class="text-right"><?php echo number_format( $sale['total_profit'], 2 ); ?></td>
              <!--<td class="text-center"><?php echo date("Y/m/d", strtotime ($sale['date'])); ?></td>-->
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
              <td class="text-center"><strong><?php echo (int)$total_qty; ?></strong></td>
              <td class="text-right"><strong><?php echo number_format($total_sale, 2 ); ?></strong></td>
              <td class="text-right"><strong><?php echo number_format($total_profit, 2 ); ?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

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
