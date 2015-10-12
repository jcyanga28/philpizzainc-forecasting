<br/>
<h4 id="page_title">Warehouse-Plant Maintenance(<?php echo $warehouse_name; ?>)</h4>
<hr/>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>

<div id="transaction_form_content">
<br/>

<form action="" method="POST" id="myform" style="margin-left: 20px;" >
	
	<?php echo form_hidden('id',$plant['id'] ); ?>
	<label> Warehouse Name : </label>
	&nbsp;<label><?php echo $plant['plant'];?></label>
	
   <div style="margin-top: 20px;width:442px;text-align:right;">		
	<input type="submit" value="Delete Plant" id="button_design" onclick="return confirm('Are you sure you want to delete this Plant?');" class="btn btn-info">
	&nbsp; <a href="<?php echo base_url('plant?id='.$id); ?>"><button type="button" id="button_design" class="btn btn-default">Cancel</button></a>
   </div>

</form>
<br/>

</div>
<br/>

<?php echo br(2); ?>