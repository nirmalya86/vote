$(function() {
    // Side Bar Toggle
    $('.hide-sidebar').click(function() {
	  $('#sidebar').hide('fast', function() {
	  	$('#content').removeClass('span9');
	  	$('#content').addClass('span12');
	  	$('.hide-sidebar').hide();
	  	$('.show-sidebar').show();
	  });
	});

	$('.show-sidebar').click(function() {
		$('#content').removeClass('span12');
	   	$('#content').addClass('span9');
	   	$('.show-sidebar').hide();
	   	$('.hide-sidebar').show();
	  	$('#sidebar').show('fast');
	});
        
$('.close').click(function(){
var checkstr =  confirm('are you sure you want to delete this?');
if(checkstr == true){
  // do your code
  return true;
}else{
return false;
}
});

$('.reset').click(function(){
var checkstr =  confirm('are you sure you want to reset password for this user?');
if(checkstr == true){
  // do your code
  return true;
}else{
return false;
}
});



});