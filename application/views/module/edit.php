<h3 id="page_title">Module Maintenance</h3>
<hr/>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>
<?php echo form_error('module'); ?>
<div id="transaction_form_content">
<br/>

<form action="" method="POST" id="myform" style="margin-left: 20px;" >
	
	<label> Module Name : </label>
	&nbsp;<input type="text" name="module" id="inputs" value="<?php echo $modules['module'];?>" placeholder=" Type here. " >
	
   <div style="margin-top: 20px;width:462px;text-align:right;">		
	<input type="submit" value="Edit Module" id="button_design" class="btn btn-info">
	&nbsp; <a href="<?php echo base_url('module/'); ?>"><button type="button" id="button_design" class="btn btn-default">Cancel</button></a>
   </div>

</form>
<br/>

</div>
<br/>

<script type="text/javascript">
$("#myform").validate({
		errorElement: "span", 
		//set the rules for the fild names
		rules: { module: { required: true }
			},
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
					// error.appendTo('#error-' + element.attr('id'));
			}
	});
</script>

<?php echo br(2); ?>