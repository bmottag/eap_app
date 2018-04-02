<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><?php echo $titulo; ?></h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
				
					<div class="row" align="center">
						<div style="width:50%;" align="center">
							<div class="alert <?php echo $clase;?> fade in" role="alert">
								<?php echo $msj; ?>
							</div>
							
							<?php if($linkBack){ ?>
							<a class="btn btn-success" href=" <?php echo base_url($linkBack); ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a> 
							<?php } ?>
						</div>
					</div>	
					
				</div>
			</div>
		</div>
	</div>
</div>