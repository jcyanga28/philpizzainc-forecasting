
<h3 id="page_title">Daily Forecasting</h3>

<br/>

<div id="new_btn_content">
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>

</div>

<hr/>

<div style="width: 78%; margin: 0 auto;">

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>

<h4 style="margin-left: -10px;" id="page_title">Weekly Forecast</h4>
<br/>
<form action="<?php echo base_url('daily_forecasting/tuesday'); ?>" method="GET" id="daily_forecasting_daterange_form">
	
	
	  		<label style="color: #333;"> From </label><?php echo nbs(2); ?>

			<input type="text" name="startdate" id="startdate" class="datepicker_style" value="--/--/--" />
	
			<?php echo nbs(2); ?><label style="color: #333;"> To </label><?php echo nbs(2); ?>

			<input type="text" name="enddate" id="enddate" class="datepicker_style" value="--/--/--" disabled/>
			<input type="hidden" name="end_date" class="datepicker_style" />

<hr/>

<h4 style="margin-left: -10px;" id="page_title">Weekly Forecast Reference</h4>
<br/>
		
	  		<label style="color: #333;"> From </label><?php echo nbs(2); ?>

			<input type="text" name="ref_startdate" id="ref_startdate" class="datepicker_style" value="--/--/--" />
	
			<?php echo nbs(2); ?><label style="color: #333;"> To </label><?php echo nbs(2); ?>

			<input type="text" name="ref_enddate" id="ref_enddate" class="datepicker_style" value="--/--/--" disabled/>
			<input type="hidden" name="ref_end_date" class="datepicker_style" />
			<input type="hidden" name="type" />
			
			<?php echo br(2); ?>

			<div style="width: 65%;">
				<div style="text-align: right;">
					<input type="submit" value="Process" id="button_design" style="width:150px;" class="btn btn-success">
				</div>
			</div>			
			<!-- <?php echo nbs(2); ?><input type="submit" value="Process" id="button_design" style="margin-top:-0.5px;" class="btn btn-info"> -->

</form>

</div>

<hr/>

<div style="margin:0 auto;width:80%;">
	
	<?php if(count($result) > 0): ?>
	<div style="border-top:3px solid #eee; margin-top: 10px;">
			<table class="table table-hover">
				<thead>
					<th style="text-align:center;font-family:Georgia;color:#666666;"><span class="glyphicon glyphicon-calendar"></span> Last update</th>
					<th style="text-align:center;font-family:Georgia;color:#666666;"><span class="glyphicon glyphicon-stats"></span> Pending Forecast Date</th>
					<th></th>
					<th></th>
					<th style="text-align:center;font-family:Georgia;color:#666666;"><span class="glyphicon glyphicon-globe"></span> Action</th>
				</thead>
				<tbody>		
				<?php foreach($result as $row): ?>
					<tr style="text-align:center;font-size:11px;font-family:Tahoma;font-weight: bold;color:#666666;">
					<td>
						<?php 
							if($row['update']==""){
								echo "--/--/----";

							}else{
									$split_udate = explode("-",$row['update']);
									echo $split_udate[1] . '-' . $split_udate[2] . '-' . $split_udate[0];
					
							}
						?>
					</td>
					<td>
						<?php 
							$split_fdate = explode("-",$row['datestart']);
							$split_tdate = explode("-",$row['dateend']);
							echo $split_fdate[1] . '-' . $split_fdate[2] . '-' . $split_fdate[0] . ' ' . ' ' . '/' . ' ' . ' ' . $split_tdate[1] . '-' . $split_tdate[2] . '-' . $split_tdate[0];
						 ?>
					</td>
					<td></td>
					<td></td>
					<td><a href="<?php echo base_url('daily_forecasting/tuesday?startdate=') . $row['datestart'] . '&end_date=' . $row['dateend'] . '&ref_startdate=' . $row['ref_datestart'] . '&ref_end_date=' . $row['ref_dateend'] . '&type=' . $row['type']; ?>">Resume</a></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
	</div>	
	<?php endif; ?>
