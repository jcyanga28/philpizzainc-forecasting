<?php $role_id = $this->session->userdata('role_id'); ?>
<?php $restaurant_type = $this->session->userdata('restaurant_type'); ?>
<?php
$startdate = $this->input->get('start');
$end_date = $this->input->get('end');

$version = $this->input->get('version');

?>
<h3 style="text-align:center;" id="page_title">Update Daily Forecasting</h3>
<hr/><br/>

<div id="new_btn_content">

	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>

</div>
<br/>

<div style="margin: 0 auto; width: 90%;margin-top: 10px;">

	<!-- Nav tabs -->
	<ul style="width:97%;font-size: 12px; font-weight: bold; margin-top:10px;margin-left:12px;" class="nav nav-tabs">
	<li><a href="<?php echo base_url('daily_forecasting/tuesday_forecast?start='.$startdate.'&end='.$end_date.'&version='.$version); ?>">Tuesday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/wednesday_forecast?start='.$startdate.'&end='.$end_date.'&version='.$version); ?>">Wednesday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/thursday_forecast?start='.$startdate.'&end='.$end_date.'&version='.$version); ?>">Thursday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/friday_forecast?start='.$startdate.'&end='.$end_date.'&version='.$version); ?>">Friday</a></li>
	<li class="active"><a href="<?php echo base_url('daily_forecasting/saturday_forecast?start='.$startdate.'&end='.$end_date.'&version='.$version); ?>">Saturday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/sunday_forecast?start='.$startdate.'&end='.$end_date.'&version='.$version); ?>">Sunday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/monday_forecast?start='.$startdate.'&end='.$end_date.'&version='.$version); ?>">Monday</a></li>
	<li><a href="<?php echo base_url('daily_forecasting/summary_forecasted?start='.$startdate.'&end='.$end_date.'&version='.$version); ?>">Forecast Summary</a></li>
	<!--<?php if($role_id == 2): ?>
	<li><a href="<?php echo base_url('daily_forecasting/product_mixed_forecast?start='.$startdate.'&end='.$end_date.'&version='.$version); ?>">Product Mixed</a></li>
	<?php endif; ?>-->		
	</ul>

	<!-- Tab panes -->
	<div style="width:95%;margin: 0 auto;">
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
			</b> | <b><?php echo $fifthday_display; ?></b>
			</span>
		</div>
		<br/>

		<div style="float:right;">
			<?php echo $links; ?>
		</div>

		<form action="<?php echo base_url('daily_forecasting/u_adjfo5?startdate=') . $startdate . '&end_date=' . $end_date . '&version=' . $version; ?>" method="POST" id="df_saturday">	
			
			<div style="border-radius: 5px; box-shadow: 0px 0px 2px 1px #888888; margin-top: 60px;">

				<input type="hidden" name="dayfive_date" id="dayfive_date" value="<?php echo $fifthdate_display; ?>" />	

				<table class="table table-hover" class="tbl_saturday">
							
                <thead>
                    <tr style="font-size:11px;">
						<td></td>
						<td></td>
						<td style="border-right:solid 2px #eee;text-align:center;font-weight:bold">DATE TO FORECAST</td>
						<td></td>
						<td></td>
				</tr>
					<tr>
						<td></td>
						<td></td>
						<td style="border-right:solid 2px #eee;text-align:center;"><b style="font-size: 11px;color:#666;">
							<?php 
								$split_fdate = explode("-",$fifthdate_display);
								echo $split_fdate[1] . '/' . $split_fdate[2] . '/' . $split_fdate[0];
							 ?>
						</b></td>
						<td></td>
						<td></td>
					</tr>
					<tr style="font-size:11px;">
						<td ></td>
						<td style="border-right:solid 2px #eee;border-left:solid 2px #eee;text-align:center;font-weight:bold;">ACTUAL SALES</td>
						<td style="border-right:solid 2px #eee;text-align:center;font-weight:bold;">FORECASTED SALES</td>
						<td ></td>
						<td></td>
					</tr>
					<tr>
						<td style="border-right:solid 2px #eee;"></td>
						<td style="text-align:center;border-right:solid 2px #eee;"><b style="font-size: 12px;font-style:italic;color:green;font-family:Georgia;"><?php echo round($gross,0); ?></b></td>
						<td style="border-right:solid 2px #eee;font-size:12px;text-align:center;font-weight:bold;color:#666;"><input type="text" id="forecast_amount_design" class="dayfive_forecasted_amount" value="<?php echo $forecasted_amount5->forecast_amount; ?>" placeholder="Type here."></td>
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
				<?php foreach($saturday as $row): ?>	
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

		</form>
	</div>

</div>

<script type="text/javascript">
var domain ="http://"+document.domain;

$(document).ready(function(){

$('.dayfive_forecasted_amount').each(function(){
$(this).change(function(){

if(!$.isNumeric($(this).val())) {
   alert('Only Numeric value was allow.');
   $('#df_saturday').find('.'+'dayfive_forecasted_amount').val('');
   return true;

}

$.ajax({
type: "POST",
url:  domain+'/daily_forecasting/u_update5',
data:  {forecasted_amount: $(this).val(), dayfive_date: $('#dayfive_date').val()},
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

if($('.dayfive_forecasted_amount').val()==""){
	alert("Fill-up Forecasting amount first.");
	$('#df_saturday').find('#'+id).val('');
   	$('#df_saturday').find('.'+id).val('');
   	return true;

}

if(!$.isNumeric($(this).val())) {
   alert('Only Numeric value was allow.');
   $('#df_saturday').find('#'+id).val('');
   $('#df_saturday').find('.'+id).val('');
   return true;

}else{

	if(value==""){
   		$('#df_saturday').find('.'+id).val(id+'/'+$(this).val());
    
    }else{
    	$('#df_saturday').find('.'+id).val('');
    	$('#df_saturday').find('.'+id).val(id+'/'+$(this).val());

    }
    	
    // return false;

}

});
});


});
</script>
<?php echo br(2); ?>