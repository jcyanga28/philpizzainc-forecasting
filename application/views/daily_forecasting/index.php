<?php $role_id = $this->session->userdata('role_id'); ?>
<?php $restaurant_type = $this->session->userdata('restaurant_type'); ?>
<?php
$startdate = $this->input->get('startdate');
$end_date = $this->input->get('end_date');
?>
<h3 style="text-align:center;" id="page_title">Daily Forecasting</h3>
<hr/><br/>

<div id="new_btn_content">

	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
	<?php echo nbs(2); ?>
	<a href="<?php echo base_url('daily_forecasting/save_forecast?startdate=') . $startdate . '&end_date=' . $end_date; ?>" style="font-family: Segoe UI Semibold;"><button type="button" id="button_design" class="btn btn-danger"><span class="glyphicon glyphicon-download"> </span> Save & Generate Excel </button></a>

</div>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>
<br/>

<div style="margin: 0 auto; width: 75%;margin-top: 10px;">

	<!-- Nav tabs -->
	<ul style="width:97%;font-size: 12px; font-weight: bold; margin-top:10px;margin-left:12px;" class="nav nav-tabs">
	<li class="active"><a href="<?php echo base_url('daily_forecasting/tuesday?startdate='.$startdate.'&end_date='.$end_date); ?>">Tuesday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/wednesday?startdate='.$startdate.'&end_date='.$end_date); ?>">Wednesday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/thursday?startdate='.$startdate.'&end_date='.$end_date); ?>">Thursday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/friday?startdate='.$startdate.'&end_date='.$end_date); ?>">Friday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/saturday?startdate='.$startdate.'&end_date='.$end_date); ?>">Saturday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/sunday?startdate='.$startdate.'&end_date='.$end_date); ?>">Sunday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/monday?startdate='.$startdate.'&end_date='.$end_date); ?>">Monday</a></li>
	<?php if($role_id == 1): ?>
	<li><a href="#product_mixed" data-toggle="tab">Product Mixed</a></li>
	<?php endif; ?> 		
	</ul>

	<!-- Tab panes -->
	<div style="width:90%;margin: 0 auto;">
		<br/>

		<div>
		<span style="float: left;font-size:12px;"><b><?php echo $this->session->userdata('branch'); ?></b> | <b>
				<?php if($restaurant_type=="ph"): ?>
				  Pizza Hut
				<?php elseif($restaurant_type=="dq"): ?>
				  Dairy Queen
				<?php else: ?>
				  Taco Bell
				<?php endif; ?>    
			</b> - <b><?php echo $firstday_display; ?></b> | <b><?php echo $firstdate_display; ?></b></span>
		</div>
		<br/>

		<div style="float:right;margin-top: 10px;">
			<?php echo $links; ?>
		</div>

		<div style="border:1px solid #eee; border-radius: 5px; box-shadow: 0px 0px 2px 1px #888888; margin-top: 35px;">

			<input type="hidden" name="dayone_date" id="dayone_date" value="<?php echo $firstdate_display; ?>" />	
			<table class="table table-hover" class="tbl_tuesday">
			<thead>
			<tr style="font-size:12px;">
			<th style="text-align:center;">FORECASTING AMOUNT</th>
			<th ><input type="text" id="forecast_amount_design" class="dayone_forecasted_amount" value="<?php echo $forecasted_amount->forecast_amount; ?>" placeholder="Type here."></th>
			<th ></th>
			<th ></th>
			</tr>
			<tr style="font-size:11px;">
			<th style="text-align:center;">FG</th>
			<th style="text-align:center;">NEED</th>
			<th style="text-align:center;">ADJUSTMENT</th>
			<th style="text-align:center;">FINAL ORDER</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach($tuesday as $row): ?>	
			<tr style="text-align:center;font-size:12px;font-family:Georgia;">
			<td style="text-align:left;"><?php echo nbs(4); ?><?php echo $row['fg']; ?></td>
			<td>
				<?php if($row['need']=="" || $row['need']=="0"): ?>
					-
				<?php else: ?>
					<?php echo round($row['need'],0); ?>
				<?php endif; ?>
					
			</td>
			<td><input type="text" name="<?php echo $row['id']; ?>" class="adjustment" id="<?php echo $row['id']; ?>" value="<?php echo $row['adjustment']; ?>" style="width:85%;height:25px;border-radius:3px;border:solid 1px #eee;text-align:center;" placeholder="Type here." ></td>
			<td>
				<?php if($row['final_order']=="" || $row['final_order']=="0"): ?>
					-
				<?php else: ?>
					<?php echo round($row['final_order'],0); ?>
				<?php endif; ?>
					
			</td>
			</tr>
			<?php endforeach; ?>	
			</tbody>
			</table>		

		</div>

	</div>

</div>

<script type="text/javascript">
var domain ="http://"+document.domain;

$(document).ready(function(){

$('.dayone_forecasted_amount').each(function(){
$(this).change(function(){

$.ajax({
type: "POST",
url:  domain+'/daily_forecasting/update1',
data:  {forecasted_amount: $(this).val(), dayone_date: $('#dayone_date').val()},
dataType: "json",
success: function(content) {
	
	if (content.status=="success"){
		location.reload();	
	}
		
}
});
return false;

});
});

$('.adjustment').each(function(){
$(this).change(function(){


$.ajax({
type: "POST",
url:  domain+'/daily_forecasting/update_adjfo1',
data:  {id: $(this).attr('id'), adjustment: $(this).val()},
dataType: "json",
success: function(content) {
	
	if (content.status=="success"){
		location.reload();
	}
}
});
return false;

});
});

});
</script>
<?php echo br(2); ?>