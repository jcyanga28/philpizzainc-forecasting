<h3 id="page_title">User Log</h3>
<hr/>

<div id="new_btn_content">
		<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
		<!--<a href="<?php echo base_url('module/add'); ?>"><button type="button" id="button_design" class="btn btn-success"><span class="glyphicon glyphicon-plus"> </span> New Item </button></a>-->
</div>
<br/>

<div id="form_content">

<form method="get">
	
	<label> Location Name  </label>
	<input type="text" name="search" id="search" value="<?php echo $search;?>" placeholder=" Type here. " >
	<input type="submit" value="Search" id="button_design" class="btn btn-default">

</form>

</div>
<br/>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>

<table id="myTable" class="datatable">
	<thead>
		<tr>
			<th style="" scope="col"> &nbsp; ID</th>
			<th style="" scope="col"> &nbsp; IP Address</th>
			<th style="" scope="col"> &nbsp; Location</th>
			<th style="" scope="col"> &nbsp; Date</th>
			<th scope="col"> &nbsp; Time</th>
			<th style="" scope="col"> &nbsp; Message</th>
			<!--<th style="width:150px; text-align:center;" scope="col">Action</th>-->
		</tr>
	</thead>
	<tbody>
	
		<?php foreach($logs as $row): ?>
		<tr>
			<td style="font-size: 12px; color:#333;"> &nbsp; <?php echo $row['id']; ?> </td>
			<td style="font-size: 12px; font-weight:bold;"> &nbsp; <?php echo $row['ip']; ?> </td>
			<td style="font-size: 12px; color:blue;"> &nbsp; <?php echo strtoupper($row['locationd']); ?> </td>
			<td style="font-size: 12px; color:red;"> &nbsp; <?php echo $row['date']; ?> </td>
			<td style="font-size: 12px; color:green;"> &nbsp; <?php echo $row['time']; ?> </td>
			<td style="font-size: 12px; font-weight:bold;"> &nbsp; <?php echo $row['message']; ?> </td>
		</tr>
		<?php endforeach; ?>

	</tbody>
</table>

<?php if(count($logs) < 1){?>
    <i style="margin-left:10px;">No Logs found.</i>
<?php }?>

<script type="text/javascript">
$(document).ready(function()
{
$("#myTable").tablesorter();
}
);
</script>

<?php echo br(2); ?>