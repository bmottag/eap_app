<script>
$(function(){ 
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalProjectPO',
                data: {'idProject': oID, 'idPO': 'x'},
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
				url: base_url + 'admin/cargarModalProjectPO',
                data: {'idProject': '', 'idPO': oID},
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
					<h2><i class='fa fa-building'></i> PURCHASE ORDER NUMBER</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
				
					<div class="alert alert-warning alert-dismissible fade in" role="alert">
						<strong>Info:</strong> List of purchase order number by project.
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
							<li><i class="fa fa-road user-profile-icon"></i> <strong>Project:</strong> <?php echo $infoProject[0]["project_name"]; ?>
							</li>

							<li>
								<i class="fa fa-dashboard user-profile-icon"></i> <strong>Project No.:</strong> <?php echo $infoProject[0]["project_number"]; ?>
							</li>
						</ul>
				
						<ul class="list-unstyled user_data">
							<li>

<button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal" id="<?php echo $infoProject[0]["id_project"]; ?>">
	<i class="fa fa-plus"></i> Add purchase order number
</button>
							
<a class="btn btn-warning btn-block" href=" <?php echo base_url().'admin/project'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Go back </a>
		
							</li>
							
						</ul>
					 </div>

					<div class="col-md-9 col-sm-9 col-xs-12">

						<table class="table table-striped projects">
							<thead>
								<tr>
									<th style="width: 1%">#</th>
									<th style="width: 25%">Purchase order number</th>
									<th style="width: 55%">Description</th>
									<th >Edit</th>
								</tr>
							</thead>
							<tbody>
		<?php
			$i = 0;
			if($infoPO){
				foreach ($infoPO as $data):
					$i++;
					echo "<tr>";
					echo "<td>" . $i . "</td>";
					echo "<td>" . $data['purchase_order'] . "</td>";
					echo "<td>" . $data['description'] . "</td>";
					echo "<td>";
		?>
				<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $data['id_purchase_order']; ?>" >
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