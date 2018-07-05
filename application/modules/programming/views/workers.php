<script>
$(function(){ 
			
	$(".btn-info").click(function () {	
			var oID = $(this).attr("id");
            $.ajax ({
                type: 'POST',
				url: base_url + 'programming/cargarModalWorkers',
                data: {'idUser': oID},
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
					<h2><i class='fa fa-users'></i> AVAILBLE USERS </h2>
					
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>

					</ul>
					<div class="clearfix"></div>
				</div>

				<div class="x_content">
				
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal" id="x" >
						<i class="fa fa-plus"></i> Add user
					</button>
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
				
					<div class="table-responsive">
					
						<table id="dataTables" class="table table-striped jambo_table bulk_action table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
							<thead>
								<tr class="headings">
								<th class="column-title">Full name </th>
								<th class="column-title">Movil </th>
								<th class="column-title">Skills</th>
								<th class="column-title">Edit</th>
								</tr>
							</thead>

							<tbody>
										
		<?php 
		if($info){
			foreach ($info as $data):
				echo "<tr>";
				echo "<td>" . $data['full_name'] . "</td>";
				echo "<td>" . $data['movil_number'] . "</td>";
				
				echo "<td class='text-center'>";
				echo "<a href='" . base_url("programming/add_workers_skills/" . $data['id_programming_users']) . "' class='btn btn-default btn-xs'><i class='glyphicon glyphicon-plus'></i> Add skill </a>";
				echo "</td>";
				
				echo "<td class='text-center'>";
				
		?>
				<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal" id="<?php echo $data['id_programming_users']; ?>" >
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

<!--INICIO Modal usuarios-->
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