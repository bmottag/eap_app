<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-users'></i> USERS LIST </h2>
					
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>

					</ul>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="alert alert-success alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
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
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<strong>Error!</strong> <?php echo $retornoError ?>
	</div>	
    <?php
}
?> 				
					<a href="<?php echo base_url("admin/update_usuario"); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add User</a>
				
					<div class="table-responsive">
					
						<table id="dataTables" class="table table-striped jambo_table bulk_action table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
							<thead>
								<tr class="headings">
								<th class="column-title">Name </th>
								<th class="column-title">Email</th>
								<th class="column-title">Movil</th>
								<th class="column-title">User type</th>
								<th class="column-title">Rol</th>
								<th class="column-title">Hour price</th>
								<th class="column-title">Hour price LMIA</th>
								<th class="column-title">State</th>
								<th class="column-title">Links</th>
								<th class="column-title">Company name</th>
								<th class="column-title">GST number</th>
								<th class="column-title">User</th>
								</tr>
							</thead>

							<tbody>
										
		<?php 
			foreach ($info as $data):
				echo "<tr>";
				echo "<td>" . $data['first_name'] . " " . $data['last_name'] . "</td>";
				echo "<td>" . $data['email'] . "</td>";
				echo "<td>" . $data['movil'] . "</td>";
				
				$LMIA = "";
				//si es PAYROLL y tiene precio LMIA entonces lo identifico
				if($data['fk_id_type'] == 3 && $data['hora_contrato_cad'] > 0){
					$LMIA = " <span class='badge'>LMIA</span>";
				}
				
				echo "<td class='text-center'>";				
				echo '<button class="btn btn-sm ' . $data['style'] . ' btn-block" type="button">' . $data['user_type'] . $LMIA . '</button>';
				echo "</td>";
				
				echo "<td class='text-center'>";
				echo '<p class="' . $data['estilos'] . '"><strong>' . $data['rol_name'] . '</strong></p>';
				echo "</td>";
				
				echo "<td class='text-right'>$ " . $data['hora_real_cad'] . "</td>";
				echo "<td class='text-right'>$ " . $data['hora_contrato_cad'] . "</td>";
				
				echo "<td class='text-center'>";
					switch ($data['state']) {
						case 1:
							$valor = 'Active';
							$clase = "text-success";
							break;
						case 2:
							$valor = 'Inactive';
							$clase = "text-danger";
							break;
					}
					echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
				echo "</td>";
				echo "<td class='text-center'>";
				echo "<a href='" . base_url("admin/update_usuario/" . $data['id_user']) . "' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Edit </a>";
				echo "<a href='" . base_url("admin/change_password/" . $data['id_user']) . "' class='btn btn-default btn-xs'><i class='glyphicon glyphicon-lock'></i> Change password </a>";				
				echo "</td>";
				echo "<td>" . $data['company_name'] . "</td>";
				echo "<td>" . $data['gst_number'] . "</td>";
				echo "<td>" . $data['log_user'] . "</td>";
				echo "</tr>";
			endforeach 
		?>

							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- Tables -->
<script>
$(document).ready(function() {
    $('#dataTables').DataTable( {
        "pageLength": 50
    } );
} );
</script>