</div>

<script type='text/javascript'>
$(document).ready(function(){

$("#startdate").datepicker({
		dateFormat: "yy-mm-dd",
		// onSelect: function(selected) {
	 //  	$("#start_date").datepicker("option","maxDate", selected)
		// }
});

$("#ref_startdate").datepicker({
		dateFormat: "yy-mm-dd",
			
});

$('#startdate').each(function(){
$(this).change(function(){

var today = new Date();

var dd = today.getDate();
var mm = today.getMonth()+1; 
var yyyy = today.getFullYear();

var date_now = yyyy + '-' + mm + '-' + dd;

var weekday=new Array(7);
weekday[1]="Monday";
weekday[2]="Tuesday";
weekday[3]="Wednesday";
weekday[4]="Thursday";
weekday[5]="Friday";
weekday[6]="Saturday";
weekday[0]="Sunday";

var dt = new Date($(this).val());
var dateget = weekday[dt.getDay()]; 

var date = new Date(dt);
date.setDate(dt.getDate() + 6);
var dateend = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();

if(dateget == "Tuesday"){
	$('#daily_forecasting_daterange_form').find('input:text[name=enddate]').val(dateend);
	$('#daily_forecasting_daterange_form').find('input:hidden[name=end_date]').val(dateend);
	$('#daily_forecasting_daterange_form').find('input:hidden[name=type]').val('wf');

}else{
	alert("Make sure your choose start-date was Tuesday.");
	$('#daily_forecasting_daterange_form').find('input:text[name=startdate]').val('--/--/--');
	$('#daily_forecasting_daterange_form').find('input:text[name=enddate]').val('--/--/--');
	$('#daily_forecasting_daterange_form').find('input:hidden[name=end_date]').val('');
	$('#daily_forecasting_daterange_form').find('input:hidden[name=type]').val('');

}

});
});

$('#ref_startdate').each(function(){
$(this).change(function(){

var today = new Date();

var dd = today.getDate();
var mm = today.getMonth()+1; 
var yyyy = today.getFullYear();

var date_now = yyyy + '-' + mm + '-' + dd;

var weekday=new Array(7);
weekday[1]="Monday";
weekday[2]="Tuesday";
weekday[3]="Wednesday";
weekday[4]="Thursday";
weekday[5]="Friday";
weekday[6]="Saturday";
weekday[0]="Sunday";

var dt = new Date($(this).val());
var dateget = weekday[dt.getDay()]; 

var date = new Date(dt);
date.setDate(dt.getDate() + 6);
var dateend = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();

if($('#startdate').val()=="" || $('#startdate').val()=="--/--/--"){
	alert("Choose date in Weekly Forecast first.");
	$('#daily_forecasting_daterange_form').find('input:text[name=ref_startdate]').val('--/--/--');
	$('#daily_forecasting_daterange_form').find('input:text[name=ref_enddate]').val('--/--/--');
	$('#daily_forecasting_daterange_form').find('input:hidden[name=ref_end_date]').val('');

}

if(dateget == "Tuesday"){
	$('#daily_forecasting_daterange_form').find('input:text[name=ref_enddate]').val(dateend);
	$('#daily_forecasting_daterange_form').find('input:hidden[name=ref_end_date]').val(dateend);
	$('#daily_forecasting_daterange_form').find('input:hidden[name=type]').val('wrf');

}else{
	alert("Make sure your choose start-date was Tuesday.");
	$('#daily_forecasting_daterange_form').find('input:text[name=ref_startdate]').val('--/--/--');
	$('#daily_forecasting_daterange_form').find('input:text[name=ref_enddate]').val('--/--/--');
	$('#daily_forecasting_daterange_form').find('input:hidden[name=ref_end_date]').val('');
	$('#daily_forecasting_daterange_form').find('input:hidden[name=type]').val('');
	return false;

}

});
});


;});
</script>
<?php echo br(5); ?>