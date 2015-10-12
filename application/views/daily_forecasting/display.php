<?php 

$daterange_start = $this->input->get('daterange_start');
$daterange_end = $this->input->get('daterange_end');

?>
<h3 id="page_title">Daily Forecasting</h3>

<br/>

<div id="new_btn_content">
	
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
	&nbsp;
	<a href="<?php echo base_url('daily_forecasting/add'); ?>"><button type="button" id="button_design" class="btn btn-success"><span class="glyphicon glyphicon-plus"> </span> New Forecast </button></a>
	
</div>

<hr/>

<div style="width: 85%; margin: 0 auto;">

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>

<form action="<?php echo base_url('daily_forecasting/display'); ?>" method="GET" id="daily_forecasting_daterange_form">
	
	
	  		<label style="color: #333;"> From </label><?php echo nbs(2); ?>

			<input type="text" name="daterange_start" id="daterange_start" class="datepicker_style" value="<?php echo $date_from; ?>" />
	
			<?php echo nbs(2); ?><label style="color: #333;"> To </label><?php echo nbs(2); ?>

			<input type="text" name="daterange_end" id="daterange_end" class="datepicker_style" value="<?php echo $date_to; ?>" />

			<?php echo nbs(2); ?><input type="submit" value="Display" id="button_design" style="margin-top:-0.5px;" class="btn btn-info">

</form>

</div>

<hr/>

<div style="margin:0 auto;width:85%;">
	
	<div style="margin-left: 25px;">
		<span style="font-size: 18px; font-weight:bold; color: #666666; font-family: Monotype Corsiva;font-style:italic;">
			<?php 
				if($count>0){
					echo $count . ' ' . 'Record found/s';
				}else{
					echo 'No record found';
				} 
			?>
		</span>
	</div>

	<?php if(count($result) > 0): ?>
	<div style="border-top:3px solid #eee; margin-top: 10px;">
			<table class="table table-hover">
				<thead>
					<th style="text-align:center;font-family:Georgia;color:#666666;"><span class="glyphicon glyphicon-list-alt"></span> Version</th>
					<th style="text-align:center;font-family:Georgia;color:#666666;"><span class="glyphicon glyphicon-calendar"></span> Forecasted Date</th>
					<th></th>
					<th style="text-align:center;font-family:Georgia;color:#666666;"><span class="glyphicon glyphicon-comment"></span> Remarks</th>
					<th style="text-align:center;font-family:Georgia;color:#666666;"><span class="glyphicon glyphicon-globe"></span> Action</th>
				</thead>
				<tbody>		
				<?php foreach($result as $row): ?>
					<tr style="text-align:center;font-size:11px;font-family:Tahoma;font-weight: bold;color:#666666;">
					<td><?php echo $row['versions']; ?></td>
					<td>
						<?php 
							$split_fdate = explode("-",$row['dateone']);
							$split_tdate = explode("-",$row['dateseven']);
							echo $split_fdate[1] . '-' . $split_fdate[2] . '-' . $split_fdate[0] . ' ' . '/' . ' ' . $split_tdate[1] . '-' . $split_tdate[2] . '-' . $split_tdate[0];
						 ?>
					</td>
					<td></td>
					<td style="width:40%;"><?php echo $row['remarks']; ?></td>
					<td><a href="<?php echo base_url('daily_forecasting/viewing?start=') . $row['dateone'] . '&end=' . $row['dateseven'] . '&version=' . $row['versions']; ?>">View</a> 
						| <a href="#" ><button type="button" value="<?php echo $row['dateone'] . '|' . $row['dateseven'] . '|' . $row['versions']; ?>" class="remarks_modal" style="border:0;background:transparent;">Remarks</button></a>
					</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
	</div>
	<?php endif; ?>
</div>

<script type='text/javascript'>
$(document).ready(function(){

$("#daterange_start").datepicker({
		dateFormat: "yy-mm-dd",
		onSelect: function(selected) {
		  $("#daterange_end").datepicker("option","minDate", selected)
		}
		
});


$("#daterange_end").datepicker({
	dateFormat: "yy-mm-dd",
	onSelect: function(selected) {
	  $("#daterange_start").datepicker("option","maxDate", selected)
	}
	
});


//--update remarks--//

if($(".remarks_modal").length){
$('.remarks_modal').each(function () {
$(this).click(function() {
$('#remarks_modal').modal({
backdrop: 'static',
keyboard: true,

})

var value = $(this).val();
var myarr = value.split("|");

var dateone = myarr[0];
var dateseven = myarr[1];
var version = myarr[2]; 

if(dateone=="" || dateseven==""){
	return false;

}else{
	$('#modal_form_remarks').find('input:hidden[name=dateone]').val(dateone);
	$('#modal_form_remarks').find('input:hidden[name=dateseven]').val(dateseven);
	$('#modal_form_remarks').find('input:hidden[name=version]').val(version);

}


});
});

}


;});
</script>

<!-- Modal -->
<div class="modal fade" id="remarks_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="myModalLabel" style="font-size: 14px; font-weight: bold; color: #333;font-family:Tahoma;">Remarks</h4>
</div>
<form action="<?php echo base_url('daily_forecasting/save_remarks1?daterange_start=') . $daterange_start . '&daterange_end=' . $daterange_end ; ?>" method="POST" id="modal_form_remarks">

<div class="modal-body">

<textarea name="remarks" rows="3" style="width:100%;">

</textarea>
<input type="hidden" name="dateone" />
<input type="hidden" name="dateseven" />
<input type="hidden" name="version" />

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary">Save</button>
</div>

</form>
</div>
</div>
</div>

<?php echo br(4); ?>

