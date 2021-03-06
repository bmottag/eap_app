<script>
$(function(){ 
			
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'admin/cargarModalCompany',
                data: {'idCompany': oID},
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
					<h2><i class='fa fa-building'></i> COMPANY LIST </h2>
					
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>

					</ul>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">

					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal" id="x" >
						<i class="fa fa-plus"></i> Add Company
					</button>
				
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

				<?php if(!$info){ ?>				
					<div class="alert alert-success alert-dismissible fade in" role="alert">
						<strong>Info:</strong> There is no company records.
					</div>
				<?php }else{ ?>
					<div class="table-responsive">
					
						<table id="dataTables" class="table table-striped jambo_table bulk_action table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
							<thead>
								<tr class="headings">
								<th class="column-title">ID </th>
								<th class="column-title">Company name</th>
								<th class="column-title">Contact</th>
								<th class="column-title">Movil</th>
								<th class="column-title">Email</th>
								<th class="column-title">Fax</th>
								<th class="column-title">Address</th>
								<th class="column-title">Website</th>
								<th class="column-title">Links</th>
								</tr>
							</thead>

							<tbody>
		<?php 
			foreach ($info as $data):
				echo "<tr>";
				echo "<td>" . $data['id_company'] . "</td>";
				echo "<td>" . $data['company_name'] . "</td>";
				echo "<td>" . $data['contact'] . "</td>";
				echo "<td>" . $data['movil_number'] . "</td>";
				echo "<td>" . $data['email'] . "</td>";
				echo "<td>" . $data['fax'] . "</td>";
				echo "<td>" . $data['address'] . "</td>";
				echo "<td>" . $data['website'] . "</td>";

				echo "<td>";
		?>
				<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $data['id_company']; ?>" >
					Edit <span class="glyphicon glyphicon-edit" aria-hidden="true">
				</button>
				
				<a href='<?php echo base_url("admin/company_contacts/" . $data['id_company']); ?>' class='btn btn-warning btn-xs'><i class='fa fa-plus'></i> More contacts </a>
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

<!-- Tables -->
<script>
$(document).ready(function() {
    $('#dataTables').DataTable( {
        "pageLength": 50
    } );
} );
</script>