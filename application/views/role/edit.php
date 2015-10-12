<h3 id="page_title">Role Maintenance</h3>
<hr/>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>
<?php echo form_error('role'); ?>
<div id="transaction_form_content">
<br/>

<form action="" method="POST" id="myform" style="margin-left: 20px;" >
	
	<label> Role Name : </label>
	&nbsp;<input type="text" name="role" id="inputs" value="<?php echo $role['role'];?>" placeholder=" Type here. " >
	
   <div style="margin-top: 20px;width:442px;text-align:right;">		
	<input type="submit" value="Edit Role" id="button_design" class="btn btn-info">
	&nbsp; <a href="<?php echo base_url('role/'); ?>"><button type="button" id="button_design" class="btn btn-default">Cancel</button></a>
   </div>

</form>
<br/>

</div>
<br/>

<script type="text/javascript">
$("#myform").validate({
		errorElement: "span", 
		//set the rules for the fild names
		rules: { role: { required: true }
			},
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
					// error.appendTo('#error-' + element.attr('id'));
			}
	});
</script>

<?php echo br(2); ?>