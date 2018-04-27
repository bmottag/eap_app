<script type="text/javascript" src="<?php echo base_url("assets/js/validate/payroll/payroll_advanced.js"); ?>"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-book fa-fw'></i>ADD PAYROLL </h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
				
					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> The following form is to add or edit a payroll
					</div>
				
					<form id="form" data-parsley-validate class="form-horizontal form-label-left">

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="project">Project name <span class="required">*</span></label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="project" id="project" class="form-control" >
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($project); $i++) { ?>
										<option value="<?php echo $project[$i]["id_project"]; ?>"><?php echo $project[$i]["project_name"]; ?></option>	
									<?php } ?>
								</select>
							</div>
						</div>
					
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">User <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select name="user" id="user" class="form-control" required>
									<option value=''>Select...</option>
									<?php for ($i = 0; $i < count($userList); $i++) { ?>
										<option value="<?php echo $userList[$i]["id_user"]; ?>" <?php if($information[0]["fk_id_user"] == $userList[$i]["id_user"]) { echo "selected"; }  ?>><?php echo $userList[$i]["name"]; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_date">Start date <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">

<script type="text/javascript">
	$(function(){	
		$('#start_date').daterangepicker({
			locale: {
				format: 'YYYY-MM-DD'
			},
			minDate: moment().subtract(14, 'days'),
			maxDate: moment(),
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
				<input type="text" class="form-control has-feedback-left" id="start_date" name="start_date" aria-describedby="inputSuccess2Status">
				<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
				<span id="inputSuccess2Status" class="sr-only">(success)</span>
			</div>
		</div>
	</div>
</fieldset>	
							
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="finish_date">Finish date <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">

<script type="text/javascript">
	$(function(){	
		$('#finish_date').daterangepicker({
			locale: {
				format: 'YYYY-MM-DD'
			},
			minDate: moment().subtract(14, 'days'),
			maxDate: moment(),
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
				<input type="text" class="form-control has-feedback-left" id="finish_date" name="finish_date" aria-describedby="inputSuccess2Status">
				<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
				<span id="inputSuccess2Status" class="sr-only">(success)</span>
			</div>
		</div>
	</div>
</fieldset>	
							
							</div>
						</div>
						
<?php date("g:i a",strtotime("18:25:00")); //usarlo para cuando se vaya a editar las horas, se debe cambiar el formato ?>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="hora_inicio">Start hour <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class='input-group date' id='hora_inical_picker'>	
									<input type='text' id="hora_inicio" name="hora_inicio" class="form-control" required="required" value="<?php echo $information?$information[0]["hora_inicio"]:""; ?>" maxlength=8 placeholder="Start hour"/>
									<span class="input-group-addon">
									   <span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="hora_final">Finish hour <span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class='input-group date' id='hora_final_picker'>	
									<input type='text' id="hora_final" name="hora_final" class="form-control" required="required" value="<?php echo $information?$information[0]["hora_final"]:""; ?>" maxlength=8 placeholder="Finish hour"/>
									<span class="input-group-addon">
									   <span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
</div> 
						
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

<!-- bootstrap-datetimepicker -->    	
<script src="<?php echo base_url("assets/bootstrap/vendors/moment/min/moment.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/bootstrap/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"); ?>"></script>


<script type="text/javascript">
    $('#hora_inical_picker').datetimepicker({
		format: 'hh:mm A'
    });
	
    $('#hora_final_picker').datetimepicker({
        format: 'hh:mm A'
    });
</script>