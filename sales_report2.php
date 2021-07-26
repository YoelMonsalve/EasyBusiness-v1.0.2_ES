<?php
$page_title = 'Reporte de ventas';
  require_once('include/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
        <form class="clearfix" method="post" action="sale_report_process.php">
          <div class="form-group">
            <label class="form-label">Rango de fechas</label>
            <div class="input-group">
              <!--<input type="text" class="form-control" id="date" name="date" placeholder="yyyy-mm-dd">-->
              <input type="date" class="form-control datePicker" name="start-date" id="start-date" data-date data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-').'01'; ?>" >
              
              <!--<input type="text" class="datepicker form-control" name="start-date" placeholder="From">-->

              <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
              <!--<input type="text" class="datepicker form-control" name="end-date" placeholder="To">-->
              <input type="date" class="form-control datePicker" name="end-date" id="end-date" data-date data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d'); ?>" >
            </div>
          </div>
          <div class="form-group">
               <button type="submit" name="submit" class="btn btn-primary">Generar Reporte</button>
          </div>
        </form>
      </div>

    </div>
  </div>

</div>
<?php include_once('layouts/footer.php'); ?>
