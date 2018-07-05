<script type="text/javascript" src="<?php echo base_url("assets/js/validate/solicitud/solicitud.js"); ?>"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-list'></i> PROGRAMMING LIST,<small> organized from the most recent to the oldest.</small>
					</h2> 
					
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>

					</ul>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
				
					<a href="<?php echo base_url("programming/update_programming"); ?>" class="btn btn-success"><i class="fa fa-plus"></i> New programming</a>
				
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="alert alert-success alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<strong>Ok!</strong> <?php echo $retornoExito ?>	
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="alert alert-danger alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<strong>Error!</strong> <?php echo $retornoError ?>
	</div>	
    <?php
}
?> 
					<div class="table-responsive">
						<table id="dataTables" class="table table-striped jambo_table bulk_action dt-responsive nowrap" cellspacing="0" width="100%">

							<thead>
								<tr class="headings">
									<th class="column-title" style="width: 12%"><small>Date</small></th>
									<th class="column-title" style="width: 12%"><small>Project / Company</small></th>
									<th class="column-title" style="width: 8%"><small>Quantity</small></th>
									<th class="column-title" style="width: 8%"><small>Observation</small></th>
									<th class="column-title" style="width: 8%"><small>Links</small></th>
									<th class="column-title" style="width: 8%"><small>Done by</small></th>
								</tr>
							</thead>

							<tbody>
										
		<?php
			if($information){
				foreach ($information as $data):
					echo "<tr>";
					echo "<td><small>" . $data['date_programming'] . "</small></td>";
					echo "<td><small>" . $data['project_name'] . " / " . $data['company_name'] . "</small></td>";
					echo "<td class='text-center'><small>" . $data['quantity'] . "</small></td>";
					echo "<td><small>" . $data['observation'] . "</small></td>";
					
					echo "<td class='text-center'><small>";
					
//consultar si la fecha de la programacion es mayor a la fecha actual
$fechaProgramacion = $data['date_programming'];

$datetime1 = date_create($fechaProgramacion);
$datetime2 = date_create(date('Y-m-d'));


if($data['state'] == 2)
{
		echo '<p class="text-succedd"><strong>Done</strong></p>';
}else{
		if($datetime1 < $datetime2) {
				echo '<p class="text-danger"><strong>Overdue</strong></p>';
		}else{
				?>
		<a href='<?php echo base_url("programming/update_programming/" . $data['id_programming']); ?>' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Edit </a>
		
		<a href='<?php echo base_url("programming/add_programming_workers/" . $data['id_programming']); ?>' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> Workers </a>
				
		<button type="button" id="<?php echo $data['id_programming']; ?>" class='btn btn-danger btn-xs'>
				<i class="fa fa-trash-o"></i> Delete 
		</button>
				<?php
		}
}

?>

<a href='<?php echo base_url("programming/index/$data[id_programming]"); ?>' class='btn btn-success btn-xs'><i class='fa fa-eye'></i> Ver </a>

<?php

					echo "</small></td>";
					
					echo "<td><small>" . $data['first_name'] . " " . $data['last_name'] . "</small></td>";

					echo "</tr>";
				endforeach;
			}
		?>

							</tbody>
						</table>
					</div>
					
					
<!-- INICIO HISTORICO -->
		<?php
			if($informationWorker){
		?>
					<div class="table-responsive">					
						<table id="dataTablesWorker" class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">

							<thead>
								<tr class="headings">
									<th class="column-title" colspan="9">-- WORKERS --</th>
								</tr>
								
								<tr class="headings">
									<th class="column-title"><small>Name</small></th>
									<th class="column-title"><small>Movil</small></th>
									<th class="column-title"><small>Skills</small></th>
								</tr>
							</thead>

							<tbody>
										
		<?php
				foreach ($informationWorker as $data):
					echo "<tr>";
					echo "<td class='text-center'><small>$data[full_name]</small></td>";
					echo "<td class='text-center'><small>$data[movil_number]</small></td>";
					echo "<td class='text-center'><small>---- SKILLS ----- </small></td>";
					echo "</tr>";
				endforeach;
		?>

							</tbody>
						</table>
					</div>
		<?php
			}
		?>
<!-- FIN HISTORICO -->
					
					

				</div>
			</div>
		</div>
	</div>
</div>

<!-- Tables -->
<script>
$(document).ready(function() {
    $('#dataTables').DataTable( {
        "pageLength": 50,
        "ordering": false,
        "info":     true
    } );
	
    $('#dataTablesWorker').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false
    } );
	
	
} );
</script>