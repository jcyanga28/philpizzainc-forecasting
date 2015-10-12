
<?php $role_id = $this->session->userdata('role_id'); ?>
<?php $restaurant_type = $this->session->userdata('restaurant_type'); ?>
<?php

$type = $this->input->get('type');

$monthstart = $this->input->get('monthstart');
$monthend = $this->input->get('monthend');

$ref_monthstart = $this->input->get('ref_monthstart');
$ref_month_end = $this->input->get('ref_month_end');

?>

<h3 style="text-align:center;" id="page_title">Monthly Forecasting</h3>
<hr/><br/>

<div id="new_btn_content">

	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
	<?php echo nbs(2); ?>
	<a href="<?php echo base_url('monthly_forecasting/print_product_mixed?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>" style="font-family: Segoe UI Semibold;"><button type="button" id="button_design" class="btn btn-danger" ><span class="glyphicon glyphicon-save"> </span> Generate Excel </button></a>

</div>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>
<br/>

<div style="margin: 0 auto; width: 90%;margin-top: 10px;">

	<!-- Nav tabs -->
	<ul style="font-size: 12px; font-weight: bold; margin-top:10px;margin-left:12px;" class="nav nav-tabs">
	<li><a href="<?php echo base_url('monthly_forecasting/first_month?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>">1st Month</a></li>
	<li><a href="<?php echo base_url('monthly_forecasting/second_month?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>">2nd Month</a></li>
	<li><a href="<?php echo base_url('monthly_forecasting/third_month?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>">3rd Month</a></li>
	<li><a href="<?php echo base_url('monthly_forecasting/summary_forecast?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>">Summary Forecast</a></li>
	<?php if($role_id == 2): ?>
	<li class="active"><a href="<?php echo base_url('monthly_forecasting/product_mixed?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>">Reference - Product Mix</a></li>
	<?php endif; ?> 		
	</ul>

	<!-- Tab panes -->
	<div style="width:75%;margin: 0 auto;">
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
			</thead>
		</table>

	</div>
	<br/><br/>
	
	<div style="margin-left: -310px;" id="form_content">

	<form method="get">
		
		<label> Item Name  </label>
		<input type="text" name="search" id="search" value="<?php echo $search;?>" placeholder=" Type here. " >
		<input type="submit" value="Search" id="button_design" class="btn btn-default">

		<input type="hidden" name="monthstart" value="<?php echo $monthstart; ?>" />
		<input type="hidden" name="monthend" value="<?php echo $monthend; ?>" />
		<input type="hidden" name="ref_monthstart" value="<?php echo $ref_monthstart; ?>" />
		<input type="hidden" name="ref_monthend" value="<?php echo $ref_monthend; ?>" />
		<input type="hidden" name="type" value="<?php echo $type; ?>" />

	</form>

	</div>

	<div style="border:1px solid #eee; border-radius: 5px; box-shadow: 0px 0px 2px 1px #888888; margin-top: 5px;">

			<table class="table table-striped" class="tbl_pm">
				<thead>
					<tr style="font-weight: bold;">
						<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> REFERENCE MONTHS </td>
						<td style="text-align:center;font-size:11px;"><?php echo $smonths_r; ?></td>
					</tr>
					<tr style="font-weight: bold;">
						<td style="text-align:center;font-size:12px;border-right: solid 1px #eee;"> ACTUAL SALES </td>
						<td style="text-align:center;font-size:11px;"><?php echo ceil($gross1); ?></td>
					</tr>
					<tr style="font-size:11px;">
						<th style="text-align:center;">MENU ITEMS</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				
				<?php foreach($pm as $row): ?>	
				
				<tr style="text-align:center;font-size:12px;font-family:Georgia;">
					<td style="text-align:left;font-size:11px;"> <?php echo nbs(3); ?> <?php echo $row['desc']; ?></td>
					<td>
						<?php if($row['fgsold']==""): ?>
							0
						<?php else: ?>
							<?php echo round($row['fgsold'],0); ?>
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