<?php $role_id = $this->session->userdata('role_id'); ?>
<?php $restaurant_type = $this->session->userdata('restaurant_type'); ?>

<h3 style="text-align:center;" id="page_title">Monthly Forecasting</h3>
<hr/><br/>

<div id="new_btn_content">

	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
	<?php echo nbs(2); ?>
	<?php if($update_stats==0 || $date_today >= $date_endm): ?>
	<a href="<?php echo base_url('monthly_forecasting/first_month_forecast?start_month=') . $_GET['start_month'] . '&end_month=' . $_GET['end_month'] . '&version=' . $_GET['version']; ?>" style="font-family: Segoe UI Semibold;"><button type="button" id="button_design" class="btn btn-danger"><span class="glyphicon glyphicon-edit"> </span> Update Forecast </button></a>
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
				</tr>
				
				</thead>

				<tbody>
					
					<tr style="font-weight: bold;">
						<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> DAY </td>
						<td style="text-align:center;font-size:11px;">First Month</td>
						<td style="text-align:center;font-size:11px;">Second Month</td>
						<td style="text-align:center;font-size:11px;">Third Month</td>
					</tr>
					<tr style="font-weight: bold;">
						<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> FORECASTED MONTHS </td>
						<td style="text-align:center;font-size:11px;"><?php echo $fmonths_from . ' ' . 'To' . ' ' . $fmonths_end; ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo $smonths_from . ' ' . 'To' . ' ' . $smonths_end; ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo $tmonths_from . ' ' . 'To' . ' ' . $tmonths_end; ?></td>
					</tr>
					<tr style="font-weight: bold;">
						<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> FORECASTED SALES </td>
						<td style="text-align:center;font-size:11px;"><?php echo round($gross1,0); ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo round($gross2,0); ?></td>
						<td style="text-align:center;font-size:11px;"><?php echo round($gross3,0); ?></td>
					</tr>
		
					<tr style="font-size:11px;">
						<th style="text-align:center;">MENU ITEMS</th>
						<th style="text-align:center;">Final Order</th>
						<th style="text-align:center;">Final Order</th>
						<th style="text-align:center;">Final Order</th>
					</tr>

				<?php foreach($result as $row): ?>	
				
				<tr style="text-align:center;font-size:12px;font-family:Georgia;">
					<td style="text-align:left;font-size:11px;"> <?php echo nbs(3); ?> <?php echo $row['fg']; ?></td>
					<td style="text-align:center;">
						<?php 
							$split = str_split($row['ffo']);	
							if($split[0]=="-"):
						?>
							0
						<?php else: ?>	
							<?php if($row['ffo']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['ffo'],0); ?>
							<?php endif; ?>
						<?php endif; ?>		
					</td>
					<td style="text-align:center;">
						<?php 
							$split = str_split($row['sfo']);	
							if($split[0]=="-"):
						?>
							0
						<?php else: ?>
							<?php if($row['sfo']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['sfo'],0); ?>
							<?php endif; ?>
						<?php endif; ?>		
					</td>
					<td style="text-align:center;">
						<?php 
							$split = str_split($row['tfo']);	
							if($split[0]=="-"):
						?>
							0
						<?php else: ?>
							<?php if($row['tfo']==""): ?>
								0
							<?php else: ?>
								<?php echo round($row['tfo'],0); ?>
							<?php endif; ?>
						<?php endif; ?>		
					</td>
				</tr>
				
				<?php endforeach; ?>		
				
				</tbody>
			</table>		

		</div>

<?php echo br(2); ?>