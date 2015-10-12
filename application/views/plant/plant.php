<?php 
	$id = $_GET['id']; 
	$warehouse_id = $_GET['id'];
?>
<br/>
<h4 id="page_title">Warehouse-Plant Maintenance(<?php echo $warehouse_name; ?>)</h4>
<hr/>

<div id="new_btn_content">
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
	<a href="<?php echo base_url('plant/add') . '/' . $id; ?>"><button type="button" id="button_design" class="btn btn-success"><span class="glyphicon glyphicon-plus"> </span> New plant in <?php echo strtolower($warehouse_name); ?> </button></a>
</div>
<br/>

<div id="form_content">

<form method="get">
	
	<label> Plant Name </label>
	<input type="text" name="search" id="search" value="<?php echo $search;?>" placeholder=" Type here. " >
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Search" id="button_design" class="btn btn-default">

</form>

</div>
<br/>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>

<table id="myTable" class="datatable">
	<thead>
		<tr>
			<th style="width: 40px;" scope="col"> &nbsp; ID</th>
			<th style="width: 100px;" scope="col"> &nbsp; Plant</th>
			<th style="width: 85px;" scope="col"> &nbsp; Assigned User</th>
			<th style="width:100px; text-align:center;" scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	
		<?php foreach($plant as $row): ?>
		<tr>
			<td style="font-size: 12px;text-align: center;"> &nbsp; <?php echo $row['id']; ?> </td>
			<td style="font-size: 12px;"> &nbsp; <?php echo $row['plant']; ?> </td>
			<td style="font-size: 12px;"> &nbsp; <?php echo strtoupper($row['locationd']); ?> </td>
			<td style="text-align: center;font-size: 12px;">
				  	<a href="#"><button value="<?php echo $row['id']?>" style="background:transparent;border:0;" class="assign_user">Assign user</button></a>
				  
				  <?php if($row['role_id']=="1"): ?>
				  
				  <?php else: ?>
				  	| <a href="<?php echo base_url('store?id=').$row['id']. '&warehouse_id=' . $warehouse_id; ?>">Store included</a>
				 
				  <?php endif; ?>
				  
				  	| <a href="<?php echo base_url('plant/edit') . '/' . $row['id'] . '/' . $warehouse_id; ?>">Update</a>
				  	| <a href="<?php echo base_url('plant/delete') . '/' . $row['id'] . '/' . $warehouse_id; ?>">Delete</a> 
			</td>
		</tr>
		<?php endforeach; ?>

	</tbody>
</table>

<?php if(count($plant) < 1){?>
    <i style="margin-left:10px;">No plant found.</i>
<?php }?>

<script type="text/javascript">
$(document).ready(function()
{
$("#myTable").tablesorter();
}
);
</script>

<script type='text/javascript'>
$(document).ready(function(){
var domain ="http://"+document.domain;
//--assign user--//

if($(".assign_user").length){
$('.assign_user').each(function () {
$(this).click(function() {
$('#assign_user').modal({
backdrop: 'static',
keyboard: true,

})

$.ajax({
type: "POST",
url:  domain+'/plant/get_plant',
data:  {plant_id: $(this).val()},
dataType: "json",
success: function(content) {
if (content.status == "success") {
$('#modal_form_assignuser').find('input:hidden[name=id]').val(content.data);

}else{
// alert(content.message);
}
}
});
return false;

});
});

}

})
</script>

<!-- Modal -->
<div class="modal fade" id="assign_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div style="width:450px;"  class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="myModalLabel">Assign User</h4>
</div>

<form action="<?php echo base_url('plant/assigned_user'); ?>" method="POST" id="modal_form_assignuser">

	<div class="modal-body">
	<input type="hidden" name="id" >
	<input type="hidden" name="warehouse_id" value="<?php echo $warehouse_id; ?>" >	
	<select name="user" id="user" class="form-control">
		<?php foreach($assign_user as $row): ?>
			<option value=""></option>
			<option value="<?php echo $row['location']?>"><?php echo $row['locationd']?></option>
		<?php endforeach; ?>	
	</select>

	</div>

	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="submit" class="btn btn-primary">Submit</button>
	</div>

</form>

</div>
</div>
</div>

<?php echo br(2); ?>