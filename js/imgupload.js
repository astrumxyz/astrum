$(document).ready(function (e) {
    //To transfer clicks to divs
     $(".upload-button").on('click', function() {
       $("#file").click();
    });
    $(".save").on('click', function() {
       $(".submit").click();
    });
    
    
		$("#uploadimage").on('submit',(function(e) {
		e.preventDefault();
		
		
		$.ajax({
		url: "../php/upload.php", // Url to which the request is send
		type: "POST",             // Type of request to be send, called as method
		data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
		contentType: false,       // The content type used when sending data to the server.
		cache: false,             // To unable request pages to be cached
		processData:false,        // To send DOMDocument or non processed data file it is set to false
		success: function(data)   // A function to be called if request succeeds
		{
		
		}
		});
		}));
		
		// Function to preview image after validation
		$(function() {
		$("#file").change(function() {
		 // To remove the previous error message
		var file = this.files[0];
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
		{
		$('.userimg').attr('src','noimage.png');
		
		return false;
		}
		else
		{
		var reader = new FileReader();
		reader.onload = imageIsLoaded;
		reader.readAsDataURL(this.files[0]);
		}
		});
		});
		function imageIsLoaded(e) {
		
		$('#image_preview').css("display", "block");
		$('.userimg').attr('src', e.target.result);
		$('.userimg').attr('width', '250px');
		$('.userimg').attr('height', '230px');
		};
});