<h3 id="page_title">Warehouse Maintenance</h3>
<hr/>

<?php echo $this->session->flashdata('msg');?>
<?php echo ((isset($msg))? $msg : '');?>

<div id="transaction_form_content">
<br/>

<form action="" method="POST" id="myform" style="margin-left: 20px;" >
	
	<?php echo form_hidden('id',$warehouse['id'] ); ?>
	<label> Warehouse Name : </label>
	&nbsp;<label><?php echo $warehouse['warehouse'];?></label>
	
   <div style="margin-top: 20px;width:442px;text-align:right;">		
	<input type="submit" value="Delete Warehouse" id="button_design" onclick="return confirm('Are you sure you want to delete this Warehouse?');" class="btn btn-info">
	&nbsp; <a href="<?php echo base_url('warehouse/'); ?>"><button type="button" id="button_design" class="btn btn-default">Cancel</button></a>
   </div>

</form>
<br/>

</div>
<br/>

<?php echo br(2); ?>