<style>
.ui-datepicker-calendar {
	display: none;
}
</style>

<h3 id="page_title">Monthly Forecasting</h3>

<br/>

<div id="new_btn_content">
	
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
	
</div>

<hr/>

<div style="width: 78%; margin: 0 auto;">

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>

<h4 style="margin-left: -10px;" id="page_title">Monthly Forecast</h4>
<br/>
<form action="<?php echo base_url('monthly_forecasting/first_month'); ?>" method="GET" id="monthly_forecasting_range_form">
	
		<label style="color: #333;"> From </label><?php echo nbs(2); ?>

		<input type="text" name="monthstart" id="month_start" class="date-picker datepicker_style" value="--/--" /><button type="button" id="btn-go" style="margin-top:-1px;margin-left:-15px;" class="btn btn-default m_go"><span style="color:#fff;" class="glyphicon glyphicon-arrow-right"></span></button>

		<?php echo nbs(2); ?><label style="color: #333;"> To </label><?php echo nbs(2); ?>

		<input name="monthend2" id="month_end" class="date-picker datepicker_style" value="--/--" disabled />
		<input type="hidden" name="monthend" id="month_end2" class="datepicker_style" value="" />

		<hr/>

<h4 style="margin-left: -10px;" id="page_title">Monthly Forecast Reference</h4>
<br/>

		<input type="text" name="ref_monthstart" style="margin-left: 45px;width:200px;" id="ref_month_start" class="date-picker datepicker_style" value="--/--" />

		<?php echo nbs(4); ?> <b style="color: #666;">|</b> <?php echo nbs(4); ?>
		
		<input type="submit" value="Process" id="button_design" style="width:150px;" class="btn btn-success">
			
</form>

</div>

<hr/>

<div style="margin:0 auto;width:80%;">
	
	<?php if(count($result) > 0): ?>
	<div style="border-top:3px solid #eee; margin-top: 10px;">
			<table class="table table-hover">
				<thead>
					<th style="text-align:center;font-family:Georgia;color:#666666;"><span class="glyphicon glyphicon-calendar"></span> Last update</th>
					<th style="text-align:center;font-family:Georgia;color:#666666;"><span class="glyphicon glyphicon-stats"></span> Pending Forecast Month-range</th>
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
								echo $row['update'];

							}
						?>
					</td>
					<td><?php echo $row['monthstart'] . ' ' . ' ' . '/' . ' ' . ' ' . $row['monthend']; ?></td>
					<td></td>
					<td></td>
					<td><a href="<?php echo base_url('monthly_forecasting/first_month?monthstart=') . $row['monthstart'] . '&monthend=' . $row['monthend'] . '&ref_monthstart=' . $row['ref_monthstart'] . '&ref_month_end=' . $row['ref_month_end'] . '&type=' . $row['type']; ?>">Resume</a></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
	</div>	
	<?php endif; ?>
</div>

<script type='text/javascript'>
$(document).ready(function(){

$('#month_start').datepicker( {
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

$('#ref_month_start').datepicker( {
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


$('.m_go').each(function(){
$(this).click(function(){

var m_start = $('#month_start').val();
var split_str = m_start.split("-");
var choose_m_start = split_str[0];

var months = {January: 1, February: 2, March: 3, April: 4, May: 5, June: 6, July: 7, August: 8, September: 9, October: 10, November: 11, December: 12,};

var month = months[choose_m_start];
var month_year = month + '/' + '01' + '/' + split_str[1];
var my = new Date(month_year);

my.setMonth(my.getMonth() + 2);

var mm = my.getMonth()+1;
var yyyy = my.getFullYear();

var m = new Array(7);
	m[1] = "January";
	m[2] = "February";
	m[3] = "March";
	m[4] = "April";
	m[5] = "May";
	m[6] = "June";
	m[7] = "July";
	m[8] = "August";
	m[9] = "September";
	m[10] = "October";
	m[11] = "November";
	m[12] = "December";

var result_month = m[mm];
var result_year = yyyy;

$('#monthly_forecasting_range_form').find('input:text[name=monthend2]').val(result_month + '-' + result_year);
$('#monthly_forecasting_range_form').find('input:hidden[name=monthend]').val(result_month + '-' + result_year);
$('#monthly_forecasting_range_form').find('input:hidden[name=type]').val('mf');

});
});

$('.m_go2').each(function(){
$(this).click(function(){

var m_start = $('#ref_month_start').val();
var split_str = m_start.split("-");
var choose_m_start = split_str[0];

var months = {January: 1, February: 2, March: 3, April: 4, May: 5, June: 6, July: 7, August: 8, September: 9, October: 10, November: 11, December: 12,};

var month = months[choose_m_start];
var month_year = month + '/' + '01' + '/' + split_str[1];
var my = new Date(month_year);

my.setMonth(my.getMonth() + 2);

var mm = my.getMonth()+1;
var yyyy = my.getFullYear();

var m = new Array(7);
	m[1] = "January";
	m[2] = "February";
	m[3] = "March";
	m[4] = "April";
	m[5] = "May";
	m[6] = "June";
	m[7] = "July";
	m[8] = "August";
	m[9] = "September";
	m[10] = "October";
	m[11] = "November";
	m[12] = "December";

var result_month = m[mm];
var result_year = yyyy;

if($('#month_start').val()=="" || $('#month_start').val()=="--/--"){
	alert("Choose month in Monthly Forecast first.");
	$('#monthly_forecasting_range_form').find('input:text[name=ref_monthstart]').val('--/--');
	$('#monthly_forecasting_range_form').find('input:text[name=ref_monthend]').val('--/--');
	$('#monthly_forecasting_range_form').find('input:hidden[name=ref_month_end]').val('');

}else{

	$('#monthly_forecasting_range_form').find('input:text[name=ref_monthend]').val(result_month + '-' + result_year);
	$('#monthly_forecasting_range_form').find('input:hidden[name=ref_month_end]').val(result_month + '-' + result_year);
	$('#monthly_forecasting_range_form').find('input:hidden[name=type]').val('mfr');

}	

});
});


});
</script>

<script type='text/javascript'>
// $(document).ready(function(){

// $("#startdate").datepicker({
// 		dateFormat: "yy-mm-dd",
	
// });

// $('#startdate').each(function(){
// $(this).change(function(){

// var today = new Date();

// var dd = today.getDate();
// var mm = today.getMonth()+1; 
// var yyyy = today.getFullYear();

// var date_now = yyyy + '-' + mm + '-' + dd;

// var weekday=new Array(7);
// weekday[1]="Monday";
// weekday[2]="Tuesday";
// weekday[3]="Wednesday";
// weekday[4]="Thursday";
// weekday[5]="Friday";
// weekday[6]="Saturday";
// weekday[0]="Sunday";

// var dt = new Date($(this).val());
// var dateget = weekday[dt.getDay()]; 

// var date = new Date();
// date.setDate(dt.getDate() + 6);
// var dateend = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();

// if(dateget == "Tuesday"){
// 	$('#daily_forecasting_daterange_form').find('input:text[name=enddate]').val(dateend);
// 	$('#daily_forecasting_daterange_form').find('input:hidden[name=end_date]').val(dateend);

// }else{
// 	alert("Make sure your choose start-date was Tuesday.");
// 	$('#daily_forecasting_daterange_form').find('input:text[name=startdate]').val(date_now);
// 	$('#daily_forecasting_daterange_form').find('input:text[name=enddate]').val(date_now);
// 	$('#daily_forecasting_daterange_form').find('input:hidden[name=end_date]').val(date_now);

// }

// });
// });


// ;});
// </script>

<?php echo br(5); ?>