<script type="text/javascript" src="<?php echo base_url("assets/js/validate/admin/password.js"); ?>"></script>

<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class='fa fa-user'></i> PROFILE</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
						<div class="profile_img">
							<div id="crop-avatar">
								<!-- Current avatar -->
								<?php if($UserInfo[0]['photo']){ ?>
								<img src="<?php echo base_url($UserInfo[0]["photo"]); ?>" class="img-responsive avatar-view" alt="Employee Photo" />
								<?php } ?>
							</div>
						</div>
						<h3><?php echo $UserInfo[0]['name']; ?></h3>

						<ul class="list-unstyled user_data">
								<li>
									<i class="fa fa-user user-profile-icon"></i> <?php echo $UserInfo[0]['log_user']; ?>
								</li>
								
								<li>
									<i class="fa fa-phone user-profile-icon"></i> <?php echo $UserInfo[0]['movil']; ?>
								</li>
						
								<li>
									<i class="fa fa-envelope user-profile-icon"></i> <?php echo $UserInfo[0]['email']; ?>
								</li>
						
						
							<?php if($UserInfo[0]['address']){ ?>
								<li>
									<i class="fa fa-map-marker user-profile-icon"></i> <?php echo $UserInfo[0]['address']; ?>
								</li>
							<?php } ?>
						</ul>

						<a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
						<br />

					</div>
					<div class="col-md-9 col-sm-9 col-xs-12">

						<div class="profile_title">
							<div class="col-md-6">
								<h2>User photo</h2>
							</div>
							<div class="col-md-6">

							</div>
						</div>
						
						<form  name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url("employee/do_upload"); ?>">
						
							<div class="form-group">
								<label class="col-sm-4 control-label" for="hddTask">Photo</label>
								<div class="col-sm-5">
									 <input type="file" name="userfile" capture="camera" accept="image/*">
								</div>
							</div>
							
							<div class="form-group">
								<div class="row" align="center">
									<div style="width:50%;" align="center">
										<input type="submit" id="btnSubmit" name="btnSubmit" value="Upload" class="btn btn-primary"/>
									</div>
								</div>
							</div>
							
							<?php if($error){ ?>
							<div class="alert alert-danger">
								<?php 
									echo "<strong>Error :</strong>";
									pr($error); 
								?><!--$ERROR MUESTRA LOS ERRORES QUE PUEDAN HABER AL SUBIR LA IMAGEN-->
							</div>
							<?php } ?>
							<div class="alert alert-danger">
									<strong>Note :</strong><br>
									Allowed format: gif - jpg - png<br>
									Maximum size: 3000 KB<br>
									Maximum width: 2024 pixels<br>
									Maximum height: 2008 pixels<br>

							</div>
							
						</form>

						<!-- start of user-activity-graph -->
						<div id="graph_bar_2" style="width:100%; height:280px;"></div>
						<!-- end of user-activity-graph -->

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- morris.js -->
<script src="<?php echo base_url("assets/bootstrap/vendors/raphael/raphael.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/bootstrap/vendors/morris.js/morris.min.js"); ?>"></script>

<script>
			
			if ($('#graph_bar_2').length){ 
			
				Morris.Bar({
				  element: 'graph_bar_2',
				  data: [
					{device: 'AJA', geekbench: 380},
					{device: 'iPhone 4S', geekbench: 655},
					{device: 'iPhone 3GS', geekbench: 275},
					{device: 'iPhone 5', geekbench: 1571},
					{device: 'iPhone 5S', geekbench: 655},
					{device: 'iPhone 6', geekbench: 2154},
					{device: 'iPhone 6 Plus', geekbench: 1144},
					{device: 'iPhone 6S', geekbench: 2371},
					{device: 'iPhone 6S Plus', geekbench: 1471},
					{device: 'Other', geekbench: 1371}
				  ],
				  xkey: 'device',
				  ykeys: ['geekbench'],
				  labels: ['Geekbench'],
				  barRatio: 0.4,
				  barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
				  xLabelAngle: 35,
				  hideHover: 'auto',
				  resize: true
				});

			}	

</script>