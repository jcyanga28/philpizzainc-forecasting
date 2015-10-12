<script type="text/javascript">
var domain ="http://"+document.domain;
$(document).ready(function(){

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

    <div style="width: 95%; color: #333;">

        <div style="margin-left: 30px;">

            <h2><span style="margin-top: 5px;" class="glyphicon glyphicon-info-sign"></span> Daily Forecasting</h2>
            <hr/>
            <p style="font-size: 16px;" class="lead"> <?php echo nbs(3); ?> - Your Daily Forecast was saving, Don't leave the page.</p>
            <p style="font-size: 16px;" class="lead"> <?php echo nbs(3); ?> - Make sure excel file was downloaded before leave the page.</p>
            <p style="font-size: 16px;" class="lead"> <?php echo nbs(3); ?> - Please be patient...</p>
            <hr/>

            <?php
            $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
            $pageURL .= $_SERVER["SERVER_NAME"];
            ?>

            <?php echo nbs(5); ?><a href="<?php  echo base_url('daily_forecasting');?>">
            <button type="button" class="btn btn-default" style="font-size: 12px;font-weight:bold;"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;<b>Back to Daily Forecasting Date-range</b></button> 
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
	
	$type = $this->input->get('type');

	$startdate = $this->input->get('startdate');
	$end_date = $this->input->get('end_date');

	$ref_startdate = $this->input->get('ref_startdate');
	$ref_end_date = $this->input->get('ref_end_date');

?>

	<h3 style="text-align:center;" id="page_title">Daily Forecasting</h3>
	<hr/><br/>

	<div id="new_btn_content">

		<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
		<?php echo nbs(2); ?>
		<a href="<?php echo base_url('daily_forecasting/save_forecast?startdate=') . $startdate . '&end_date=' . $end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type; ?>" style="font-family: Segoe UI Semibold;"><button type="button" id="button_design" 
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
	<br/>

	<div style="margin: 0 auto; width: 95%;margin-top: 10px;">

		<!-- Nav tabs -->
		<ul style="width:97%;font-size: 12px; font-weight: bold; margin-top:10px;margin-left:12px;" class="nav nav-tabs">
		<li><a href="<?php echo base_url('daily_forecasting/tuesday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Tuesday</a></li>
		<li><a href="<?php echo base_url('daily_forecasting/wednesday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Wednesday</a></li>
		<li><a href="<?php echo base_url('daily_forecasting/thursday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Thursday</a></li>
		<li><a href="<?php echo base_url('daily_forecasting/friday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Friday</a></li>
		<li><a href="<?php echo base_url('daily_forecasting/saturday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Saturday</a></li>
		<li><a href="<?php echo base_url('daily_forecasting/sunday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Sunday</a></li>
		<li><a href="<?php echo base_url('daily_forecasting/monday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Monday</a></li>
		<li class="active"><a href="<?php echo base_url('daily_forecasting/summary_forecast?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Forecast Summary</a></li>
		<?php if($role_id == 2): ?>
		<li><a href="<?php echo base_url('daily_forecasting/product_mixed?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Reference - Product Mix</a></li>
		<?php endif; ?> 		
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
					<tr>
						<th style="text-align:center;font-size:12px;"> FORECASTED RANGE DATE (Tuesday to Monday) </th>
						<th style="text-align:center;font-size:11px;">
								<?php 
									$split_tues0 = explode("-",$f_tues_date);
									$split_mon0 = explode("-",$f_mon_date);
									echo $split_tues0[1] . '/' . $split_tues0[2] . '/' . $split_tues0[0] . ' ' . 'To' . ' ' . $split_mon0[1] . '/' . $split_mon0[2] . '/' . $split_mon0[0];
								 ?>
						</th>
					</tr>
				</thead>
			</table>

		</div>

		<br/>

		<div style="margin-left: -125px;" id="form_content">

		<form method="get">
			
			<label> Item Name  </label>
			<input type="text" name="search" id="search" value="<?php echo $search;?>" placeholder=" Type here. " >
			<input type="submit" value="Search" id="button_design" class="btn btn-default">

			<input type="hidden" name="startdate" value="<?php echo $startdate; ?>" />
			<input type="hidden" name="end_date" value="<?php echo $end_date; ?>" />
			<input type="hidden" name="ref_startdate" value="<?php echo $ref_startdate; ?>" />
			<input type="hidden" name="ref_end_date" value="<?php echo $ref_end_date; ?>" />
			<input type="hidden" name="type" value="<?php echo $type; ?>" />

		</form>

		</div>

		<div style="border:1px solid #eee; border-radius: 5px; box-shadow: 0px 0px 2px 1px #888888; margin-top: 10px;">

				<table class="table table-striped" class="tbl_pm">
					<thead>
						<tr style="font-weight: bold;">
							<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> DAY </td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">Tuesday</td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">Wednesday</td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">Thursday</td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">Friday</td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">Saturday</td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">Sunday</td>
							<td style="text-align:center;font-size:11px;">Monday</td>
						</tr>
						<tr style="font-weight: bold;">
							<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> FORECASTED DATE </td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">
								<?php 
									$split_tues = explode("-",$f_tues_date);
									echo $split_tues[1] . '/' . $split_tues[2] . '/' . $split_tues[0];
								 ?>
							</td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">
								<?php 
									$split_wed = explode("-",$f_wed_date);
									echo $split_wed[1] . '/' . $split_wed[2] . '/' . $split_wed[0];
								 ?>
							</td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">
								<?php 
									$split_thurs = explode("-",$f_thurs_date);
									echo $split_thurs[1] . '/' . $split_thurs[2] . '/' . $split_thurs[0];
								 ?>
							</td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">
								<?php 
									$split_fri = explode("-",$f_fri_date);
									echo $split_fri[1] . '/' . $split_fri[2] . '/' . $split_fri[0];
								 ?>
							</td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">
								<?php 
									$split_sat = explode("-",$f_sat_date);
									echo $split_sat[1] . '/' . $split_sat[2] . '/' . $split_sat[0];
								 ?>
							</td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;">
								<?php 
									$split_sun = explode("-",$f_sun_date);
									echo $split_sun[1] . '/' . $split_sun[2] . '/' . $split_sun[0];
								 ?>
							</td>
							<td style="text-align:center;font-size:11px;">
								<?php 
									$split_mon = explode("-",$f_mon_date);
									echo $split_mon[1] . '/' . $split_mon[2] . '/' . $split_mon[0];
								 ?>
							</td>
						</tr>
						<tr style="font-weight: bold;">
							<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> FORECAST SALES </td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;"><?php echo round($gross1,0); ?></td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;"><?php echo round($gross2,0); ?></td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;"><?php echo round($gross3,0); ?></td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;"><?php echo round($gross4,0); ?></td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;"><?php echo round($gross5,0); ?></td>
							<td style="text-align:center;font-size:11px;border-right: solid 1px #eee;"><?php echo round($gross6,0); ?></td>
							<td style="text-align:center;font-size:11px;"><?php echo round($gross7,0); ?></td>
						</tr>
						<tr style="font-size:11px;">
							<th style="text-align:center;border-right: solid 1px #eee;">MENU ITEMS</th>
							<th style="text-align:center;border-right: solid 1px #eee;">FINAL ORDER</th>
							<th style="text-align:center;border-right: solid 1px #eee;">FINAL ORDER</th>
							<th style="text-align:center;border-right: solid 1px #eee;">FINAL ORDER</th>
							<th style="text-align:center;border-right: solid 1px #eee;">FINAL ORDER</th>
							<th style="text-align:center;border-right: solid 1px #eee;">FINAL ORDER</th>
							<th style="text-align:center;border-right: solid 1px #eee;">FINAL ORDER</th>
							<th style="text-align:center;">FINAL ORDER</th>
						</tr>
					</thead>
					<tbody>
					
					<?php foreach($pm as $row): ?>	
					
					<tr style="text-align:center;font-size:12px;font-family:Georgia;">
						<td style="text-align:left;font-size:11px;border-right: solid 1px #eee;"> <?php echo nbs(3); ?> <?php echo $row['desc']; ?></td>
						<td style="border-right: solid 1px #eee;">
						<?php 
						$split = str_split($row['one']);	
						if($split[0]=="-"):
						?>
							0
						<?php else: ?>	
							<?php if($row['one']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['one'],0); ?>
							<?php endif; ?>
						<?php endif; ?>
						</td>
						<td style="border-right: solid 1px #eee;">
							<?php 
						$split = str_split($row['two']);	
						if($split[0]=="-"):
						?>
							0
						<?php else: ?>	
							<?php if($row['two']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['two'],0); ?>
							<?php endif; ?>
						<?php endif; ?>	
						</td>
						<td style="border-right: solid 1px #eee;">
							<?php 
						$split = str_split($row['three']);	
						if($split[0]=="-"):
						?>
							0
						<?php else: ?>	
							<?php if($row['three']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['three'],0); ?>
							<?php endif; ?>
						<?php endif; ?>
						<td style="border-right: solid 1px #eee;">
							<?php 
						$split = str_split($row['four']);	
						if($split[0]=="-"):
						?>
							0
						<?php else: ?>	
							<?php if($row['four']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['four'],0); ?>
							<?php endif; ?>
						<?php endif; ?>	
						</td>
						<td style="border-right: solid 1px #eee;">
							<?php 
						$split = str_split($row['five']);	
						if($split[0]=="-"):
						?>
							0
						<?php else: ?>	
							<?php if($row['five']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['five'],0); ?>
							<?php endif; ?>
						<?php endif; ?>
						</td>
						<td style="border-right: solid 1px #eee;">
							<?php 
						$split = str_split($row['six']);	
						if($split[0]=="-"):
						?>
							0
						<?php else: ?>	
							<?php if($row['six']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['six'],0); ?>
							<?php endif; ?>
						<?php endif; ?>	
						</td>
						<td>
							<?php 
						$split = str_split($row['seven']);	
						if($split[0]=="-"):
						?>
							0
						<?php else: ?>	
							<?php if($row['seven']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['seven'],0); ?>
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