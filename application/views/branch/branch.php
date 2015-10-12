<h3 id="page_title">Branch Maintenance</h3>
<hr/>

<div id="new_btn_content">
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
</div>
<br/>

<div id="form_content">

<form method="get">
	
	<label> Branch Name </label>
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
			<th style="width: 140px;" scope="col"> &nbsp; Location ID</th>
			<th style="width: 140px;" scope="col"> &nbsp; SAP Code</th>
			<th scope="col"> &nbsp; Description</th>
			<!--<th style="width:150px; text-align:center;" scope="col">Action</th>-->
		</tr>
	</thead>
	<tbody>
	
		<?php foreach($branch as $row): ?>
		<tr>
			<td style="font-size: 12px;text-align: center;"> &nbsp; <?php echo $row['location']; ?> </td>
			<td style="font-size: 12px;"> &nbsp; <?php echo $row['sapcode']; ?> </td>
			<td style="font-size: 12px;"> &nbsp; <?php echo $row['locationd']; ?> </td>
			<!--<td style="text-align: center;font-size: 12px;">
				  <a href="<?php echo base_url('role/edit') . '/' . $row['user_id']; ?>">Change Role</a> 
				| <a href="<?php echo base_url('role/delete') . '/' . $row['user_id']; ?>">Inactive</a>
			</td>-->
		</tr>
		<?php endforeach; ?>

	</tbody>
</table>

<?php if(count($branch) < 1){?>
    <i style="margin-left:10px;">No Branch found.</i>
<?php }?>

<script type="text/javascript">
$(document).ready(function()
{
$("#myTable").tablesorter();
}
);
</script>

<?php echo br(2); ?>