<h3 id="page_title">Warehouse Maintenance</h3>
<hr/>

<div id="new_btn_content">
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
	<a href="<?php echo base_url('warehouse/add'); ?>"><button type="button" id="button_design" class="btn btn-success"><span class="glyphicon glyphicon-plus"> </span> New Warehouse </button></a>
</div>
<br/>

<div id="form_content">

<form method="get">
	
	<label> Warehouse Name </label>
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
			<th style="width: 50px;" scope="col"> &nbsp; ID</th>
			<th style="width: 140px;" scope="col"> &nbsp; Warehouse</th>
			<th style="width:100px; text-align:center;" scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	
		<?php foreach($warehouse as $row): ?>
		<tr>
			<td style="font-size: 12px;text-align: center;"> &nbsp; <?php echo $row['id']; ?> </td>
			<td style="font-size: 12px;"> &nbsp; <?php echo $row['warehouse']; ?> </td>
			<td style="text-align: center;font-size: 12px;">
				  <a href="<?php echo base_url('plant?id=') . $row['id']; ?>">Plant</a>
				  | <a href="<?php echo base_url('warehouse/edit') . '/' . $row['id']; ?>">Update</a>
				  | <a href="<?php echo base_url('warehouse/delete') . '/' . $row['id']; ?>">Delete</a> 
			</td>
		</tr>
		<?php endforeach; ?>

	</tbody>
</table>

<?php if(count($warehouse) < 1){?>
    <i style="margin-left:10px;">No Warehouse found.</i>
<?php }?>

<script type="text/javascript">
$(document).ready(function()
{
$("#myTable").tablesorter();
}
);
</script>

<?php echo br(2); ?>