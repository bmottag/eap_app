<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/usuario.js"); ?>"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-users'></i> USERS</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> Form to add and edit the user information.
					</div>
				
					<form id="form" data-parsley-validate class="form-horizontal form-label-left">
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_user"]:""; ?>"/>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombres">Firstname <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="nombres" name="nombres" required="required" class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php echo $information?$information[0]["first_name"]:""; ?>" maxlength=30 placeholder="Firstname">
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellidos">Lastname <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="apellidos" name="apellidos" required="required" class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php echo $information?$information[0]["last_name"]:""; ?>" maxlength=30 placeholder="Lastname">
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">User <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="usuario" name="usuario" required="required" class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php echo $information?$information[0]["log_user"]:""; ?>" maxlength=30 placeholder="User">
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input id="email" name="email" class="form-control col-md-7 col-xs-12 has-feedback-left" type="text" value="<?php echo $information?$information[0]["email"]:""; ?>" maxlength=50 placeholder="Email">
								<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						<div class="form-group">
							<label for="celular" class="control-label col-md-3 col-sm-3 col-xs-12">Movil <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input id="celular" name="celular" class="form-control col-md-7 col-xs-12 has-feedback-left" type="text" value="<?php echo $information?$information[0]["movil"]:""; ?>" maxlength=12 placeholder="Movil">
								<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">User type <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="type" id="type" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($userType); $i++) { ?>
										<option value="<?php echo $userType[$i]["id_type"]; ?>" <?php if($information[0]["fk_id_type"] == $userType[$i]["id_type"]) { echo "selected"; }  ?>><?php echo $userType[$i]["user_type"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_name">Company name
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="company_name" name="company_name" class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php echo $information?$information[0]["company_name"]:""; ?>" maxlength=150 placeholder="Company name">
								<span class="fa fa-copyright form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gst_number">GST number 
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="gst_number" name="gst_number" class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php echo $information?$information[0]["gst_number"]:""; ?>" maxlength=100 placeholder="GST number">
								<span class="fa fa-calculator form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="hora_real">Hour price <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="hora_real" name="hora_real" class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php echo $information?$information[0]["hora_real_cad"]:""; ?>" maxlength=5 placeholder="Hour value" required="required">
								<span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="hora_contrato">Hour price LMIA </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="hora_contrato" name="hora_contrato" class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php echo $information?$information[0]["hora_contrato_cad"]:""; ?>" maxlength=5 placeholder="LMIA hour value CAD">
								<span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="rol">Rol <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="rol" id="rol" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($roles); $i++) { ?>
										<option value="<?php echo $roles[$i]["id_rol"]; ?>" <?php if($information[0]["fk_id_rol"] == $roles[$i]["id_rol"]) { echo "selected"; }  ?>><?php echo $roles[$i]["rol_name"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="estado" class="control-label col-md-3 col-sm-3 col-xs-12">State <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="state" id="state" class="form-control" required>
									<option value=''>Select...</option>
									<option value=0 <?php if($information[0]["state"] == 0) { echo "selected"; }  ?>>New user</option>
									<option value=1 <?php if($information[0]["state"] == 1) { echo "selected"; }  ?>>Active</option>
									<option value=2 <?php if($information[0]["state"] == 2) { echo "selected"; }  ?>>Inactive</option>
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