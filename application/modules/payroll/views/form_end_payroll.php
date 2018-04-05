<script type="text/javascript" src="<?php echo base_url("assets/js/validate/payroll/payrollStart.js"); ?>"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-book'></i> PAYROLL - FINISH</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> Form to save the finish working hour, with the project you are working.
					</div>
					
					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Start time:</strong> <?php echo $information[0]["start"]; ?><br>
						<strong>Project:</strong> <?php echo $information[0]["project_name"]; ?>
					</div>
				
					<form id="form" data-parsley-validate class="form-horizontal form-label-left" method="post" action="<?php echo base_url("payroll/updatePayroll"); ?>" >
						<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $information[0]["id_payroll"]; ?>"/>
						<input type="hidden" id="hddObservationStart" name="hddObservationStart" value="<?php echo $information[0]["observation"]; ?>"/>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="activities">Activities </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea id="activities" name="activities" placeholder="Activities"  class="form-control" rows="3"></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="observation">Observation </label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea id="observation" name="observation" placeholder="Observation"  class="form-control" rows="3"></textarea>
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