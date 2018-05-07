<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/password.js"); ?>"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-unlock'></i> CHANGE PASSWORD</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> Form to change the password.
					</div>
					
					<form  name="form" id="form" class="form-horizontal" method="post" action="<?php echo base_url("employee/updatePassword"); ?>" >
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $information[0]["id_user"]; ?>"/>
						<input type="hidden" id="hddUser" name="hddUser" value="<?php echo $information[0]["log_user"]; ?>"/>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombres">Firstname <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="nombres" name="nombres" required="required" class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php echo $information?$information[0]["first_name"]:""; ?>" maxlength=30 placeholder="Firstname" disabled>
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellidos">Lastname <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="apellidos" name="apellidos" required="required" class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php echo $information?$information[0]["last_name"]:""; ?>" maxlength=30 placeholder="Lastname" disabled>
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuario">User <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="usuario" name="usuario" required="required" class="form-control col-md-7 col-xs-12 has-feedback-left" value="<?php echo $information?$information[0]["log_user"]:""; ?>" maxlength=30 placeholder="User" disabled>
								<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="inputPassword" name="inputPassword" class="form-control col-md-7 col-xs-12 has-feedback-left" maxlength=12 placeholder="Password">
								<span class="fa fa-unlock form-control-feedback left" aria-hidden="true"></span>
							</div>
						</div>
						
						<div class="form-group">
							<label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="inputConfirm" name="inputConfirm" class="form-control col-md-7 col-xs-12 has-feedback-left" maxlength=12 placeholder="Confirm Password">
								<span class="fa fa-unlock form-control-feedback left" aria-hidden="true"></span>
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