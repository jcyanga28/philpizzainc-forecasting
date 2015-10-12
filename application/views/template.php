<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<title >Forecasting System</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="PPI,ForecastingSystem,PhilPizzaInc">
		<meta name="description" content="Philippine Pizza Inc Forecasting Syste,">
		<meta name="author" content="Forecasting System">

		<link rel="shortcut icon" href="<?php echo base_url('style/images/ppi/fs-favicon.ico'); ?>" type="image/x-icon"/>
		<link rel="icon" href="<?php echo base_url('style/images/ppi/fs-favicon.ico'); ?>" type="image/x-icon"/>

		<!-- css -->
		 <link type="text/css" href="<?php echo base_url('style/css/bootstrap/bootstrap.min.css'); ?>" rel="stylesheet">
		 <link type="text/css" href="<?php echo base_url('style/css/design.css'); ?>" rel="stylesheet">
		 <link type="text/css" href="<?php echo base_url('style/css/alert/alert.css'); ?>" rel="stylesheet">
		 <link type="text/css" href="<?php echo base_url('style/css/chosen.css'); ?>" rel="stylesheet">
		 <link rel="stylesheet" type="text/css" href="<?php echo base_url('style/css/style1.css'); ?>" />

		<!-- javascript -->
		 <script type="text/javascript" src="<?php echo base_url('style/js/jquery-1.11.0.min.js'); ?>" ></script>
		 <script type="text/javascript" src="<?php echo base_url('style/js/bootstrap/bootstrap.min.js'); ?>" ></script>
		 <script type="text/javascript" src="<?php echo base_url('style/js/chosen.jquery.js'); ?>" ></script>
		 <script type="text/javascript" src="<?php echo base_url('style/js/modernizr.custom.86080.js'); ?>"></script>
		
	</head>

		<body>
			<?php echo $this->load->view($content); ?>
		</body>
		<div id="footer">
			<div id="footer_content">
				<a href="<?php echo base_url('other_link/araneta_center'); ?>" style="color: #fff;">Araneta Center</a> <b style="color:#fff;">|</b> 
				<a href="<?php echo base_url('other_link/binibining_pilipinas'); ?>" style="color: #fff;">Binibining Pilipinas</a> <b style="color:#fff;">|</b>
				<a href="<?php echo base_url('other_link/dairyqueen'); ?>" style="color: #fff;">Dairy Queen</a> <b style="color:#fff;">|</b> 
				<a href="<?php echo base_url('other_link/gateway_cineplex10'); ?>" style="color: #fff;">Gateway Cineplex 10</a> <b style="color:#fff;">|</b> 
				<a href="<?php echo base_url('other_link/pizza_hut'); ?>" style="color: #fff;">Pizza Hut</a> <b style="color:#fff;">|</b> 
				<a href="<?php echo base_url('other_link/taco_bell'); ?>" style="color: #fff;">Taco Bell</a> <b style="color:#fff;">|</b> 
				<a href="<?php echo base_url('other_link/ticketnet'); ?>" style="color: #fff;">Ticketnet</a>
			</div>
		</div>

</html>