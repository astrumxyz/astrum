
$(document).ready(function() {
	
	console.log("Testing blurb..");
    
	
	$('.blurbEdit').hide();
	
    $('.changeBlurb').on('click', function(e){
		console.log("blurb clicked");
		$(".blurbEdit").show();
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
    
    
	//Use tinymce later


});