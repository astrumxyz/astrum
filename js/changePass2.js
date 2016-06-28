
$(document).ready(function() {
	
	console.log("Testing..");
    
//Shows Input Box When Focussed
$(".changePassBtn").click(function() {
  var neww = $(".changePass input").css("width");
  $(this).animate({
    width: neww
  }, 300, function() {
    $(".changePass input").fadeIn(300, function() {
      $(".changePassBtn").hide();
    }).focus();
  });
});

//Shows Button When Unfocussed
$(".changePass input").blur(function() {
  $(".changePassBtn").css("width", "200px");
  var neww = $(".changePassBtn").css("width");
  $(this).animate({
    width: neww
  }, 300, function() {
    $(".changePassBtn").show(0, function() {
      $(".changePass input").fadeOut(500, function() {
        $(".changePass input").css("width", "300px");
      });
    });
  });
});
    //$(".oldPass").prop('disabled', true);
    $(".oldPass").hide();
    
    $(".passwordText").keydown(function(event){
    if(event.keyCode == 13){
      var pass = $(this).val();
    
    $('.passwordText').slideUp(500)    
    $(".oldPass").show();
        
    $(".oldPass").keydown(function(event){
    if(event.keyCode == 13){
      var oldPass = $(this).val();
        //var pass = document.getElementById("p2");
    $.ajax({
        url: "../php/passwordchange2.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: { oldPass: oldPass, passwordText: pass }, // data sent to php file
        //data: {pass:"passwordText",oldPass:"oldPass"}
        success: function(data)   // A function to be called if request succeeds
        {
            console.log(data);
            //$('.passwordText').slideUp(500)

        }});    
     console.log("WORKS now!!");   
    }
});
     //console.log("WORKS!!");   
    }
});
    
    $(document).ajaxStop(function(){
    window.location.reload();
});

/*$(".passwordText").keydown(function(event){
    if(event.keyCode == 13){
      var pass = $(this).val();
        //var pass = document.getElementById("p2");
    $.ajax({
        url: "../php/passwordchange.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: 'passwordText=' + pass, // data sent to php file
        success: function(data)   // A function to be called if request succeeds
        {
            console.log(data);
            $('.passwordText').slideUp(500)

        }});    
     //console.log("WORKS!!");   
    }
});
    
    $(".oldPass").keydown(function(event){
    if(event.keyCode == 13){
      var oldPass = $(this).val();
        //var pass = document.getElementById("p2");
    $.ajax({
        url: "../php/passwordchange2.php", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: 'oldPass=' + oldPass, // data sent to php file
        success: function(data)   // A function to be called if request succeeds
        {
            console.log(data);
            //$('.passwordText').slideUp(500)

        }});    
     console.log("WORKS now!!");   
    }
});*/

/*$(".changePassBtn").on('click', function() { //do input instead
       //console.log("WORKS!!");
    $.ajax({
		url: "../php/passwordchange.php", // Url to which the request is send
		type: "POST",             // Type of request to be send, called as method
		data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        datatype: 'text',
		contentType: false,       // The content type used when sending data to the server.
		cache: false,             // To unable request pages to be cached
		processData:false,        // To send DOMDocument or non processed data file it is set to false
		success: function(data)   // A function to be called if request succeeds
		{
            console.log(data);
		
		}});
    
    });*/
});
