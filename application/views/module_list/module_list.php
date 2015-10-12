<h3 id="page_title">Modules allowed for <?php echo $roles['role']; ?></h3>
<hr/>

<div id="new_btn_content">
	<a href="javascript:history.back()"><button type="button" id="button_design" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"> </span> Back to previous page </button></a>
</div>
<br/>

<table id="myTable" class="datatable">
	<thead>
		<tr>
			<th style="width:125px;" scope="col"> &nbsp; ID</th>
			<th scope="col"> &nbsp; Module</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($modules as $row): ?>
		<tr>
			<td style="text-align: center;font-size: 12px;"><?php echo $row['module_id']; ?></td>
			<td style="font-size: 12px;"> &nbsp; <?php echo $row['module']; ?> </td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if(count($modules) < 1){?>
    <i style="margin-left:10px;">No Module found.</i>
<?php }?>

<script type="text/javascript">
$(document).ready(function()
{
$("#myTable").tablesorter();
}
);
</script>

<?php echo br(2); ?>