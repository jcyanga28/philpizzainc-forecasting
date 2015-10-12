$(document).ready(function(){

$('.process_excel').each(function(){
$(this).click(function(){

	$('#process_excel').modal({
	backdrop: 'static',
	keyboard: true,

	})
	setTimeout(function(){
        $("#process_excel").hide();
    }, 300000);
});
});

});