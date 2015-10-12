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
	<a href="<?php echo base_url('monthly_forecasting/save_pending?monthstart=') .$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type; ?>" style="font-family: Segoe UI Semibold;"><button type="button" id="button_design" class="btn btn-danger"><span class="glyphicon glyphicon-saved"> </span> Save Forecast </button></a>

</div>
<br/>

<div style="margin: 0 auto; width: 90%;margin-top: 10px;">

	<!-- Nav tabs -->
	<ul style="width:97%;font-size: 12px; font-weight: bold; margin-top:10px;margin-left:12px;" class="nav nav-tabs">
	<li><a href="<?php echo base_url('monthly_forecasting/first_month?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>">1st Month</a></li>
	<li><a href="<?php echo base_url('monthly_forecasting/second_month?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>">2nd Month</a></li>
	<li class="active"><a href="<?php echo base_url('monthly_forecasting/third_month?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>">3rd Month</a></li>
	<li><a href="<?php echo base_url('monthly_forecasting/summary_forecast?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>">Forecast Summary</a></li>
	<?php if($role_id == 2): ?>
	<li><a href="<?php echo base_url('monthly_forecasting/product_mixed?monthstart='.$monthstart.'&monthend='.$monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type); ?>">Reference - Product Mix</a></li>
	<?php endif; ?> 		
	</ul>

	<!-- Tab panes -->
	<div style="width:90%;margin: 0 auto;">
		<br/>

		<?php echo $this->session->flashdata('msg');?>
		<?php echo ((isset($msg))? $msg : '');?>

		<div>
		<span style="float: left;font-size:14px;"><b><?php echo $this->session->userdata('branch'); ?></b> | <b>
				<?php if($restaurant_type=="ph"): ?>
				  Pizza Hut
				<?php elseif($restaurant_type=="dq"): ?>
				  Dairy Queen
				<?php else: ?>
				  Taco Bell
				<?php endif; ?>    
			</b>
			</span>
		</div>
		<br/>
		
		<div style="float:right;">
			<?php echo $links; ?>
		</div>
		<br/>

		<form action="<?php echo base_url('monthly_forecasting/adjfo3?monthstart=') . $monthstart . '&monthend=' . $monthend.'&ref_monthstart='.$ref_monthstart.'&ref_month_end='.$ref_month_end.'&type='.$type; ?>" method="POST" id="mf_tmonth">
			
			<div style="border-radius: 5px; box-shadow: 0px 0px 2px 1px #888888; margin-top: 60px;">

				<input type="hidden" name="tmonth_from" id="tmonth_from" value="<?php echo $ttmonth_from; ?>" />
				<input type="hidden" name="tmonth_end" id="tmonth_end" value="<?php echo $ttmonth_end; ?>" />
				
				<table class="table table-hover" class="tbl_tmonth">
							
                <thead>
                    <tr style="font-size:11px;">
						<td></td>
						<td style="border-right:solid 2px #eee;border-left:solid 2px #eee;text-align:center;font-weight:bold">REFERENCE MONTH</td>
						<td style="border-right:solid 2px #eee;text-align:center;font-weight:bold">MONTH TO FORECAST</td>
						<td></td>
						<td></td>
				</tr>
				<tr>
						<td></td>
						<td style="border-right:solid 2px #eee;border-left:solid 2px #eee;text-align:center;"><b style="font-size: 11px;color:#666;">
							<?php 
								echo $ref_thirdmonth_display;
							 ?>
						</b></td>
						<td style="border-right:solid 2px #eee;text-align:center;"><b style="font-size: 11px;color:#666;">
							<?php 
								echo $forecast_thirdmonth_display;
							 ?>
						</b></td>
						<td></td>
						<td></td>
					</tr>
				<tr style="font-size:11px;">
						<td ></td>
						<td style="border-right:solid 2px #eee;border-left:solid 2px #eee;text-align:center;font-weight:bold;">ACTUAL SALES</td>
						<td style="border-right:solid 2px #eee;text-align:center;font-weight:bold;">FORECAST SALES</td>
						<td ></td>
						<td></td>
					</tr>
					<tr>
						<td style="border-right:solid 2px #eee;"></td>
						<td style="text-align:center;border-right:solid 2px #eee;"><b style="font-size: 12px;font-style:italic;color:green;font-family:Georgia;"><?php echo ceil($gross); ?></b></td>
						<td style="border-right:solid 2px #eee;font-size:12px;text-align:center;font-weight:bold;color:#666;"><input type="text" id="forecast_amount_design" class="tmonth_forecasted_amount" value="<?php echo $forecasted_amount->forecast_amount; ?>" placeholder="Type here."></td>
						<td ><input type="submit" class="btn btn-info" id="save_adjustment1" value="SAVE ADJUSTMENT" style="margin-left: 12px; width: 85%; font-size: 9px;" /></td>
						<td ></td>
				</tr>
		
				<tr style="font-size:11px;">
					<th style="text-align:center;border-right:solid 2px #eee;">MENU ITEMS</th>
					<th style="text-align:center;border-right:solid 2px #eee;">MENU ITEMS SOLD<span style="font-size:10px;">(QTY)</span></th>
					<th style="text-align:center;border-right:solid 2px #eee;">FORECAST<span style="font-size:10px;">(QTY)</span></th>
					<th style="text-align:center;border-right:solid 2px #eee;">ADJUSTMENT<span style="font-size:10px;">(QTY)</span></th>
					<th style="text-align:center;">FINAL ORDER<span style="font-size:10px;">(QTY)</span></th>
				</tr>
				
				</thead>

				<tbody>
				
				<?php foreach($tm as $row): ?>	
				<tr style="text-align:center;font-size:12px;font-family:Georgia;">
				<td style="text-align:left;border-right:solid 1px #eee;"><?php echo nbs(4); ?><?php echo $row['fg']; ?></td>
				<td style="border-right:solid 1px #eee;">
					<?php if($row['fgsold']=="" || $row['fgsold']=="0"): ?>
						-
					<?php else: ?>
						<?php echo round($row['fgsold'],0); ?>
					<?php endif; ?>
				</td>
				<td style="border-right:solid 1px #eee;">
					<?php if($row['need']=="" || $row['need']=="0"): ?>
						-
					<?php else: ?>
						<?php echo round($row['need'],0); ?>
					<?php endif; ?>
					<!-- name="<?php echo $row['id']; ?>		 -->
				</td>
				<td style="border-right:solid 1px #eee;"><input type="text" name="adjustment[]" id="<?php echo $row['id']; ?>" class="adjustment" value="<?php echo $row['adjustment']; ?>" style="width:85%;height:25px;border-radius:3px;border:solid 1px #eee;text-align:center;" placeholder="Type here." >
					<input type="hidden" name="adjustments[]" id="adjustments" class="<?php echo $row['id']; ?>" value="<?php echo $row['id'].'/'; ?>" style="width:85%;height:25px;border-radius:3px;border:solid 1px #eee;text-align:center;" placeholder="Type here." >
				</td>
				<td>
					<?php 
						$split = str_split($row['final_order']);	
						if($split[0]=="-"):
					?>
						-
					<?php else: ?>
						
						<?php if($row['final_order']=="" || $row['final_order']=="0"): ?>
							-
						<?php else: ?>
							<?php echo round($row['final_order'],0); ?>
						<?php endif; ?>

					<?php endif; ?>							
				</td>
				</tr>
				<?php endforeach; ?>
				
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td><input type="submit" class="btn btn-info" id="save_adjustment1" value="SAVE ADJUSTMENT" style="margin-left: 12px; width: 85%; font-size: 9px;" /></td>
					<td></td>
				</tr>	
				</tbody>
				</table>		

			</div>

			<input type="hidden" name="ref_month_start" id="ref_month_start" value="<?php echo $ref_month_from; ?>" />
			<input type="hidden" name="ref_month_to" id="ref_month_to" value="<?php echo $ref_end_month; ?>" />
			
		</form>

	</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
