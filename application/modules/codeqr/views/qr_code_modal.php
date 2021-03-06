<script type="text/javascript" src="<?php echo base_url("assets/js/validate/qr_code/qr_code.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">QR Code
	<br><small>Add/Edit QR Code.</small>
	</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddId" name="hddId" value="<?php echo $information?$information[0]["id_qr_code"]:""; ?>"/>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="qr_code">QR code value : *</label>
					<input type="text" id="qr_code" name="qr_code" class="form-control" value="<?php echo $information?$information[0]["value_qr_code"]:""; ?>" placeholder="QR Code value" required >
				</div> 
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="user" >User : </label>
					<select name="user" id="user" class="form-control" >
						<option value=''>Select...</option>
						<?php for ($i = 0; $i < count($usuarios); $i++) { ?>
							<option value="<?php echo $usuarios[$i]["id_user"]; ?>" <?php if($information[0]["fk_id_user"] == $usuarios[$i]["id_user"]) { echo "selected"; }  ?>><?php echo $usuarios[$i]["name"]; ?></option>	
						<?php } ?>
					</select>
				</div> 
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="state" >State : *</label>
					<select name="state" id="state" class="form-control" required>
						<option value=''>Select...</option>
						<option value=1 <?php if($information[0]["qr_code_state"] == 1) { echo "selected"; }  ?>>Active</option>
						<option value=2 <?php if($information[0]["qr_code_state"] == 2) { echo "selected"; }  ?>>Inactive</option>
					</select>
				</div> 
			</div>
		</div>
				
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