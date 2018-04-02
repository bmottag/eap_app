<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
	<nav>
	  <div class="nav toggle">
		<a id="menu_toggle"><i class="fa fa-bars"></i></a>
	  </div>

	  <ul class="nav navbar-nav navbar-right">	  
		<li class="">
		  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			<i class="fa fa-user"></i> Usuario
			<span class=" fa fa-angle-down"></span>
		  </a>
		  <ul class="dropdown-menu dropdown-usermenu pull-right">
			<li><a href="<?php echo base_url("menu/salir"); ?>"><i class="fa fa-sign-out pull-right"></i> Salir</a></li>
		  </ul>
		</li>
		
		<li class="">
		  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			<i class="fa fa-cog"></i> Configuración
			<span class=" fa fa-angle-down"></span>
		  </a>
		  <ul class="dropdown-menu dropdown-usermenu pull-right">
			<li><a href="<?php echo base_url("admin/usuarios"); ?>"><i class="fa fa-users pull-right"></i> Usuarios</a></li>
		  </ul>
		</li>

	  </ul>
	</nav>
  </div>
</div>
<!-- /top navigation -->