<script type="text/javascript" src="<?php echo base_url("assets/js/validate/payroll/payrollStart.js"); ?>"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-users'></i> PAYROLL - START</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> Form to save the start working hour, with the project you are working.
					</div>
				
					<form id="form" data-parsley-validate class="form-horizontal form-label-left" method="post" action="<?php echo base_url("payroll/savePayroll"); ?>" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_user"]:""; ?>"/>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="project">Project name<span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="project" id="project" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($project); $i++) { ?>
										<option value="<?php echo $project[$i]["id_project"]; ?>" <?php if($information[0]["fk_id_project_start"] == $project[$i]["id_project"]) { echo "selected"; }  ?>><?php echo $project[$i]["project_name"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="observation">Observation </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea id="observation" name="observation" placeholder="Observation"  class="form-control" rows="2"><?php echo $information?$information[0]["observation"]:""; ?></textarea>
							</div>
						</div>

						<div class="ln_solid"></div>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								<div class="row" align="center">
									<div style="width:50%;" align="center">
										<button type="button" id="btnSubmit" name="btnSubmit" class='btn btn-success'>
												Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
										</button>								
									</div>
								</div>
							</div>
						</div>
												
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
								
								<div id="div_load" style="display:none">		
									<div class="progress progress-striped active">
										<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
											<span class="sr-only">45% completado</span>
										</div>
									</div>
								</div>
								<div id="div_error" style="display:none">			
									<div class="alert alert-danger"><span class="glyphicon glyphicon-remove" id="span_msj"> &nbsp;</span></div>
								</div>	
								
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>