var domain ="http://"+document.domain;

$(document).ready(function(){

//--update role user maintenance--//

if($(".userrole_modal").length){
$('.userrole_modal').each(function () {
$(this).click(function() {
$('#userrole_modal').modal({
backdrop: 'static',
keyboard: true,

})

$.ajax({
type: "POST",
url:  domain+'/user/getuser_role',
data:  {user_id: $(this).val()},
dataType: "json",
success: function(content) {
	  
	  if(content.status=="success"){
	  	$('#modal_form_userrole').find('input:hidden[name=user_id]').val(content.data);
	  
	  }else{
	  	alert(content.message);

	  }

}
});
return false;


});
});

$('.update_userrole').click(function(){

$.ajax({
type: "POST",
url:  domain+'/user/update_role',
data:  $('#modal_form_userrole').serialize(),
dataType: "json",
success: function(content) {

	if (content.status == "success") {
		alert(content.message)
		window.location = domain+'/user';
	
	}else{
		alert(content.message);
	
	}

}
});

return false;
});
}

});