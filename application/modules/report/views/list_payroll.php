<script>
$(function(){ 
			
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'report/cargarModalHours',
                data: {'idPayroll': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});

});

</script>


<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-book'></i> PAYROLL RECORDS </h2>
					
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
								<th class="column-title">Date & time</th>
								<th class="column-title">Project</th>
								<th class="column-title">Observation</th>
								<th class="column-title">Activities</th>
								<th class="column-title">Working hours</th>
								<th class="column-title">Total hours</th>
								</tr>
							</thead>

							<tbody>
							<?php 
								$total = 0;
								foreach ($info as $data):
									echo "<tr>";
									echo "<td>" . $data['employee'] . "</td>";
									echo "<td>";
									echo "<strong>Start</strong><br>" . $data['start'];
									echo "<br><strong>Finish</strong><br>" . $data['finish']. "<br>";

						?>
								<button type="button" class="btn btn-info btn-xs btn-block" data-toggle="modal" data-target="#modal" id="<?php echo $data['id_payroll']; ?>" >
									Edit Hours <span class="glyphicon glyphicon-edit" aria-hidden="true">
								</button>									
						<?php

									echo "</td>";
									echo "<td>" . $data['project_name'] . "</td>";
									echo "<td>" . $data['observation'] . "</td>";
									echo "<td>" . $data['activities'] . "</td>";
									echo "<td class='text-right'>" . $data['working_hours'] . "</td>";
									$total = $data['working_hours'] + $total;
									echo "<td class='text-right'><strong>" . $total . "</strong></td>";
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

<!--INICIO Modal cambio de hora-->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal-->