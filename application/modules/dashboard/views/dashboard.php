<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-book'></i> LAST PAYROLL RECORDS  </h2>
					
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>

					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

				<?php if(!$infoProjects){ ?>				
					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> There is no payroll records.
					</div>
				<?php }else{ ?>	
				
				<?php 
					
					$ci = &get_instance();
					$ci->load->model("general_model");
					
					$userRol = $this->session->userdata("rol");
					$arrParam = array();
					
					if($userRol==3){ //If it is a normal user, just show the records of the user session
						$arrParam["idUser"] = $this->session->userdata("id");
						$arrParam["limit"] = 30;//Limite de registros para la consulta
					}
				
					foreach ($infoProjects as $data):
				?>
					<div class="table-responsive">
						<table id="datatable" class="table table-striped jambo_table bulk_action">
							<thead>
								<tr class="headings">
									<th class="column-title" colspan="7"><strong>Project: </strong> <?php echo $data['project_name']; ?> </th>
								</tr>
								<tr class="headings">
								<th class="column-title" style="width: 15%">User </th>
								<th class="column-title" style="width: 17%">Start</th>
								<th class="column-title" style="width: 17%">Finish</th>
								<th class="column-title" style="width: 10%">Working hours</th>
								<th class="column-title" style="width: 21%">Observation</th>
								<th class="column-title" style="width: 20%">Activities</th>
								</tr>
							</thead>

							<tbody>
							<?php 
							
								//consultar registros
								$arrParam["idProject"] = $data["fk_id_project"];
								$info = $this->general_model->get_payroll($arrParam);
								
								foreach ($info as $data):
									echo "<tr>";
									echo "<td>" . $data['employee'] . "</td>";
									echo "<td>";
									echo "<strong>Start</strong><br>" . date('F j, Y, g:i a', strtotime($data['start']));
									echo "<br><strong>Adjusted start</strong><br>" . date('F j, Y, g:i a', strtotime($data['adjusted_start']));
									echo "</td>";
									echo "<td>";
									if($data['finish'] == 0){
										echo "-";
									}else{
										echo "<strong>Finish</strong><br>" . date('F j, Y, g:i a', strtotime($data['finish']));
										echo "<br><strong>Adjusted finish</strong><br>" . date('F j, Y, g:i a', strtotime($data['adjusted_finish']));
									}
									echo "</td>";
									echo "<td class='text-center'>" . $data['working_hours'] . "</td>";
									echo "<td>" . $data['observation'] . "</td>";
									echo "<td>" . $data['activities'] . "</td>";
									echo "</tr>";
								endforeach;
							?>
							</tbody>
						</table>
					</div>
				<?php
					endforeach;
				?>

				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>