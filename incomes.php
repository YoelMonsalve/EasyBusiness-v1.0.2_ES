<?php
  $page_title = 'Packing List';
  require_once('include/load.php');
  page_require_level(3);
?>

<?php
$ctr = "MAEU 403564/0 O.T.";
//$incomes = find_incomes($ctr);
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">

			<!-- This is to IntelliSearch (auto-suggestion) by CTR  -->
			<form method="post" action="add_product.php" class="clearfix">
				
				<div class="form-group">
					
					<!-- Old form --><!--
					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="input-group" style="padding-left:4em">
								<span class="glyphicon glyphicon-pencil" style="padding-right: 4pt;"></span>
								<input type="text" id="search_date" name="search_date">
							</div>
						</div>
						
						<div class="col-md-4 col-sm-6">
							<div class="input-group" style="padding-left:4em">
								<span class="glyphicon glyphicon-pencil" style="padding-right: 4pt;"></span>
								<input type="text" id="search_partial_job" name="search_partial_job">
							</div>
						</div>
					</div>-->
					
					<div class="row">
						<!-- No. -->
						<div class="col-md-4 col-sm-6">
							<label>No.</label>
							<div class="input-group" style="padding-left:4em">
								<span class="glyphicon glyphicon-pencil" style="padding-right: 4pt;"></span>
								<input type="text" id="search_no" name="search_no">
							</div>
						</div>
						<!-- P/L No. -->
						<div class="col-md-4 col-sm-6">
							<label>P/L No.</label>
							<div class="input-group" style="padding-left:4em">
								<span class="glyphicon glyphicon-pencil" style="padding-right: 4pt;"></span>
								<input type="text" id="search_pl_no" name="search_pl_no">
							</div>
						</div>
					</div>
					
					<div class="row" style="margin-top:1em">
						<!-- Date -->
						<div class="col-md-4 col-sm-6">
							<label>Date</label>
							<div class="input-group" style="padding-left:4em">
								<span class="glyphicon glyphicon-pencil" style="padding-right: 4pt;"></span>
								<input type="text" id="search_date" name="search_date">
							</div>
						</div>
						<!-- Partial Job -->
						<div class="col-md-4 col-sm-6">
							<label>Partial Job</label>
							<div class="input-group" style="padding-left:4em">
								<span class="glyphicon glyphicon-pencil" style="padding-right: 4pt;"></span>
								<input type="text" id="search_partial_job" name="search_partial_job">
							</div>
						</div>
					</div>
					
					<div class="row" style="margin-top:1em">
						<!-- P. Contract -->
						<div class="col-md-4 col-sm-6">
							<label>P. Contract</label>
							<div class="input-group" style="padding-left:4em">
								<span class="glyphicon glyphicon-pencil" style="padding-right: 4pt;"></span>
								<input type="text" id="search_p_contract" name="search_p_contract">
							</div>
						</div>
						<!-- CTR -->
						<div class="col-md-4 col-sm-6">
							<label>CTR</label>
							<div class="input-group" style="padding-left:4em">
								<span class="glyphicon glyphicon-pencil" style="padding-right: 4pt;"></span>
								<input type="text" id="search_search_ctr" name="search_search_ctr">
							</div>
						</div>
					</div>
				</div>
							
				<div class="form-group">
					<div class="row" style="margin-top:4em; text-align:center;">
						<div class="col-md-6">
					<div class="input-group">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary">Mostrar</button>
						</span>	
					</div>
						</div>
					</div>
				</div>
								
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary">Búsqueda</button>
						</span>	
						<input type="text" id="sug_input" class="form-control" name="title" 
							placeholder="Buscar por CTR">
					</div>
					<div id="result" class="list-group"></div>
				</div>
			</form>

      <form method="post" action="update_incomes.php">

      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span> Packing List </span>
          </strong>
          <div class="pull-right">
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div>
        </div>
        
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <!-- table header -->
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 4em;"> No. of Pkgs.</th>
                <th class="text-center" style="width: 6em;"> Pkg. Mark. No.</th>
                <th class="text-center" style=""> Description </th>
                <th class="text-center" style="width: 4em;"> Dimensions</th>
                <th class="text-center" style="width: 4em;"> G.W. Kg.</th>
                <th class="text-center" style="width: 4em;"> Tare Kg.</th>
                <th class="text-center" style="width: 4em;"> N.W. Kg.</th>
                <th class="text-center" style="width: 10em;"> CTR</th>
                <th class="text-center" style="width: 4em;"> Dispatched</th>
                <th class="text-center" style="width: 4em;"> Received</th>
                <!--<th class="text-center" style="width: 8em;"> Acciones</th>-->
             </tr>
            </thead>
           <tbody>
           	<!--
             <?php foreach ($incomes as $entry):?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td class="text-center"><?php echo (int)$entry['no_of_pkgs']; ?></td>
               <td class="text-center"><?php echo (int)$entry['pkg_mark_no']; ?></td>
               <td class="text-center"><?php echo str_replace( "\n", '<br/>', $entry['description'] ); ?> </td>
               <td class="text-center"><?php echo remove_junk($entry['dimensions']); ?> </td>
               <td class="text-center"><?php echo remove_junk($entry['gw_kg']); ?></td>
               <td class="text-center"><?php echo remove_junk($entry['tare_kg']); ?></td>
               <td class="text-center"><?php echo remove_junk($entry['nw_kg']); ?></td>
               <td class="text-center"><?php echo remove_junk($entry['ctr']); ?></td>
               <td class="text-center"><input type="checkbox" name="dispatched_id_<?php echo $entry['id']; ?>" <?php if( $entry['dispatched'] == 'y' ) echo "checked value =\"1\""; ?>></td>
               <td class="text-center"><input type="checkbox" name="received_id_<?php echo $entry['id']; ?>" <?php if( $entry['received'] == 'y' ) echo "checked value =\"1\""; ?>></td>

             </tr>
             <?php endforeach;?>
            -->
           </tbody>
        </table>
        </div>
      </div>
    </form>
    </div>
  </div>
<?php include_once('layouts/footer.php'); ?>
