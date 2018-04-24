<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-road'></i> PROJECT LIST </h2>
					
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>

					</ul>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
				
					<a href="<?php echo base_url("admin/update_project"); ?>" class="btn btn-info"><i class="fa fa-plus"></i> Add Project</a>
				
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
					
						<table id="datatable" class="table table-striped jambo_table bulk_action">

							<thead>
								<tr class="headings">
								<th class="column-title">ID </th>
								<th class="column-title">Project name</th>
								<th class="column-title">Project number</th>
								<th class="column-title">Address</th>
								<th class="column-title">Company</th>
								<th class="column-title">Foreman</th>
								<th class="column-title">State</th>
								<th class="column-title">Links</th>
								</tr>
							</thead>

							<tbody>
										
		<?php 
		if($info){
			foreach ($info as $data):
				echo "<tr>";
				echo "<td>" . $data['id_project'] . "</td>";
				echo "<td>" . $data['project_name'] . "</td>";
				echo "<td>" . $data['project_number'] . "</td>";
				echo "<td>" . $data['address'] . "</td>";
				echo "<td>" . $data['company_name'] . "</td>";
				echo "<td>" . $data['foreman'] . "</td>";
				echo "<td>";
					switch ($data['project_state']) {
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
				echo "<td>";
				echo "<a href='" . base_url("admin/update_project/" . $data['id_project']) . "' class='btn btn-info btn-xs'><i class='fa fa-pencil'></i> Edit </a>";

				echo "<a href='" . base_url("admin/purchase_order_number/" . $data['id_project']) . "' class='btn btn-warning btn-xs'><i class='fa fa-plus'></i> PO No. </a>";
				
				echo "</td>";
				echo "</tr>";
			endforeach;
		}
		?>

							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>