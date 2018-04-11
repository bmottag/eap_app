<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/project.js"); ?>"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-road'></i> PROJECT</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> Form to add and edit projects.
					</div>
				
					<form id="form" data-parsley-validate class="form-horizontal form-label-left">
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_project"]:""; ?>"/>
						<input type="hidden" id="hddIdUserForemanAnterior" name="hddIdUserForemanAnterior" value="<?php echo $information?$information[0]["fk_id_user_foreman"]:""; ?>"/>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="project">Project name <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="project" name="project" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $information?$information[0]["project_name"]:""; ?>" maxlength=30 placeholder="Project name">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="project_number">Project number <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="project_number" name="project_number" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $information?$information[0]["project_number"]:""; ?>" maxlength=30 placeholder="Project number">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="address" name="address" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $information?$information[0]["address"]:""; ?>" maxlength=30 placeholder="Address">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="company">Company <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="company" id="company" class="form-control" required>
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($company); $i++) { ?>
										<option value="<?php echo $company[$i]["id_company"]; ?>" <?php if($information[0]["fk_id_company"] == $company[$i]["id_company"]) { echo "selected"; }  ?>><?php echo $company[$i]["company_name"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="foreman">Foreman <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="foreman" id="foreman" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($infoUser); $i++) { ?>
										<option value="<?php echo $infoUser[$i]["id_user"]; ?>" <?php if($information[0]["fk_id_user_foreman"] == $infoUser[$i]["id_user"]) { echo "selected"; }  ?>><?php echo $infoUser[$i]["name"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>						
						
						<div class="form-group">
							<label for="estado" class="control-label col-md-3 col-sm-3 col-xs-12">State <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="state" id="state" class="form-control" required>
									<option value=''>Select...</option>
									<option value=1 <?php if($information[0]["project_state"] == 1) { echo "selected"; }  ?>>Active</option>
									<option value=2 <?php if($information[0]["project_state"] == 2) { echo "selected"; }  ?>>Inactive</option>
								</select>
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