<br/>
<h4 id="page_title">Warehouse-Plant Maintenance(<?php echo $warehouse_name; ?>)</h4>
<hr/>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>
<?php echo form_error('plant'); ?>
<div id="transaction_form_content">
<br/>

<form action="" method="POST" id="myform" style="margin-left: 20px;" >
	
	<label> Plant Name : </label>
	&nbsp;<input type="text" name="plant" id="inputs" value="<?php set_value('plant');?>" placeholder=" Type here. " >

   <div style="margin-top: 20px;width:445px;text-align:right;">		
	<input type="submit" value="Add Plant" id="button_design" class="btn btn-info">
	&nbsp; <a href="<?php echo base_url('plant?id='.$id); ?>"><button type="button" id="button_design" class="btn btn-default">Cancel</button></a>
   </div>

</form>
<br/>

</div>
<br/>

<script type="text/javascript">
$("#myform").validate({
		errorElement: "span", 
		//set the rules for the fild names
		rules: { warehouse: { required: true }
			},
		errorPlacement: function(error, element) {               
					error.appendTo(element.parent());     
					// error.appendTo('#error-' + element.attr('id'));
			}
	});
</script>

<?php echo br(2); ?>