<h3 id="page_title">Change Password</h3>
<hr/>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>
<div id="transaction_form_content">
<br/>

<form action="" method="POST" id="myform" style="margin-left: 20px;" >
	
	<table>
		<tr>
			<td><b> Old Password </b></td>
			<td><?php echo nbs(2); ?><input type="password" name="old_pwd" style="text-align:center;" id="inputs" value="<?php set_value('old_pwd');?>" placeholder=" Type here. " /><?php echo form_error('old_pwd'); ?></td>
		</tr>
		<tr><td><br/></td></tr>
		<tr>
			<td><b> New Password </b></td>
			<td><?php echo nbs(2); ?><input type="password" name="new_pwd" style="text-align:center;" id="inputs" value="<?php set_value('new_pwd');?>" placeholder=" Type here. " ><?php echo form_error('new_pwd'); ?></td>
		</tr>
		<tr><td><br/></td></tr>
		<tr>
			<td><b> Re-type Password </b></td>
			<td><?php echo nbs(2); ?><input type="password" name="retype_new_pwd" style="text-align:center;" id="inputs" value="<?php set_value('retype_new_pwd');?>" placeholder=" Type here. " ><?php echo form_error('retype_new_pwd'); ?></td>
		</tr>
	</table>

   <div style="margin-top: 20px;width:485px;text-align:right;">		
	<input type="submit" value="Update Password" id="button_design" class="btn btn-info">
	&nbsp; <a href="<?php echo base_url('home/'); ?>"><button type="button" id="button_design" class="btn btn-default">Cancel</button></a>
   </div>

</form>
<br/>

</div>
<br/>

<script type="text/javascript">
// $("#myform").validate({
// 		errorElement: "span", 
// 		//set the rules for the fild names
// 		rules: { old_pwd: { required: true } new_pwd:{ required: true}
// 			},
// 		errorPlacement: function(error, element) {               
// 					error.appendTo(element.parent());     
// 					// error.appendTo('#error-' + element.attr('id'));
// 			}
// 	});
</script>

<?php echo br(2); ?>