<style>
.ui-datepicker-calendar {
	display: none;
}
</style>

<h3 id="page_title">Monthly Forecasting</h3>

<br/>

<div id="new_btn_content">
	
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
	&nbsp;
	<a href="<?php echo base_url('monthly_forecasting/add'); ?>"><button type="button" id="button_design" class="btn btn-success"><span class="glyphicon glyphicon-plus"> </span> New Monthly Forecast </button></a>
	
</div>

<hr/>

<div style="width: 85%; margin: 0 auto;">

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>

<form action="<?php echo base_url('monthly_forecasting/display'); ?>" method="GET" id="monthly_forecasting_monthrange_form">
	
		<label style="color: #333;"> From </label><?php echo nbs(2); ?>

		<input name="start_month" id="monthstart_format" class="date-picker datepicker_style" value="<?php echo $month_from; ?>" />

		<?php echo nbs(2); ?><label style="color: #333;"> To </label><?php echo nbs(2); ?>

		<input name="end_month" id="monthend_format" class="date-picker datepicker_style" value="<?php echo $month_to; ?>" />
		
		<?php echo nbs(2); ?><input type="submit" value="Display" id="button_design" style="margin-top:-0.5px;" class="btn btn-info">

</form>

</div>

<hr/>

<div style="margin:0 auto;width:85%;">
	
	<div style="float:right;">
			<?php echo $links; ?>
	</div>
	<br/><br/>
	
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
					<th style="text-align:center;font-family:Georgia;color:#666666;"><span class="glyphicon glyphicon-calendar"></span> Forecasted Month-Range</th>
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
							$split = explode("-", $row['fdate_from']);
							$splitm1 = $split[1];
							
							$monthNum  = $splitm1;
							$monthfrom = date('F', mktime(0, 0, 0, $monthNum, 10)) . '-' . $split[0];

							$split2 = explode("-", $row['tdate_from']);
							$splitm2 = $split2[1];
							
							$monthNum2  = $splitm2;
							$monthto = date('F', mktime(0, 0, 0, $monthNum2, 10)) . '-' . $split2[0];

							echo $monthfrom . '/' . $monthto;
							// echo $row['fdate_from'] . ' ' . ' ' . '/' . ' ' . ' ' . $row['tdate_to']; 
						?>
					</td>
					<td></td>
					<td style="width:40%;"><?php echo $row['remarks']; ?></td>
					<td><a href="<?php echo base_url('monthly_forecasting/viewing?start_month=') . $row['fdate_from'] . '&end_month=' . $row['tdate_from'] . '&version=' . $row['versions']; ?>">View</a> 
						| <a href="#" ><button type="button" value="<?php echo $row['fdate_from'] . '|' . $row['tdate_from'] . '|' . $row['versions']; ?>" class="remarks_modal" style="border:0;background:transparent;">Remarks</button></a>
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

$('#monthstart_format').datepicker( {
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM-yy',
    onClose: function(dateText, inst) { 
        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(year, month, 1));
    }
});

$('#monthend_format').datepicker( {
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM-yy',
    onClose: function(dateText, inst) { 
        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(year, month, 1));
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

var fdate_from = myarr[0];
var tdate_from = myarr[1];
var version = myarr[2]; 

if(fdate_from=="" || tdate_from==""){
	return false;

}else{
	$('#modal_form_remarks').find('input:hidden[name=fdate_from]').val(fdate_from);
	$('#modal_form_remarks').find('input:hidden[name=tdate_from]').val(tdate_from);
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

<form action="<?php echo base_url('monthly_forecasting/save_remarks'); ?>" method="POST" id="modal_form_remarks"> 

<div class="modal-body">

<textarea name="remarks" rows="3" style="width:100%;">

</textarea>
<input type="hidden" name="fdate_from" />
<input type="hidden" name="tdate_from" />
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

<?php echo br(5); ?>
