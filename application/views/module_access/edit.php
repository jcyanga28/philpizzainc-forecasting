<h3 id="page_title">Modules Access Maintenance</h3>
<hr/>

<div id="new_btn_content">
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
</div>
<br/>

<h5 id="page_title"> &nbsp; Modules Allowed for <?php echo $role['role']; ?></h5>

<table id="myTable" class="datatable">
	<thead>
		<tr>
			<th style="width:125px;" scope="col"> &nbsp; ID</th>
			<th scope="col"> &nbsp; Module</th>
			<th style="width:200px; text-align:center;" scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($modules as $row): ?>
		<tr>
			<td style="text-align: center;font-size: 12px;"><?php echo $row['module_id']; ?></td>
			<td style="font-size: 12px;"> &nbsp; <?php echo $row['module']; ?> </td>
			<td style="text-align: center;font-size: 12px;">
				<a href="<?php echo base_url('module_access/remove_access') . '/' . $role['role_id'] . '/' . $row['module_id']; ?>">Remove Access</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if(count($modules) < 1){?>
    <i style="margin-left:10px;">No Module found.</i>
<?php }?>

<hr/>

<h5 id="page_title"> &nbsp; Modules not Allowed for <?php echo $role['role']; ?></h5>

<table id="myTable" class="datatable">
	<thead>
		<tr>
			<th style="width:125px;" scope="col"> &nbsp; ID</th>
			<th scope="col"> &nbsp; Module</th>
			<th style="width:200px; text-align:center;" scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($modulesnotallowed as $rows): ?>
		<tr>
			<td style="text-align: center;font-size: 12px;"><?php echo $rows['module_id']; ?></td>
			<td style="font-size: 12px;"> &nbsp; <?php echo $rows['module']; ?> </td>
			<td style="text-align: center;font-size: 12px;">
				<a href="<?php echo base_url('module_access/add_access') . '/' . $role['role_id'] . '/' . $rows['module_id']; ?>">Add Access</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if(count($modulesnotallowed) < 1){?>
    <i style="margin-left:10px;">No Module found.</i>
<?php }?>

<script type="text/javascript">
$(document).ready(function()
{
$("#myTable").tablesorter();
}
);
</script>

<?php echo br(2); ?>