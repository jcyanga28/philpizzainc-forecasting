<ul class="cb-slideshow">
    <li style="list-style-type:none;"><span></span><div></div></li>
    <li style="list-style-type:none;"><span></span><div></div></li>
    <li style="list-style-type:none;"><span></span><div></div></li>
    <li style="list-style-type:none;"><span></span><div></div></li>
    <li style="list-style-type:none;"><span></span><div></div></li>
    <li style="list-style-type:none;"><span></span><div></div></li>
</ul>

<div style="height:90%;" id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div id="title_container" class="modal-header">
        <h1 id="title_design" class="text-center">FORECASTING SYSTEM</h1>
      </div>
      <br/>

        <?php echo $this->session->flashdata('msg');?>

      <div class="modal-body">
        <form action="<?php echo base_url('login'); ?>" method="POST" id="form-login" class="form col-md-12 center-block">
        
          <div id="uname_container" class="form-group">
            <input type="text" name="username" id="username" class="form-control input-lg" placeholder="Username" style="width:90%;margin:0 auto;text-align: center;" value="<?php echo set_value('username'); ?>" />
            <input type="hidden" name="connector" id="connector" >
            <?php echo nbs(8) . form_error('username'); ?>
          
          </div>
          
          <div class="form-group">
            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" style="width:90%;margin:0 auto;text-align: center;" value="<?php echo set_value('password'); ?>" />
            <?php echo nbs(8) . form_error('password'); ?>
              
          </div>

          <br/>
          <div style="margin-left:30px;" class="form-group">
            
           <!--  <select data-placeholder="Restaurant included." name="restaurant_type" id="restaurant_type" style="width: 35%;">
                <option value="" <?php echo set_select('restaurant_type', ''); ?> ></option>
                <option value="dq" <?php echo set_select('restaurant_type', 'dq'); ?> >  Dairy Queen </option>
                <option value="ph" <?php echo set_select('restaurant_type', 'ph'); ?> >  Pizza Hut </option>
                <option value="tb" <?php echo set_select('restaurant_type', 'tb'); ?> >  Taco Bell </option>
                <option value="b" <?php echo set_select('restaurant_type', 'b'); ?> >  Pizza Hut - Bistro </option>
            </select>
            <?php echo form_error('restaurant_type'); ?> --> 

            <div style="margin-top:-23px;width:94%;text-align:right;"><span style="font-style:italic;,font-size:12px;"><a href="#" class="forgot_password_modal" style="color:red;">forgot password?</a></span></div>
          </div>
           
          <div style="width:95%;margin:0 auto;" class="form-group">
            <input type="submit" value="Sign In" class="btn btn-primary btn-lg btn-block" />
          <hr/>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <div class="col-md-12">
          <div style="width: 86%;">
            <img src="<?php echo base_url('style/images/ppi/ppi-logo-1st.png'); ?>" id="ppi_logo"></img>
          </div>
        </div>	
      </div>

    <br/>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {

$('#username').change(function(){

if($(this).val() == ""){
  $('#uname_container').find('input:hidden[name=connector]').val('');

}else{

  var uname = $(this).val();

  var myarr = uname.split(' ');
  var connector = myarr[0];

  $('#uname_container').find('input:hidden[name=connector]').val(connector);

}

});

});
</script>

<script type="text/javascript">
$(document).ready(function() {

$("#restaurant_type").chosen({allow_single_deselect: true});
});
</script>

<script type='text/javascript'>
$(document).ready(function(){

//--forgot password--//

if($(".forgot_password_modal").length){
$('.forgot_password_modal').each(function () {
$(this).click(function() {
$('#forgot_password_modal').modal({
backdrop: 'static',
keyboard: true,

})


});
});

}

})
</script>

<!-- Modal -->
<div class="modal fade" id="forgot_password_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div style="width:350px;" class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="myModalLabel" style="font-size: 14px; font-weight: bold; color: #333;font-family:Tahoma;">Forgot/Change Password</h4>
</div>

<div class="modal-body">

<table>
<tr>
<td><img src="<?php echo base_url('style/images/Open_lock.png'); ?>" style="height:75px; width: 75px;"></img></td>
<td><p style="color:#666;background: #fff;font-size: 12px;margin-left: 10px;"> - Asks Sir.Bobet or Ms. Ivy of MIS Department for the password or if you want to change your password.</p></td>
</tr>
</table>

</div>

</div>
</div>
</div>

