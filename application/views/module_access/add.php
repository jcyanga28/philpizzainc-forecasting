<h3 id="page_title">Module Access Maintenance</h3>
<hr/>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>
<?php echo form_error('role_id'); ?>
<div id="transaction_form_content">
<br/>

<form action="" method="POST" id="myform" style="margin-left: 20px;" >
	
	<label> User Role </label>
	
	<select data-placeholder="Choose here." name="role_id" id="role_id" class="options_style">
		<option value=""></option>
		<?php foreach($role as $row): ?>
			<option value="<?php echo $row['role_id']?>"><?php echo $row['role']?></option>
		<?php endforeach; ?>
	</select>
	<?php echo br(2); ?>

	<label> Choose Module </label>
	<br/>

	<?php foreach($modules as $rows): ?>
	<input type="checkbox" name="module[]" style="margin-left: 85px;" value="<?php echo $rows['module_id']; ?>" > <span style="font-size:12px;"><?php echo $rows['module']; ?></span><br/>
	<?php endforeach; ?>
	
   <div style="margin-top: 20px;width:400px;text-align:right;">		
	<input type="submit" value="Add Module Access" id="button_design" class="btn btn-info">
	&nbsp; <a href="<?php echo base_url('module_access/'); ?>"><button type="button" id="button_design" class="btn btn-default">Cancel</button></a>
   </div>

</form>
<br/>

</div>
<br/>

<script type="text/javascript">
$(document).ready(function() {

$("#role_id").chosen({allow_single_deselect: true});
});
</script>

<?php echo br(2); ?>