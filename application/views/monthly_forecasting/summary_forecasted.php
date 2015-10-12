<script type="text/javascript">
$(document).ready(function(){

var domain ="http://"+document.domain;

$('#message').hide();

});

</script>

<!-- <div id="divLoading">
	<div class="loading" align="center" id="divImageLoader">
	    <img src="<?php echo base_url('style/images/ppi/spinner-blue.gif'); ?>" style="height: 5%; width: 5%;"></img><br/>
	    <b style="font-size:12px;color: #333;font-weight:bold;"> Please wait </b> 
	</div>
</div> -->

<!-- <div id="divLoadingBar">
	<div class="loading" align="center" id="divImageLoader">
	    <img src="<?php echo base_url('style/images/ppi/spinner-blue.gif'); ?>" style="height: 5%; width: 5%;"></img><br/>
	    <b style="font-size:12px;color: #333;font-weight:bold;"> Please wait </b> 
	</div>
</div> -->

<div id="message">

    <div style="width: 75%; color: #333;">

        <div style="margin-left: 30px;">

            <h2><span style="margin-top: 5px;" class="glyphicon glyphicon-info-sign"></span> Monthly Forecasting</h2>
            <hr/>
            <p style="font-size: 16px;" class="lead"> <?php echo nbs(3); ?> - Your Monthly Forecast was saving, Don't leave the page.</p>
            <p style="font-size: 16px;" class="lead"> <?php echo nbs(3); ?> - Make sure excel file was downloaded before leave the page.</p>
            <p style="font-size: 16px;" class="lead"> <?php echo nbs(3); ?> - Please be patient...</p>
            <hr/>

            <?php
            $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
            $pageURL .= $_SERVER["SERVER_NAME"];
            ?>

            <?php echo nbs(5); ?><a href="<?php  echo base_url('monthly_forecasting');?>">
            <button type="button" class="btn btn-default" style="font-size: 12px;font-weight:bold;"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;<b>Back to Monthly Forecasting Month-range</b></button> 
            </a>

        </div>
        <br/>

	</div>

</div>

<script type="text/javascript">
$(document).ready(function(){

var domain ="http://"+document.domain;

// $('#divcontent').hide();
// $('#divLoadingBar').hide();

// $(window).load(function () {
//     $('#divLoading').fadeOut("slow");
//     $('#divcontent').show();
// });

$('.process_excel_dq').each(function(){
$(this).click(function(){

	$('#divcontent').hide(200);
	// $("#divLoadingBar").show("slow").delay(50000).hide("slow");
	$('#message').show();
	// alert("Make sure excel file was downloaded before leave the page.")

});
});

$('.process_excel_ph').each(function(){
$(this).click(function(){

	$('#divcontent').hide(200);
	// $("#divLoadingBar").show("slow").delay(50000).hide("slow");
	$('#message').show();
	// alert("Make sure excel file was downloaded before leave the page.")

});
});

$('.process_excel_tb').each(function(){
$(this).click(function(){

	$('#divcontent').hide(200);
	// $("#divLoadingBar").show("slow").delay(50000).hide("slow");
	$('#message').show();
	// alert("Make sure excel file was downloaded before leave the page.")

});
});

$('.process_excel_phb').each(function(){
$(this).click(function(){

	$('#divcontent').hide(200);
	// $("#divLoadingBar").show("slow").delay(50000).hide("slow");
	$('#message').show();
	// alert("Make sure excel file was downloaded before leave the page.")

});
});


});
</script>

<div id="divcontent">

<?php $role_id = $this->session->userdata('role_id'); ?>
<?php $restaurant_type = $this->session->userdata('restaurant_type'); ?>
<?php
$monthstart = $this->input->get('start_month');
$monthend = $this->input->get('end_month');

$version = $this->input->get('version');

?>
<h3 style="text-align:center;" id="page_title">Update Monthly Forecasting</h3>

