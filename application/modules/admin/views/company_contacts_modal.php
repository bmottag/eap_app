<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/contact.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Contacts Form</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdCompany" name="hddIdCompany" value="<?php echo $idCompany; ?>"/>
		<input type="hidden" id="hddIdContact" name="hddIdContact" value="<?php echo $information?$information[0]["id_contact"]:""; ?>"/>		

		<div class="row">			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="contact">Contact name *</label>
					<input type="text" id="contact" name="contact" class="form-control" value="<?php echo $information?$information[0]["contact_name"]:""; ?>" placeholder="Contact" required >
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="position">Contact position</label>
					<input type="text" id="position" name="position" class="form-control" value="<?php echo $information?$information[0]["contact_position"]:""; ?>" placeholder="Position" required >
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="movilNumber">Movil number *</label>
					<input type="text" id="movilNumber" name="movilNumber" class="form-control" value="<?php echo $information?$information[0]["contact_movil"]:""; ?>" placeholder="Movil number" required >
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group text-left">
					<label class="control-label" for="email">Email *</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo $information?$information[0]["contact_email"]:""; ?>" placeholder="Email" />
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