<script type="text/javascript" src="<?php echo base_url("assets/js/validate/programming/programming.js"); ?>"></script>

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
		<?php
			if($idProgramming != 'x'){
		?>
				<div class="btn-group">
					<a href="<?php echo base_url("programming/update_programming"); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New programming</a>
					<a href="<?php echo base_url().'programming/calendar'; ?>" class="btn btn-warning btn-sm"><span class="fa fa-calendar" aria-hidden="true"></span> Calendar </a>
					<a href="<?php echo base_url().'programming'; ?>" class="btn btn-default btn-sm"><span class="fa fa-list" aria-hidden="true"></span> Programming list </a>
				</div>
				<br><br>
		<?php
			}else{
		?>
				<div class="btn-group">
					<a href="<?php echo base_url("programming/update_programming"); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New programming</a>
					<a href="<?php echo base_url().'programming/calendar'; ?>" class="btn btn-warning btn-sm"><span class="fa fa-calendar" aria-hidden="true"></span> Calendar </a>
				</div>
				<br><br>
		<?php
			}
		?>
				
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
									<th class="column-title" style="width: 10%"><small>Date</small></th>
									<th class="column-title" style="width: 15%"><small>Project / Company</small></th>
									<th class="column-title" style="width: 10%"><small>Quantity</small></th>
									<th class="column-title" style="width: 20%"><small>Observation</small></th>
									<th class="column-title" style="width: 30%"><small>Links</small></th>
									<th class="column-title" style="width: 15%"><small>Done by</small></th>
								</tr>
							</thead>

							<tbody>
										
		<?php
			if($information){
				foreach ($information as $data):
					echo "<tr>";
					echo "<td class='text-center'><small>" . $data['date_programming'] . "</small></td>";
					echo "<td><small>" . $data['project_name'] . " / " . $data['company_name'] . "</small></td>";
					echo "<td class='text-center'><small>" . $data['quantity'] . "</small></td>";
					echo "<td><small>" . $data['observation'] . "</small></td>";
					
					echo "<td class='text-center'><small>";
					
//consultar si la fecha de la programacion es mayor a la fecha actual
$fechaProgramacion = $data['date_programming'];

$datetime1 = date_create($fechaProgramacion);
$datetime2 = date_create(date('Y-m-d'));

?>
							
<?php
		if($datetime1 < $datetime2) {
				echo '<p class="text-danger"><strong>OVERDUE</strong></p>';
		}else{
			
			if($data['state'] == 2)
			{
				echo '<p class="text-success"><strong>DONE</strong></p>';
			}elseif($data['state'] == 1){
				echo '<p class="text-danger"><strong>INCOMPLETE</strong></p>';
			}
?>

			<a href='<?php echo base_url("programming/update_programming/" . $data['id_programming']); ?>' class='btn btn-info btn-xs' title="Edit"><i class='fa fa-pencil'></i></a>
			
			<a href='<?php echo base_url("programming/add_programming_workers/" . $data['id_programming']); ?>' class='btn btn-warning btn-xs' title="Workers"><i class='fa fa-users'></i></a>
					
			<button type="button" id="<?php echo $data['id_programming']; ?>" class='btn btn-danger btn-xs' title="Delete">
					<i class="fa fa-trash-o"></i>
			</button>
			
<?php
		}
?>

			<a href='<?php echo base_url("programming/index/$data[id_programming]"); ?>' class='btn btn-success btn-xs' title="View"><i class='fa fa-eye'></i></a>


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
									<th class="column-title" style="width: 20%"><small>Name</small></th>
									<th class="column-title text-center"><small>Movil</small></th>
									<th class="column-title text-center"><small>Skills</small></th>
								</tr>
							</thead>

							<tbody>
										
							<?php
								$ci = &get_instance();
								$ci->load->model("general_model");
								
								foreach ($informationWorker as $data):
									echo "<tr>";
									echo "<td ><small>$data[full_name]</small></td>";
									echo "<td class='text-center'><small>$data[movil_number]</small></td>";
									echo "<td class='text-center'><small>";

									//listado de habilidades por usuario
									$arrParam = array("idWorker" => $data['id_programming_users']);
									$found = $ci->general_model->get_programming_skills($arrParam); //buscamos lista de habilidades por usuario
									if($found){
										foreach ($found as $listaSkills):
											echo "<small>" . $listaSkills['skill'] . "<br></small>";
										endforeach;
									}
									
									echo "</small></td>";
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