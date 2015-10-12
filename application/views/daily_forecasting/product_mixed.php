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
	<a href="<?php echo base_url('daily_forecasting/print_product_mixed?startdate=') . $startdate . '&end_date=' . $end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type; ?>" style="font-family: Segoe UI Semibold;"><button type="button" id="button_design" class="btn btn-danger" ><span class="glyphicon glyphicon-save"> </span> Generate Excel </button></a>

</div>
<br/>

<div style="margin: 0 auto; width: 92%;margin-top: 10px;">

	<!-- Nav tabs -->
	<ul style="width:97%;font-size: 11px; font-weight: bold; margin-top:10px;margin-left:12px;" class="nav nav-tabs">
	<li><a href="<?php echo base_url('daily_forecasting/tuesday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Tuesday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/wednesday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Wednesday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/thursday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Thursday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/friday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Friday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/saturday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Saturday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/sunday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Sunday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/monday?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Monday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/summary_forecast?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Forecast Summary</a></li>
	<?php if($role_id == 2): ?>
	<li class="active"><a href="<?php echo base_url('daily_forecasting/product_mixed?startdate='.$startdate.'&end_date='.$end_date .'&ref_startdate='.$ref_startdate.'&ref_end_date='.$ref_end_date. '&type=' . $type); ?>">Reference - Product Mix</a></li>
	<?php endif; ?> 		
	</ul>

	<!-- Tab panes -->
	<div style="width:99%;margin: 0 auto;">
	<br/>

	<div style="margin-left: 5px;">

		<b style="font-size: 16px;">Usage Template</b>

	</div>

	<br/>

	<div style="border:1px solid #eee; border-radius: 5px;box-shadow: 0px 0px 2px 1px #888888;margin-top:10px;">

		<table class="table table-condensed">
			<thead>
				<tr>
					<th style="text-align:center;font-size:12px;"> BRANCH </th>
					<th style="text-align:center;font-size:11px;"><?php echo $this->session->userdata('branch'); ?></th>
				</tr>
				<tr>
					<th style="text-align:center;font-size:12px;"> FORECAST RANGE DATE (Tuesday to Monday) </th>
					<th style="text-align:center;font-size:11px;">
							<?php 
								$split_tues0 = explode("-",$tues_date);
								$split_mon0 = explode("-",$mon_date);
								echo $split_tues0[1] . '/' . $split_tues0[2] . '/' . $split_tues0[0] . ' ' . 'To' . ' ' . $split_mon0[1] . '/' . $split_mon0[2] . '/' . $split_mon0[0];
							 ?>
					</th>
				</tr>
			</thead>
		</table>

	</div>

	<br/>

	<div style="margin-left: -65px;" id="form_content">

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
						<td style="text-align:center;font-size:11px;">Tuesday</td>
						<td style="text-align:center;font-size:11px;">Wednesday</td>
						<td style="text-align:center;font-size:11px;">Thursday</td>
						<td style="text-align:center;font-size:11px;">Friday</td>
						<td style="text-align:center;font-size:11px;">Saturday</td>
						<td style="text-align:center;font-size:11px;">Sunday</td>
						<td style="text-align:center;font-size:11px;">Monday</td>
					</tr>
					<tr style="font-weight: bold;">
						<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> REFERENCE DATE </td>
						<td style="text-align:center;font-size:11px;">
							<?php 
								$split_tues = explode("-",$tues_date);
								echo $split_tues[1] . '/' . $split_tues[2] . '/' . $split_tues[0];
							 ?>
						</td>
						<td style="text-align:center;font-size:11px;">
							<?php 
								$split_wed = explode("-",$wed_date);
								echo $split_wed[1] . '/' . $split_wed[2] . '/' . $split_wed[0];
							 ?>
						</td>
						<td style="text-align:center;font-size:11px;">
							<?php 
								$split_thurs = explode("-",$thurs_date);
								echo $split_thurs[1] . '/' . $split_thurs[2] . '/' . $split_thurs[0];
							 ?>
						</td>
						<td style="text-align:center;font-size:11px;">
							<?php 
								$split_fri = explode("-",$fri_date);
								echo $split_fri[1] . '/' . $split_fri[2] . '/' . $split_fri[0];
							 ?>
						</td>
						<td style="text-align:center;font-size:11px;">
							<?php 
								$split_sat = explode("-",$sat_date);
								echo $split_sat[1] . '/' . $split_sat[2] . '/' . $split_sat[0];
							 ?>
						</td>
						<td style="text-align:center;font-size:11px;">
							<?php 
								$split_sun = explode("-",$sun_date);
								echo $split_sun[1] . '/' . $split_sun[2] . '/' . $split_sun[0];
							 ?>
						</td>
						<td style="text-align:center;font-size:11px;">
							<?php 
								$split_mon = explode("-",$mon_date);
								echo $split_mon[1] . '/' . $split_mon[2] . '/' . $split_mon[0];
							 ?>
						</td>
					</tr>
					<tr style="font-weight: bold;">
						<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> ACTUAL SALES </td>
						<td style="text-align:center;font-size:11px;"><?php echo round($gross1,0); ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo round($gross2,0); ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo round($gross3,0); ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo round($gross4,0); ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo round($gross5,0); ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo round($gross6,0); ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo round($gross7,0); ?></td>
					</tr>
					<tr style="font-size:11px;">
						<th style="text-align:center;">MENU ITEMS</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				
				<?php foreach($pm as $row): ?>	
				
				<tr style="text-align:center;font-size:12px;font-family:Georgia;">
					<td style="text-align:left;font-size:11px;"> <?php echo nbs(3); ?> <?php echo $row['desc']; ?></td>
					<td>
						<?php if($row['one']==""): ?>
							0
						<?php else: ?>
							<?php echo round($row['one'],0); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($row['two']==""): ?>
							0
						<?php else: ?>
							<?php echo round($row['two'],0); ?>
						<?php endif; ?>	
					</td>
					<td>
						<?php if($row['three']==""): ?>
							0
						<?php else: ?>
							<?php echo round($row['three'],0); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($row['four']==""): ?>
							0
						<?php else: ?>
							<?php echo round($row['four'],0); ?>
						<?php endif; ?>	
					</td>
					<td>
						<?php if($row['five']==""): ?>
							0
						<?php else: ?>
							<?php echo round($row['five'],0); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($row['six']==""): ?>
							0
						<?php else: ?>
							<?php echo round($row['six'],0); ?>
						<?php endif; ?>	
					</td>
					<td>
						<?php if($row['seven']==""): ?>
							0
						<?php else: ?>
							<?php echo round($row['seven'],0); ?>
						<?php endif; ?>	
					</td>
				</tr>
				
				<?php endforeach; ?>	
				
				</tbody>
			</table>		

	</div>

	</div>

</div>

<?php echo br(2); ?>