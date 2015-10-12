<h3 id="page_title">Module Access Maintenance</h3>
<hr/>

<div id="transaction_form_content">
<br/>

<form action="" method="POST" id="myform" style="margin-left: 20px;" >
	
	<?php echo form_hidden('role_id',$role['role_id'] ); ?>
	<label> User Role : </label>
	<label> <?php echo $role['role']; ?> </label>
	<br/>

	<label> Module List </label>
	<br/>

	<?php foreach($module as $row): ?>
	<span style="font-size:12px;margin-left: 55px;"><?php echo $row['module']; ?></span><br/>
	<?php endforeach; ?>
	
   <div style="margin-top: 20px;width:400px;text-align:right;">		
	<input type="submit" value="Delete Module Access" id="button_design" onclick="return confirm('Are you sure you want to delete this Module Access?');" class="btn btn-info">
	&nbsp; <a href="<?php echo base_url('module_access/'); ?>"><button type="button" id="button_design" class="btn btn-default">Cancel</button></a>
   </div>

</form>
<br/>

</div>
<br/>

<?php echo br(2); ?>