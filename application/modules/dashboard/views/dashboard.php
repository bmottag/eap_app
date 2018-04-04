<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">

				<div class="x_content">
								
					<div class="table-responsive">
					
						<table id="datatable" class="table table-striped jambo_table bulk_action">

							<thead>
								<tr class="headings">
								<th class="column-title">User </th>
								<th class="column-title">Start</th>
								<th class="column-title">Finish</th>
								<th class="column-title">Working hours</th>
								<th class="column-title">Project start</th>
								<th class="column-title">Project finish</th>
								<th class="column-title">Observation</th>
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
				echo "<td>" . $data['project_start'] . "</td>";
				echo "<td>" . $data['project_finish'] . "</td>";
				echo "<td>" . $data['observation'] . "</td>";


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