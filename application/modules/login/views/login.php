<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="baseurl" content="<?php echo base_url(); ?>" />
	<link rel="icon" href="<?php echo base_url("images/favicon.ico"); ?>" type="image/ico" />

    <title>EAP </title>

    <!-- Bootstrap -->
	<link href="<?php echo base_url("assets/bootstrap/vendors/bootstrap/dist/css/bootstrap.min.css"); ?>" rel="stylesheet">
    <!-- Font Awesome -->
	<link href="<?php echo base_url("assets/bootstrap/vendors/font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet">
    <!-- NProgress -->
	<link href="<?php echo base_url("assets/bootstrap/vendors/nprogress/nprogress.css"); ?>" rel="stylesheet">
    <!-- Animate.css -->
	<link href="<?php echo base_url("assets/bootstrap/vendors/animate.css/animate.min.css"); ?>" rel="stylesheet">

    <!-- Custom Theme Style -->
	<link href="<?php echo base_url("assets/bootstrap/build/css/custom.min.css"); ?>" rel="stylesheet">
	
    <!-- jQuery -->
    <script src="<?php echo base_url("assets/bootstrap/vendors/jquery/dist/jquery.min.js"); ?>"></script>
	
	<!-- jQuery validate-->
	<script type="text/javascript" src="<?php echo base_url("assets/js/general/jquery.validate.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/validate/login/login.js"); ?>"></script>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
  </head>
  
  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
		  
			<?php if(isset($msj)){?>
					<div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>
						<?php echo $msj;//mensaje de error ?>
					</div>
			<?php } ?>
		  
			<form  name="form" id="form" role="form" method="post" action="<?php echo base_url("login/validateUser"); ?>" >
              <h1>Sign in</h1>
              <div>
                <input type="text" id="inputLogin" name="inputLogin" class="form-control" placeholder="User" maxlength="15" data-minlength="3" required />
              </div>
              <div>
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required />
              </div>
              <div>
				<button type="submit" class="btn btn-eap" id='btnSubmit' name='btnSubmit'>
					Login <i class="fa fa-sign-in"></i>
				</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div>
					<h1><img src="<?php echo base_url("images/logo_eap.png"); ?>" /></h1>
					<p>©2018 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
  </body>
</html>