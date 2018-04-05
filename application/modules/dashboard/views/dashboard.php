<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-users'></i> LAST PAYROLL RECORDS  </h2>
					
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>

					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
				<?php if(!$info){ ?>				
					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> There is no payroll records.
					</div>
				<?php }else{ ?>			
					<div class="table-responsive">
						<table id="datatable" class="table table-striped jambo_table bulk_action">
							<thead>
								<tr class="headings">
								<th class="column-title">User </th>
								<th class="column-title">Start</th>
								<th class="column-title">Finish</th>
								<th class="column-title">Working hours</th>
								<th class="column-title">Project</th>
								<th class="column-title">Observation</th>
								<th class="column-title">Activities</th>
								</tr>
							</thead>

							<tbody>
							<?php 
								foreach ($info as $data):
									echo "<tr>";
									echo "<td>" . $data['employee'] . "</td>";
									echo "<td class='text-center'>" . $data['start'] . "</td>";
									echo "<td class='text-center'>" . $data['finish'] . "</td>";
									echo "<td class='text-center'>" . $data['working_hours'] . "</td>";
									echo "<td>" . $data['project_name'] . "</td>";
									echo "<td>" . $data['observation'] . "</td>";
									echo "<td>" . $data['activities'] . "</td>";
									echo "</tr>";
								endforeach 
							?>
							</tbody>
						</table>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>