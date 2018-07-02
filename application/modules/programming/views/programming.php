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
				
		<button type="button" id="<?php echo $data['id_programming']; ?>" class='btn btn-danger btn-xs'>
				<i class="fa fa-trash-o"></i> Delete 
		</button>
				<?php
		}
}

?>

<a href='<?php echo base_url("solicitud/solicitudes_usuario/$data[fk_id_user]/$data[id_solicitud]"); ?>' class='btn btn-success btn-xs'><i class='fa fa-eye'></i> Ver </a>

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
			if($informationHistorico){
		?>
					<div class="table-responsive">					
						<table id="dataTablesHistorico" class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">

							<thead>
								<tr class="headings">
									<th class="column-title" colspan="9">-- Historial --</th>
								</tr>
								
								<tr class="headings">
									<th class="column-title" style="width: 11%"><small>Fecha registro</small></th>
									<th class="column-title" style="width: 8%"><small>No. CPU</small></th>
									<th class="column-title" style="width: 9%"><small>Hora inicio</small></th>
									<th class="column-title" style="width: 8%"><small>Hora fin</small></th>
									<th class="column-title" style="width: 10%"><small>No. items</small></th>
									<th class="column-title" style="width: 17%"><small>Grupo items</small></th>
									<th class="column-title" style="width: 14%"><small>Tipificación</small></th>
									<th class="column-title" style="width: 14%"><small>Usuario</small></th>
									<th class="column-title" style="width: 8%"><small>Estado</small></th>
								</tr>
							</thead>

							<tbody>
										
		<?php
				foreach ($informationHistorico as $data):
					echo "<tr>";
					echo "<td class='text-center'><small>$data[fecha_solicitud]</small></td>";
					echo "<td class='text-center'><small>" . $data['numero_computadores'] . "</small></td>";
					echo "<td class='text-center'><small>" . $data['hora_inicial'] . "</small></td>";
					echo "<td class='text-center'><small>" . $data['hora_final'] . "</small></td>";
					echo "<td class='text-center'><small>";
					if (99 == $data["numero_items"])
					{ 
						echo 'Sin definir'; 
					}else{
						echo $data['numero_items'];
					}
					echo "</small></td>";
					echo "<td><small>";
					echo "<strong>" . $data['examen'] . "</strong> - ";
					if($data['fk_id_prueba'] == 69){
						echo $data['cual_prueba'] . " - ";
						echo $data['cual'];
					}else{
						echo $data['prueba'];
					}
					echo "</small></td>";
					echo "<td><small>" . $data['tipificacion'] . "</small></td>";
					echo "<td><small>" . $data['first_name'] . " " . $data['last_name'] . "</small></td>";

					echo "<td class='text-center'><small>";
						switch ($data['estado_solicitud']) {
							case 1:
								$valor = 'Nueva';
								$clase = "text-success";
								break;
							case 2:
								$valor = 'Eliminada';
								$clase = "text-danger";
								break;
							case 3:
								$valor = 'Modificada';
								$clase = "text-info";
								break;
						}
						echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
						
						if($data['incumplio'] == 1){
							echo '<p class="text-warning"><strong>Incumplió</strong></p>';
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
	
    $('#dataTablesHistorico').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false
    } );
	
	
} );
</script>