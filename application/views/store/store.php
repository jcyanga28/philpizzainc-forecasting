<?php 
	$id = $_GET['id']; 
	$warehouse_id = $_GET['warehouse_id'];
?>
<br/>
<h4 id="page_title">Warehouse-Plant Maintenance(<?php echo $plant_name; ?>)</h4>
<hr/>

<div id="new_btn_content">
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
</div>
<br/>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>

<h4 id="page_title">Store in the List.</h4>
<br/>

<table id="myTables" class="datatable">
	<thead>
		<tr>
			<th style="width: 50px;" scope="col"> &nbsp; ID</th>
			<th style="width: 120px;" scope="col"> &nbsp; Store</th>
			<th style="width:100px; text-align:center;" scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	
		<?php foreach($store_exist as $row): ?>
		<tr>
			<td style="font-size: 12px;text-align: center;"> &nbsp; <?php echo $row['location']; ?> </td>
			<td style="font-size: 12px;"> &nbsp; <?php echo strtoupper($row['locationd']); ?> </td>
			<td style="text-align: center;font-size: 12px;">
				  	<a href="<?php echo base_url('store/remove_access').'/'.$id.'/'.$warehouse_id.'/'.$row['location']; ?>">Remove access</a>
			</td>
		</tr>
		<?php endforeach; ?>

	</tbody>
</table>

<?php if(count($store_exist) < 1){?>
    <i style="margin-left:10px;">No store in the list.</i>
<?php }?>

<hr/>

<h4 id="page_title">Store not in the List.</h4>
<br/>

<table id="myTable" class="datatable">
	<thead>
		<tr>
			<th style="width: 50px;" scope="col"> &nbsp; ID</th>
			<th style="width: 120px;" scope="col"> &nbsp; Store</th>
			<th style="width:100px; text-align:center;" scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	
		<?php foreach($store_notexist as $rows): ?>
		<tr>
			<td style="font-size: 12px;text-align: center;"> &nbsp; <?php echo $rows['location']; ?> </td>
			<td style="font-size: 12px;"> &nbsp; <?php echo strtoupper($rows['locationd']); ?> </td>
			<td style="text-align: center;font-size: 12px;">
				  	<a href="<?php echo base_url('store/add_access').'/'.$id.'/'.$warehouse_id.'/'.$rows['location']; ?>">Add access</a>
			</td>
		</tr>
		<?php endforeach; ?>

	</tbody>
</table>

<?php if(count($store_notexist) < 1){?>
    <i style="margin-left:10px;">No available store.</i>
<?php }?>

<script type="text/javascript">
$(document).ready(function()
{
$("#myTable").tablesorter();
}
);
</script>

<script type="text/javascript">
$(document).ready(function()
{
$("#myTables").tablesorter();
}
);
</script>


<?php echo br(2); ?>