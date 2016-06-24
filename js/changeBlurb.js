
$(document).ready(function() {
	
	console.log("Testing blurb..");
    
	
	$('.blurbEdit').hide();
	$('.blurbEdit').height(0);
	
    $('.changeBlurb').on('click', function(e){
		console.log("blurb clicked");
	
		var neww = $(".blurbEdit").css("width");
  $(this).animate({
    width: neww
  }, 200, function() {
	//$('.blurbEdit').animate ({height: 200;});
	  $('.blurbEdit').animate({
    height: 200
  }, "normal");
    $(".blurbEdit").fadeIn(300, function() {
      $('.changeBlurb').hide();
    }).focus();
	  
  });
		//$(".blurbEdit").show();
	});
    
	
	$(".blurbEdit").keydown(function(event){
    if(event.keyCode == 13){
      var blurb = $(this).val();
   
        
    $.ajax({
        url: "../php/blurb.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: { blurbEdit: blurb }, // data sent to php file
        //data: {pass:"passwordText",oldPass:"oldPass"}
        success: function(data)   // A function to be called if request succeeds
        {
            console.log("BLURB WORKS!");
           

        }})
	}});    


});