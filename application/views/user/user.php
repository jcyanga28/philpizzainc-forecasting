<h3 id="page_title">User Maintenance</h3>
<hr/>

<div id="new_btn_content">
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
</div>
<br/>

<div id="form_content">

<form method="get">
	
	<label> Fullname </label>
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
			<th style="width:90px;" scope="col"> &nbsp; ID</th>
			<th style="width:175px;" scope="col"> &nbsp; Sap Code</th>
			<th scope="col"> &nbsp; Username</th>
			<th style="width:225px;" scope="col">User Role</th>
			<th style="width:175px; text-align:center;" scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
	
		<?php foreach($user as $row): ?>
		<tr>
			<td style="text-align: center;font-size: 12px;"><?php echo $row['location']; ?></td>
			<td style="font-size: 12px;"> &nbsp; <?php echo $row['sapcode']; ?> </td>	
			<td style="font-size: 12px;"> &nbsp; <?php echo $row['locationd']; ?> </td>	
			<td style="font-size: 12px;"> &nbsp; <?php echo $row['role']; ?> </td>	
			<td style="text-align: center;font-size: 12px;">
				  <a href="#"><button type="button" value="<?php echo $row['location']; ?>" class="userrole_modal" style="border:0;background:transparent">Change Role</button></a> 
				<!--| <a href="<?php echo base_url('role/delete') . '/' . $row['location']; ?>">Inactive</a>-->
			</td>
		</tr>
		<?php endforeach; ?>

	</tbody>
</table>

<?php if(count($user) < 1){?>
    <i style="margin-left:10px;">No User found.</i>
<?php }?>

<script type="text/javascript">
$(document).ready(function()
{
$("#myTable").tablesorter();
}
);
</script>

<!-- Modal -->
<div class="modal fade" id="userrole_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="myModalLabel" style="font-size: 14px; font-weight: bold; color: #333;font-family:Tahoma;">Update User Role</h4>
</div>

<form id="modal_form_userrole">

<div class="modal-body">

<input type="hidden" name="user_id" id="user_id" />

<label><b style="font-size: 12px; color: #333;font-family:Tahoma;">Choose Role</b></label>

<select name="userrole" id="userrole" class="form-control" style="font-size: 12px;" >
<option value=""></option>
<?php foreach($roles as $row): ?>
<option value="<?php echo $row['role_id']?>"><?php echo $row['role']?></option>
<?php endforeach; ?>	
</select >	

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-primary update_userrole">Submit</button>
</div>

</form>
</div>
</div>
</div>

<?php echo br(2); ?>