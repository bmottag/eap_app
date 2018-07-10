<script type="text/javascript" src="<?php echo base_url("assets/js/validate/programming/programming_workers.js"); ?>"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-users'></i> PROGRAMMING - ADD WORKERS</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					
					<div class="alert alert-success">
						<ul class="fa-ul">
							<li>
								<i class="fa fa-info-circle fa-lg fa-li"></i> <strong>Workers list.</strong> Select and save the workers to the programming.
							</li>
						</ul>
					</div>
				
					<div class="col-md-3 col-sm-3 col-xs-12 profile_left">

						<ul class="list-unstyled user_data">
							<li>
								<i class="fa fa-building user-profile-icon"></i> <strong>Project / Company:</strong><br> <?php echo $infoProgramming[0]['project_name'] . " / " . $infoProgramming[0]["company_name"]; ?>
							</li>

							<li>
								<i class="fa fa-calendar user-profile-icon"></i> <strong>Date:</strong> <?php echo date('F j, Y', strtotime($infoProgramming[0]["date_programming"])); ?>
							</li>
							
							<li>
								<i class="fa fa-tachometer user-profile-icon"></i> <strong>Quantity:</strong> <?php echo $infoProgramming[0]["quantity"]; ?>
							</li>
							
							<li>
								<i class="fa fa-comment user-profile-icon"></i> <strong>Observation:</strong><br> <?php echo $infoProgramming[0]["observation"]; ?>
							</li>
						</ul>
						
						<div class="col-md-12">
							<div class="btn-group">
								<a class="btn btn-sm btn-primary" href="<?php echo base_url().'programming'; ?>"><span class="fa fa-reply" aria-hidden="true"></span> Go back </a>
							</div>
						</div>
						
					 </div>
					
					<div class="col-md-9 col-sm-9 col-xs-12">
				
						<form name="form" id="form" data-parsley-validate class="form-horizontal form-label-left" method="post">
							<input type="hidden" id="hddId" name="hddId" value="<?php echo $idProgramming; ?>"/>
							
							<div class="table-responsive">
								<table class="table table-striped jambo_table bulk_action table-bordered" cellspacing="0" width="100%">
															
									<thead>
										<tr class="headings">
											<th class="column-title text-center" style="width: 10%">Check </th>
											<th class="column-title" style="width: 45%">Worker</th>
											<th class="column-title" style="width: 45%">Skills</th>
										</tr>
									</thead>
									<?php
									$ci = &get_instance();
									$ci->load->model("general_model");
									foreach ($workersList as $lista):
									
										$arrParam = array(
											"idProgramming" => $idProgramming,
											"idUser" => $lista['id_programming_users']
										);
										$found = $ci->general_model->get_programming_workers($arrParam);
										
										echo "<tr>";
										echo "<td class='text-center'>";
										$data = array(
											'name' => 'workers[]',
											'id' => 'workers',
											'value' => $lista['id_programming_users'],
											'checked' => $found
										);
										echo form_checkbox($data);
										echo "</td>";
										echo "<td>" . $lista["full_name"] . "</td>";
										
										echo "<td>";

										//listado de habilidades por usuario				
										$arrParam = array("idWorker" => $lista['id_programming_users']);
										$skills = $ci->general_model->get_programming_skills($arrParam); //buscamos lista de habilidades por usuario
										if($skills){
											foreach ($skills as $listaSkills):
												echo $listaSkills['skill'] . "<br>";
											endforeach;
										}				
										
										echo "</td>";
										
										echo "</tr>";
									endforeach
									?>
								</table>
							</div>
							
							<div class="form-group">							
								<div class="row" align="center">
									<div style="width:50%;" align="center">									 
										<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-success'>
												Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
										</button>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row" align="center">
									<div style="width:80%;" align="center">
										<div id="div_load" style="display:none">		
											<div class="progress progress-striped active">
												<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
													<span class="sr-only">45% completado</span>
												</div>
											</div>
										</div>
										<div id="div_error" style="display:none">			
											<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj">&nbsp;</span></div>
										</div>
									</div>
								</div>
							</div>						

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>