<hr/><br/>

	<div id="new_btn_content">

		<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
		<?php echo nbs(2); ?>
		<a href="<?php echo base_url('monthly_forecasting/save_update_forecast?monthstart=').$monthstart.'&monthend='.$monthend.'&version='.$version; ?>" style="font-family: Segoe UI Semibold;"><button type="button" id="button_design" 
				<?php if($restaurant_type=="dq"): ?>
					class="btn btn-danger process_excel_dq"
				<?php elseif($restaurant_type=="ph"): ?>
					class="btn btn-danger process_excel_ph"
				<?php elseif($restaurant_type=="tb"): ?>	
					class="btn btn-danger process_excel_tb"
				<?php else: ?>	
					class="btn btn-danger process_excel_phb"
				<?php endif; ?>	><span class="glyphicon glyphicon-save"> </span> Save & Generate Excel </button></a>
	<!--<?php echo base_url('daily_forecasting/save_forecast?startdate=') . $startdate . '&end_date=' . $end_date; ?>-->
	</div>

	<?php echo $this->session->flashdata('msg');?>
	<?php echo ((isset($msg))? $msg : '');?>
	<br/>

	<div style="margin: 0 auto; width: 90%;margin-top: 10px;">

		<!-- Nav tabs -->
		<ul style="width:97%;font-size: 12px; font-weight: bold; margin-top:10px;margin-left:12px;" class="nav nav-tabs">
		<li><a href="<?php echo base_url('monthly_forecasting/first_month_forecast?start_month='.$monthstart.'&end_month='.$monthend.'&version='.$version); ?>">1st Month</a></li>
		<li><a href="<?php echo base_url('monthly_forecasting/second_month_forecast?start_month='.$monthstart.'&end_month='.$monthend.'&version='.$version); ?>">2nd Month</a></li>
		<li><a href="<?php echo base_url('monthly_forecasting/third_month_forecast?start_month='.$monthstart.'&end_month='.$monthend.'&version='.$version); ?>">3rd Month</a></li>
		<li class="active"><a href="<?php echo base_url('monthly_forecasting/summary_forecasted?start_month='.$monthstart.'&end_month='.$monthend.'&version='.$version); ?>">Forecast Summary</a></li>
		</ul>

		<!-- Tab panes -->
		<div style="width:90%;margin: 0 auto;">
		<br/>
			
		<div style="border:1px solid #eee; border-radius: 5px;box-shadow: 0px 0px 2px 1px #888888;margin-top:10px;">

			<table class="table table-condensed">
				<thead>
					<tr>
						<th style="text-align:center;font-size:12px;"> BRANCH </th>
						<th style="text-align:center;font-size:11px;"><?php echo $this->session->userdata('branch'); ?></th>
					</tr>
				</thead>
			</table>

		</div>
		<br/>

		<br/>

		<div style="margin-left: -170px;" id="form_content">

		<form method="get">
			
			<label> Item Name  </label>
			<input type="text" name="search" id="search" value="<?php echo $search;?>" placeholder=" Type here. " >
			<input type="submit" value="Search" id="button_design" class="btn btn-default">

			<input type="hidden" name="start_month" value="<?php echo $monthstart; ?>" />
			<input type="hidden" name="end_month" value="<?php echo $monthend; ?>" />
			<input type="hidden" name="version" value="<?php echo $version; ?>" />

		</form>

		</div>

		<div style="border:1px solid #eee; border-radius: 5px; box-shadow: 0px 0px 2px 1px #888888; margin-top: 5px;">

				<table class="table table-striped" class="tbl_pm">
					<thead>
						<tr style="font-weight: bold;">
							<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> Month </td>
							<td style="text-align:center;font-size:11px;">First Month</td>
							<td style="text-align:center;font-size:11px;">Second Month</td>
							<td style="text-align:center;font-size:11px;">Third Month</td>
						</tr>
						<tr style="font-weight: bold;">
							<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> FORECAST MONTHS </td>
							<td style="text-align:center;font-size:11px;"><?php echo $month1; ?></td>
							<td style="text-align:center;font-size:11px;"><?php echo $month2; ?></td>
							<td style="text-align:center;font-size:11px;"><?php echo $month3; ?></td>
						</tr>
						<tr style="font-weight: bold;">
							<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> FORECAST SALES </td>
							<td style="text-align:center;font-size:11px;"><?php echo round($gross1,0); ?></td>
							<td style="text-align:center;font-size:11px;"><?php echo round($gross2,0); ?></td>
							<td style="text-align:center;font-size:11px;"><?php echo round($gross3,0); ?></td>
						</tr>
						<tr style="font-size:11px;">
							<th style="text-align:center;border-right: solid 1px #eee;">MENU ITEMS</th>
							<th style="text-align:center;border-right: solid 1px #eee;">FINAL ORDER</th>
							<th style="text-align:center;border-right: solid 1px #eee;">FINAL ORDER</th>
							<th style="text-align:center;border-right: solid 1px #eee;">FINAL ORDER</th>
						</tr>
					</thead>
					<tbody>
					
					<?php foreach($sf as $row): ?>	
					
					<tr style="text-align:center;font-size:12px;font-family:Georgia;">
						<td style="text-align:left;font-size:11px;"> <?php echo nbs(3); ?> <?php echo $row['desc']; ?></td>
						<td>
							<?php 
							$split = str_split($row['firstmonth']);	
							if($split[0]=="-"):
							?>
							0
						<?php else: ?>	
							<?php if($row['firstmonth']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['firstmonth'],0); ?>
							<?php endif; ?>
						<?php endif; ?>
						</td>
						<td>
							<?php 
							$split = str_split($row['secondmonth']);	
							if($split[0]=="-"):
							?>
							0
						<?php else: ?>	
							<?php if($row['secondmonth']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['secondmonth'],0); ?>
							<?php endif; ?>
						<?php endif; ?>	
						</td>
						<td>
							<?php 
							$split = str_split($row['thirdmonth']);	
							if($split[0]=="-"):
							?>
							0
						<?php else: ?>	
							<?php if($row['thirdmonth']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['thirdmonth'],0); ?>
							<?php endif; ?>
						<?php endif; ?>
						</td>
					</tr>
					
					<?php endforeach; ?>	
					
					</tbody>
				</table>		

		</div>

		</div>

	</div>

</div>

<?php echo br(2); ?>