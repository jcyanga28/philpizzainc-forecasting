<?php $class = strtolower($this->uri->segment(1)); if($class == "home" ){ $class = "null"; } ?>
<?php $restaurant_type = $this->session->userdata('restaurant_type'); ?>
<?php $role_id = $this->session->userdata('role_id'); ?>
<?php
		$branchname = $this->session->userdata('branch');

		$explodes_arr = explode(' ',$branchname);

		if($explodes_arr[2] == TRUE){
			$locations = $explodes_arr[1] . ' ' . $explodes_arr[2] . ' ' . $explodes_arr[3];

		}else{
			$locations = $explodes_arr[1] . ' ' . $explodes_arr[2];

		}

		$branch_name = $this->session->userdata('branch');
		
		$explodes = explode(' ',$branch_name);
		
		$branch_name = strtolower($explodes[1]);

		$exsplode = explode('_',$branch_name);
		
		$branches_name = strtolower($exsplode[0]);

?>		
<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="PPI,ForecastingSystem,PhilPizzaInc">
		<meta name="description" content="Philippine Pizza Inc Forecasting Syste,">
		<meta name="author" content="Forecasting System">

		<?php if($restaurant_type=="ph"): ?>
			<title>Pizza Hut - Forecasting System</title>
			<link rel="shortcut icon" href="<?php echo base_url('style/images/ppi/ph-favicon.ico'); ?>" type="image/x-icon"/>
			<link rel="icon" href="<?php echo base_url('style/images/ppi/ph-favicon.ico'); ?>" type="image/x-icon"/>

		<?php elseif($restaurant_type=="dq"): ?>
			<title>Dairy Queen - Forecasting System</title>			
			<link rel="shortcut icon" href="<?php echo base_url('style/images/ppi/dq-favicon.ico'); ?>" type="image/x-icon"/>
			<link rel="icon" href="<?php echo base_url('style/images/ppi/dq-favicon.ico'); ?>" type="image/x-icon"/>

		<?php elseif($restaurant_type=="tb"): ?>
			<title>Taco Bell - Forecasting System</title>
			<link rel="shortcut icon" href="<?php echo base_url('style/images/ppi/tb-favicon.ico'); ?>" type="image/x-icon"/>
			<link rel="icon" href="<?php echo base_url('style/images/ppi/tb-favicon.ico'); ?>" type="image/x-icon"/>

		<?php else: ?>
			<title>Pizza Hut Bistro - Forecasting System</title>
			<link rel="shortcut icon" href="<?php echo base_url('style/images/ppi/phb-favicon.ico'); ?>" type="image/x-icon"/>
			<link rel="icon" href="<?php echo base_url('style/images/ppi/phb-favicon.ico'); ?>" type="image/x-icon"/>

		<?php endif; ?>	

		<!-- css -->
		 <link type="text/css" href="<?php echo base_url('style/css/bootstrap/bootstrap.css'); ?>" rel="stylesheet">
		 <link type="text/css" href="<?php echo base_url('style/css/backend-design.css'); ?>" rel="stylesheet">
		 <link type="text/css" href="<?php echo base_url('style/css/alert/alert.css'); ?>" rel="stylesheet">
		 
		 <link type="text/css" href="<?php echo base_url('style/css/scrolltotop/style.css'); ?>" rel="stylesheet">
		 <?php if(isset($css)){
			foreach($css as $list){
				echo '<link rel="stylesheet" type="text/css" href="/style/css/'.$list.'" media="screen" />';
			}
		 }?>
		 
		 <!--<link type="text/css" href="<?php echo base_url('style/css/chosen.css'); ?>" rel="stylesheet">-->
		 <!--<link type="text/css" href="<?php echo base_url('style/css/redmond/jquery-ui-1.8.22.custom.css'); ?>" rel="stylesheet">--> 
			 
		<!-- javascript -->
		 <script type="text/javascript" src="<?php echo base_url('style/js/jquery-1.11.0.min.js'); ?>" ></script>
		 <script type="text/javascript" src="<?php echo base_url('style/js/bootstrap/bootstrap.min.js'); ?>" ></script>
		 <script type="text/javascript" src="<?php echo base_url('style/js/hide_message.js'); ?>" ></script>

		 <script type="text/javascript" src="<?php echo base_url('style/js/scrolltotop/jquery.scrollToTop.min.js'); ?>" ></script>
		 <?php if(isset($jquery)){
			foreach($jquery as $list){
				echo '<script type="text/javascript" src="/style/js/'.$list.'" ></script>';
			}
		 }?>

		 <!--<script type="text/javascript" src="<?php echo base_url('style/js/table-sorter/table-sorter.js'); ?>" ></script>
		 <script type="text/javascript" src="<?php echo base_url('style/js/chosen.jquery.js'); ?>" ></script>
		 <script type="text/javascript" src="<?php echo base_url('style/js/datepicker/jquery-ui.js'); ?>" ></script>
		 <script type="text/javascript" src="<?php echo base_url('style/js/script.js'); ?>" ></script>-->

	</head>

		<body style="background: #fff;">
		<div>
			<a href="#top" id="toTop"></a>	

			<nav
				<?php if($branches_name=="warehouse"): ?>
						style="background: gray;"

				<?php else: ?>
						<?php if($restaurant_type=="ph"){ ?>		
							style="background: #000000;" <?php }elseif($restaurant_type=="dq"){ ?>
								style="background: #6087c8;" <?php }elseif($restaurant_type=="tb"){ ?>
								   style="background: #6d0788;"<?php }else{ ?>
									 style="background: #72100d;"	
										<?php } ?> 
				
				<?php endif; ?>

									id="nav_design" class="navbar navbar-default navbar-fixed-top" role="navigation">
				<div style="width: 76%;" class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>

						<?php if($restaurant_type=="ph"): ?>
							<a class="navbar-brand" style="margin-top:-10px;"><span><img src="<?php echo base_url('style/images/ppi/ph-small.png');?>"></img></span></a>
						<?php elseif($restaurant_type=="dq"): ?>
							<a class="navbar-brand" style="margin-top:-10px;"><span><img src="<?php echo base_url('style/images/ppi/dq-small.png');?>"></img></span></a>
						<?php elseif($restaurant_type=="tb"): ?>
							<a class="navbar-brand" style="margin-top:-10px;"><span><img src="<?php echo base_url('style/images/ppi/tb-small2.png');?>"></img></span></a>
						<?php else: ?>
						<a class="navbar-brand" style="margin-top:-13px;"><span><img src="<?php echo base_url('style/images/ppi/phb-small2.png');?>"></img></span></a>
						<?php endif; ?>

					</div>

					<div id="navbar" class="navbar-collapse collapse">
						
						<ul style="margin-left: -20px;" class="nav navbar-nav">
							<li><a href="<?php echo base_url('home'); ?>" id="nav_content">Home</a></li>
							<li class="dropdown">
							<?php if($file_maintenance=="1"): ?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="nav_content" > File Maintenance <span class="caret"></span></a>	
							<?php endif; ?>
							<ul class="dropdown-menu" role="menu">
							<?php foreach($module as $row): ?>	
							<?php if($row['module_id']=="1"): ?>
							<li><a href="<?php echo base_url('item'); ?>" id="dropdown_content"> - Item Maintenance</a></li>
							<?php elseif($row['module_id']=="2"): ?>
							<li><a href="<?php echo base_url('branch'); ?>" id="dropdown_content"> - Branch Maintenance</a></li>
							<?php elseif($row['module_id']=="3"): ?>
							<li><a href="<?php echo base_url('module'); ?>" id="dropdown_content"> - Module Maintenance</a></li>
							<?php elseif($row['module_id']=="4"): ?>
							<li><a href="<?php echo base_url('module_access'); ?>" id="dropdown_content"> - Module Access Maintenance</a></li>
							<?php elseif($row['module_id']=="5"): ?>
							<li><a href="<?php echo base_url('role'); ?>" id="dropdown_content"> - Role Maintenance</a></li>
							<?php elseif($row['module_id']=="6"): ?>
							<li><a href="<?php echo base_url('user'); ?>" id="dropdown_content"> - User Maintenance</a></li>
							<?php elseif($row['module_id']=="7"): ?>
							<li><a href="<?php echo base_url('warehouse'); ?>" id="dropdown_content"> - Warehouse Maintenance</a></li>
							<?php endif; ?>
							<?php endforeach; ?>
							</ul>
							</li>

							<li class="dropdown">
							<?php if($forecasting=="1"): ?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="nav_content" > Forecasting <span class="caret"></span></a>	
							<?php endif; ?>
							<ul class="dropdown-menu" role="menu">
							<?php foreach($module as $row): ?>	
							<?php if($row['module_id']=="8"): ?>
							<li><a href="<?php echo base_url('daily_forecasting'); ?>" id="dropdown_content"> - Daily Forecasting </a></li>
							<?php elseif($row['module_id']=="9"): ?>
							<li><a href="<?php echo base_url('monthly_forecasting'); ?>" id="dropdown_content"> - Monthly Forecasting </a></li>
							<?php elseif($row['module_id']=="10"): ?>
							<li><a href="<?php echo base_url('monthly_forecasting'); ?>" id="dropdown_content"> - Get Forecast </a></li>
							<?php endif; ?>
							<?php endforeach; ?>
							</ul>
							</li>
							
							<li class="dropdown">
							<?php if($role_id=="1"): ?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="nav_content" > Utilities <span class="caret"></span></a>	
							<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url('logs'); ?>" id="dropdown_content"> - Logs </a></li>
							<?php endif; ?>
							</ul>
							</li> 

						</ul>
						
						<ul class="nav navbar-nav navbar-right">
							<li><a id="nav_content"><span class="glyphicon glyphicon-user"></span> <b style="text-shadow: 1px 1px #000000;font-size:12px;"> Welcome, </b> &nbsp; <span style="font-size: 12px;"><b>
								
								<?php if($branches_name=="warehouse"): ?>
									<?php echo strtoupper($locations);  ?>

								<?php else: ?>	
									<?php if($restaurant_type=="ph"){ ?>		
										<?php echo "PIZZA HUT" . ' ' .strtoupper($locations);  ?><?php }elseif($restaurant_type=="dq"){ ?>
											<?php echo "DAIRYQUEEN" . ' ' .strtoupper($locations);  ?><?php }elseif($restaurant_type=="tb"){ ?>
											   <?php echo "TACO BELL" . ' ' .strtoupper($locations);  ?><?php }else{ ?>
												 <?php echo "PIZZA HUT BISTRO" . ' ' .strtoupper($locations);  ?>	
													<?php } ?> 

								<?php endif; ?>

								</b></span></a></li>							
							<li style="margin-left: -25px;" class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="nav_content" >  <span class="caret"></span></a>	
							<ul style="width: 100px;" class="dropdown-menu" role="menu">
							<?php foreach($module as $row): ?>	
							<?php if($row['module_id']=="11"): ?>
							<li><a href="<?php echo base_url('change_password'); ?>" > <span class="glyphicon glyphicon-edit"></span> <span style="font-size:12px;"> Change Password </span></a></li>
							<?php endif; ?>
							<?php endforeach; ?>
							<li><a href="<?php echo base_url('logout'); ?>" > <span class="glyphicon glyphicon-off"></span> <span style="font-size:12px;"> Logout </span></a></li>
							<li></li>
							</ul>
							</li>
						</ul>
					
					</div><!--/.nav-collapse -->
				</div>
			</nav>
			 <div id="content_container" class="content_container"> 			
			 	<div id="content">
			 		<?php
			 		if(isset($content)){
			 			if($class == "null"){
			 				echo $this->load->view($content);
			 			
			 			}else{
			 				echo $this->load->view($class . '/' . $content); 
			 			
			 			}
			 		}
			 		?>
			 	</div>
			 </div>
			 <div id="footer">
			 	<span id="footer_content">&copy; All right reserved 2014<?php echo nbs(2); ?></span>
			 </div>
		
		</div>
		<br/>

		<script type="text/javascript">
		$(function() {
			$("#toTop").scrollToTop(500);
		});
		</script>
		</body>


</html>