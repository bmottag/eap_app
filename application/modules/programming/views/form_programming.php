<script type="text/javascript" src="<?php echo base_url("assets/js/validate/programming/programming.js"); ?>"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-users'></i> PROGRAMMING</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> Form to add or update a programming.
					</div>
				
					<form id="form" data-parsley-validate class="form-horizontal form-label-left">
						<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_programming"]:""; ?>"/>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							
<script type="text/javascript">
	$(function(){	
		$('#date_programming').daterangepicker({
			locale: {
				format: 'YYYY-MM-DD'
			},
			minDate: moment(),
			singleDatePicker: true,
			singleClasses: "picker_1"
		}, function(start, end, label) {
				console.log(start.toISOString(), end.toISOString(), label);
		});
	})
</script>
				
<fieldset>
	<div class="control-group">
		<div class="controls">
			<div class="col-md-11 xdisplay_inputx form-group has-feedback">
				<input type="text" class="form-control has-feedback-left" id="date_programming" name="date_programming" aria-describedby="inputSuccess2Status">
				<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
				<span id="inputSuccess2Status" class="sr-only">(success)</span>
			</div>
		</div>
	</div>
</fieldset>

							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="project">Project / Company <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="project" id="project" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($project); $i++) { ?>
										<option value="<?php echo $project[$i]["id_project"]; ?>"><?php echo $project[$i]["project_name"] . " / " . $project[$i]["company_name"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>	

						<div class="form-group">
							<label for="quantity" class="control-label col-md-3 col-sm-3 col-xs-12">Quantity <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="quantity" id="quantity" class="form-control" required>
									<option value='' >Select...</option>
									<?php for ($i = 1; $i <= 15; $i++) { ?>
										<option value='<?php echo $i; ?>' <?php if ($information && $i == $information[0]["quantity"]) { echo 'selected="selected"'; } ?> ><?php echo $i; ?></option>
									<?php } ?>									
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="observation">Observation <span class="required">*</span></label>
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
												Guardar <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
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