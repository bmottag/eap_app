<script>
$(function(){ 
			
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'codeqr/cargarModalQrcode',
                data: {'idQRCode': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});

});

</script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-book'></i> QR CODE LIST  </h2>
					
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="alert alert-success alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
		<strong>Ok!</strong> <?php echo $retornoExito ?>	
	</div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
	<div class="alert alert-danger alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<strong>Error!</strong> <?php echo $retornoError ?>
	</div>	
    <?php
}
?> 
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal" id="x" >
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add QR Code 
				</button>	
				<?php if(!$info){ ?>				
					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> There is no QR CODE records.
					</div>
				<?php }else{ ?>			
					<div class="table-responsive">
						<table id="datatable" class="table table-striped jambo_table bulk_action">
							<thead>
								<tr class="headings">
								<th class="column-title">Value </th>
								<th class="column-title">Image</th>
								<th class="column-title">State</th>
								<th class="column-title">Usuario</th>
								<th class="column-title">Edit</th>
								</tr>
							</thead>

							<tbody>
							<?php 
								foreach ($info as $data):
									echo "<tr>";
									echo "<td>" . $data['value_qr_code'] . "</td>";
									echo "<td>";
						?>
<a href='<?php echo base_url($data["image_qr_code"]); ?>' target='_blank'>
			<img src="<?php echo base_url($data["image_qr_code"]); ?>" class="img-rounded" width="42" height="42" />
</a>
						<?php
									echo "</td>";
									
									echo "<td>";
									switch ($data['qr_code_state']) {
										case 1:
											$valor = 'Active';
											$clase = "text-success";
											break;
										case 2:
											$valor = 'Inactive';
											$clase = "text-danger";
											break;
									}
									echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
									echo "</td>";
									
									echo "<td class='text-center'>";
									
if($data['fk_id_user']){
	echo "<p class='text-primary'>" . $data['name'] . "</br>";
	echo "<a href='" . base_url("codeqr/update_usuario/" . $data['id_qr_code']) . "' class='text-primary text-center'>Delete</a></p>";
}else{
	echo "<p class='text-danger text-center'><strong>Falta</strong></p>";
}
						
									echo "</td>";
									
									echo "<td>";
							?>
								<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $data['id_qr_code']; ?>" >
									Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
								</button>
							<?php
									echo "</td>";

									echo "</tr>";
								endforeach 
							?>
							</tbody>
						</table>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<!--INICIO Modal cambio de hora-->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal-->