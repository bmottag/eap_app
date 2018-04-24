<script>
$(function(){ 
	$(".btn-default").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalCompanyContacts',
                data: {'idCompany': oID, 'idContact': 'x'},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});	
	
	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalCompanyContacts',
                data: {'idCompany': '', 'idContact': oID},
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
					<h2><i class='fa fa-building'></i> COMPANY CONTACTS</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
				
					<div class="alert alert-success">
						<ul class="fa-ul">
							<li>
								<i class="fa fa-info-circle fa-lg fa-li"></i> <strong>Company contacts</strong> list.
							</li>
						</ul>
					</div>
					
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
	<div class="alert alert-success alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
		</button>
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
		<strong>Error!</strong> <?php echo $retornoError ?>
	</div>	
    <?php
}
?> 

					<div class="col-md-3 col-sm-3 col-xs-12 profile_left">

						<ul class="list-unstyled user_data">
							<li>
								<i class="fa fa-building user-profile-icon"></i> <strong>Company:</strong> <?php echo $infoCompany[0]["company_name"]; ?>
							</li>

							<li>
								<i class="fa fa-map-marker user-profile-icon"></i> <strong>Address:</strong> <?php echo $infoCompany[0]["address"]; ?>
							</li>
						</ul>
						
						<div class="col-md-12">
							<div class="btn-group">

								<a class="btn btn-sm btn-primary" href="<?php echo base_url().'admin/company'; ?>"><span class="fa fa-reply" aria-hidden="true"></span> Go back </a>

								<button type="button" class="btn btn-sm btn-default"  data-placement="top" data-toggle="modal" data-target="#modal" data-original-title="Add contact" id="<?php echo $infoCompany[0]["id_company"]; ?>">
									<i class="fa fa-plus"></i> Add
								</button>

							</div>
						</div>
						
					 </div>

					<div class="col-md-9 col-sm-9 col-xs-12">

						<table class="table table-striped projects">
							<thead>
								<tr>
									<th style="width: 1%">#</th>
									<th style="width: 30%">Contact name</th>
									<th style="width: 30%">Position</th>
									<th style="width: 15%">Movil</th>
									<th style="width: 15%">Email</th>
									<th >Edit</th>
								</tr>
							</thead>
							<tbody>
		<?php
			$i = 0;
			if($infoContacts){
				foreach ($infoContacts as $data):
					$i++;
					echo "<tr>";
					echo "<td>" . $i . "</td>";
					echo "<td>" . $data['contact_name'] . "</td>";
					echo "<td>" . $data['contact_position'] . "</td>";
					echo "<td>" . $data['contact_movil'] . "</td>";
					echo "<td>" . $data['contact_email'] . "</td>";
					echo "<td>";
		?>
				<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $data['id_contact']; ?>" >
					Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
				</button>
		<?php
					echo "</td>";
					echo "</tr>";
				endforeach;
			}
		?>
								
							</tbody>
						</table>
						
					</div>
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