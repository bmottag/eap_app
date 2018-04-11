<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
	<nav>
	  <div class="nav toggle">
		<a id="menu_toggle"><i class="fa fa-bars"></i></a>
	  </div>

	  <ul class="nav navbar-nav navbar-right">	  
	  
		<li class="">
		  <a href="<?php echo base_url("menu/salir"); ?>" class="user-profile" aria-expanded="false">
			<i class="fa fa-sign-out"></i> Logout
		  </a>
		</li>
		
		<?php echo $topMenu; ?>
		
		<li class="">
		  <a href="<?php echo base_url("dashboard"); ?>" class="user-profile" aria-expanded="false">
			<i class="fa fa-home"></i> Home
		  </a>
		</li>

	  </ul>
	</nav>
  </div>
</div>
<!-- /top navigation -->