var domain ="http://"+document.domain;

$('.tmonth_forecasted_amount').each(function(){
$(this).change(function(){

if(!$.isNumeric($(this).val())) {
   alert('Only Numeric value was allow.');
   $('#mf_tmonth').find('.'+'tmonth_forecasted_amount').val('');
   return true;

}

$.ajax({
type: "POST",
url:  domain+'/monthly_forecasting/update3',
data:  {forecasted_amount: $(this).val(), date_from: $('#tmonth_from').val(), date_to: $('#tmonth_end').val(), ref_date_from: $('#ref_month_start').val(), ref_date_to: $('#ref_month_to').val()},
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

var id = $(this).attr('id');	
var value = $('.'+id).val();

if($('.tmonth_forecasted_amount').val()==""){
	alert("Fill-up Forecast sale first.");
	$('#mf_tmonth').find('#'+id).val('');
   	$('#mf_tmonth').find('.'+id).val('');
   	return true;

}

if(!$.isNumeric($(this).val())) {
   alert('Only Numeric value was allow.');
   $('#mf_tmonth').find('#'+id).val('');
   $('#mf_tmonth').find('.'+id).val('');
   return true;

}else{

	if(value==""){
   		$('#mf_tmonth').find('.'+id).val(id+'/'+$(this).val());
    
    }else{
    	$('#mf_tmonth').find('.'+id).val('');
    	$('#mf_tmonth').find('.'+id).val(id+'/'+$(this).val());

    }
    	
    // return false;

}

});
});


});
</script>
<?php echo br(2); ?>