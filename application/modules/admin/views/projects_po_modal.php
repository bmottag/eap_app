<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/purchase_order.js"); ?>"></script>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">Purchase Order Form</h4>
</div>

<div class="modal-body">
	<form name="form" id="form" role="form" method="post" >
		<input type="hidden" id="hddIdProject" name="hddIdProject" value="<?php echo $idProject; ?>"/>
		<input type="hidden" id="hddIdProjectPO" name="hddIdProjectPO" value="<?php echo $information?$information[0]["id_purchase_order"]:""; ?>"/>		

		<div class="row">			
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="purchase_order">Purchase order number *</label>
					<input type="text" id="purchase_order" name="purchase_order" class="form-control" value="<?php echo $information?$information[0]["purchase_order"]:""; ?>" placeholder="Purchase order number" required >
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-left">
					<label class="control-label" for="description">Description </label>
					<textarea id="description" name="description" placeholder="Description"  class="form-control" rows="3"><?php echo $information?$information[0]["description"]:""; ?></textarea>
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