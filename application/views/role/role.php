<h3 id="page_title">Role Maintenance</h3>
<hr/>

<div id="new_btn_content">
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
	<a href="<?php echo base_url('role/add'); ?>"><button type="button" id="button_design" class="btn btn-success"><span class="glyphicon glyphicon-plus"> </span> New Role </button></a>
</div>
<br/>

<div id="form_content">

<form method="get">
	
	<label> Role </label>
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
			<th style="width:125px;" scope="col"> &nbsp; Role ID</th>
			<th scope="col"> &nbsp; Role</th>
			<th style="width:150px; text-align:center;" scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($role as $row): ?>
		<tr>
			<td style="text-align: center;font-size: 12px;"><?php echo $row['role_id']; ?></td>
			<td style="font-size: 12px;"> &nbsp; <?php echo $row['role']; ?> </td>
			<td style="text-align: center;font-size: 12px;">
				  <a href="<?php echo base_url('role/edit') . '/' . $row['role_id']; ?>">Update</a> 
				| <a href="<?php echo base_url('role/delete') . '/' . $row['role_id']; ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if(count($role) < 1){?>
    <i style="margin-left:10px;">No Role found.</i>
<?php }?>

<script type="text/javascript">
$(document).ready(function()
{
$("#myTable").tablesorter();
}
);
</script>

<?php echo br(2); ?>