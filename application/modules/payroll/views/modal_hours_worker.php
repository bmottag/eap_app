<script type="text/javascript" src="<?php echo base_url("assets/js/validate/payroll/hours.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">EDIT USER HOURS</h4>
</div>

<div class="modal-body">
	<form  name="formWorker" id="formWorker" role="form" method="post" >
		<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $information[0]["id_payroll"]; ?>"/>
		<input type="hidden" id="hddObservation" name="hddObservation" value="<?php echo $information[0]["observation"]; ?>"/>

<?php 

$start = $information[0]['start'];
$inicio = strtotime($start);
$fechaInicio = date( 'Y-m-j' , $inicio );
$horaInicio = date( 'H:i' , $inicio );

$finish = $information[0]['finish'];
if($finish != 0){
	$fin = strtotime($finish);
	$fechaFin = date( 'Y-m-j' , $fin );
	$horaFin = date( 'H:i' , $fin );
}else{
	$fin = FALSE;
	$fechaFin = FALSE;
	$horaFin = FALSE;
}

?>
		<!-- se pasan los datos anteriores para compararlos con los nuevos -->
		<input type="hidden" id="hddInicio" name="hddInicio" value="<?php echo $start; ?>"/>
		<input type="hidden" id="hddFin" name="hddFin" value="<?php echo $finish; ?>"/>
		
		<input type="hidden" id="hddfechaInicio" name="hddfechaInicio" value="<?php echo $fechaInicio; ?>"/>
		<input type="hidden" id="hddhoraInicio" name="hddhoraInicio" value="<?php echo $horaInicio; ?>"/>
		<input type="hidden" id="hddfechaFin" name="hddfechaFin" value="<?php echo $fechaFin; ?>"/>
		<input type="hidden" id="hddhoraFin" name="hddhoraFin" value="<?php echo $horaFin; ?>"/>

				
		<div class="row">
			<div class="col-sm-6">		
				<div class="form-group text-left">
					<label class="control-label" for="finish_date">Start date: *</label>
<script type="text/javascript">
	$(function(){	
		$('#start_date').daterangepicker({
			locale: {
				format: 'YYYY-MM-DD'
			},
			minDate: moment().subtract(27, 'days'),
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
				<input type="text" class="form-control has-feedback-left" id="start_date" name="start_date" aria-describedby="inputSuccess2Status" value="<?php echo $fechaInicio; ?>">
				<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
				<span id="inputSuccess2Status" class="sr-only">(success)</span>
			</div>
		</div>
	</div>
</fieldset>	
				
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Start hour: *</label>

					<div class='input-group date' id='hora_inical_picker'>	
						<input type='text' id="hora_inicio" name="hora_inicio" class="form-control" required="required" value="<?php echo $horaInicio; ?>" maxlength=8 placeholder="Start hour"/>
						<span class="input-group-addon">
						   <span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">		
				<div class="form-group text-left">
					<label class="control-label" for="finish_date">Finish date: *</label>
<script type="text/javascript">
	$(function(){	
		$('#finish_date').daterangepicker({
			locale: {
				format: 'YYYY-MM-DD'
			},
			minDate: moment().subtract(27, 'days'),
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
				<input type="text" class="form-control has-feedback-left" id="finish_date" name="finish_date" aria-describedby="inputSuccess2Status" value="<?php echo $fechaFin; ?>">
				<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
				<span id="inputSuccess2Status" class="sr-only">(success)</span>
			</div>
		</div>
	</div>
</fieldset>	
				
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label for="type" class="control-label">Finish hour: *</label>
					
					<div class='input-group date' id='hora_final_picker'>	
						<input type='text' id="hora_final" name="hora_final" class="form-control" required="required" value="<?php echo $horaFin; ?>" maxlength=8 placeholder="Finish hour"/>
						<span class="input-group-addon">
						   <span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
					
				</div>
			</div>
				
		</div>
		
		<div class="row">
			<div class="col-sm-6">		
				<div class="form-group text-left">
					<label class="control-label" for="finish_date">With lunch?</label>
					<input type="checkbox" id="lunch" name="lunch" value=1 <?php if($information[0]["lunch"]){echo "checked";} ?>>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="observation">Observation: *</label>
					<textarea id="observation" name="observation" class="form-control" rows="2"></textarea>
				</div>
			</div>
		</div>

		<div class="ln_solid"></div>
		<div class="form-group">
			<button type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" >
				Save <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">
			</button> 
		</div>
		
		<div class="form-group">
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
		
	</form>
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