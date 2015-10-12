<?php $role_id = $this->session->userdata('role_id'); ?>
<?php $restaurant_type = $this->session->userdata('restaurant_type'); ?>

<h3 style="text-align:center;" id="page_title">Daily Forecasting</h3>
<hr/><br/>

<div id="new_btn_content">

	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
	<?php echo nbs(2); ?>
	<?php if($update_stats==0 || $date_today >= $_GET['end']): ?>
	<a href="<?php echo base_url('daily_forecasting/tuesday_forecast?start=') . $_GET['start'] . '&end=' . $_GET['end'] . '&version=' . $_GET['version']; ?>" style="font-family: Segoe UI Semibold;"><button type="button" id="button_design" class="btn btn-danger"><span class="glyphicon glyphicon-edit"> </span> Update Forecast </button></a>
	<?php endif; ?>

</div>

	<br/>
	<h4 style="margin-left: 100px;" id="page_title">Finished Forecast</h4>

	<div style="margin: 0 auto;">	

			<table class="t1" style="margin: 0 auto;width:850px;">
				
				<thead>
				
				<tr>
					<th></th>
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
						<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> FORECASTED DATE </td>
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
						<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> FORECASTED SALES </td>
						<td style="text-align:center;font-size:11px;"><?php echo $gross1; ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo $gross2; ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo $gross3; ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo $gross4; ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo $gross5; ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo $gross6; ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo $gross7; ?></td>
					</tr>

					<tr style="font-size:11px;">
						<th style="text-align:center;">MENU ITEMS</th>
						<th style="text-align:center;">Final Order</th>
						<th style="text-align:center;">Final Order</th>
						<th style="text-align:center;">Final Order</th>
						<th style="text-align:center;">Final Order</th>
						<th style="text-align:center;">Final Order</th>
						<th style="text-align:center;">Final Order</th>
						<th style="text-align:center;">Final Order</th>
					</tr>

				<?php foreach($result as $row): ?>	
				
				<tr style="text-align:center;font-size:12px;font-family:Georgia;">
					<td style="text-align:left;font-size:11px;"> <?php echo nbs(3); ?> <?php echo $row['fg']; ?></td>
					<td style="text-align:center;">
						<?php 
							$split = str_split($row['dayone']);	
							if($split[0]=="-"):
						?>
							0
						<?php else: ?>	
							<?php if($row['dayone']==""): ?>
								0
							<?php else: ?>
								<?php echo (ceil($row['dayone'])); ?>
							<?php endif; ?>
						<?php endif; ?>		
					</td>
					<td style="text-align:center;">
						<?php 
							$split = str_split($row['daytwo']);	
							if($split[0]=="-"):
						?>
							0
						<?php else: ?>
							<?php if($row['daytwo']==""): ?>
								0
							<?php else: ?>
								<?php echo (ceil($row['daytwo'])); ?>
							<?php endif; ?>
						<?php endif; ?>		
					</td>
					<td style="text-align:center;">
						<?php 
							$split = str_split($row['daythree']);	
							if($split[0]=="-"):
						?>
							0
						<?php else: ?>
							<?php if($row['daythree']==""): ?>
								0
							<?php else: ?>
								<?php echo (ceil($row['daythree'])); ?>
							<?php endif; ?>
						<?php endif; ?>		
					</td>
					<td style="text-align:center;">
						<?php 
							$split = str_split($row['dayfour']);	
							if($split[0]=="-"):
						?>
							0
						<?php else: ?>
							<?php if($row['dayfour']==""): ?>
								0
							<?php else: ?>
								<?php echo (ceil($row['dayfour'])); ?>
							<?php endif; ?>	
						<?php endif; ?>	
					</td>
					<td style="text-align:center;">
						<?php 
							$split = str_split($row['dayfive']);	
							if($split[0]=="-"):
						?>
							0
						<?php else: ?>
							<?php if($row['dayfive']==""): ?>
								0
							<?php else: ?>
								<?php echo (ceil($row['dayfive'])); ?>
							<?php endif; ?>	
						<?php endif; ?>	
					</td>
					<td style="text-align:center;">
						<?php 
							$split = str_split($row['daysix']);	
							if($split[0]=="-"):
						?>
							0
						<?php else: ?>
							<?php if($row['daysix']==""): ?>
								0
							<?php else: ?>
								<?php echo (ceil($row['daysix'])); ?>
							<?php endif; ?>
						<?php endif; ?>		
					</td>
					<td style="text-align:center;">
						<?php 
							$split = str_split($row['dayseven']);	
							if($split[0]=="-"):
						?>
							0
						<?php else: ?>
							<?php if($row['dayseven']==""): ?>
								0
							<?php else: ?>
								<?php echo (ceil($row['dayseven'])); ?>
							<?php endif; ?>	
						<?php endif; ?>	
					</td>
				</tr>
				
				<?php endforeach; ?>	
				
				</tbody>
			</table>		

		</div>

<?php echo br(2); ?>