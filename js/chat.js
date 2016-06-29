$(document).ready(function() {
    console.log("home.js");
    var left=true;
    $('#menutoggle').click(function(){
        if(left)
        {
        $('.menubar').stop().animate({left: "0px"},500);
        var newwidth = $(document).width()-140;
        $('.chatframe').stop().animate({width: newwidth,left:"140px"},500);
//		$('.message-left').stop().animate({
//			width: "40px"
//			//float: right;
//		},500);
			
        $('.submitmessage').stop().animate({width: newwidth,left:"140px"},500);
			
        left=!left;
        }
        else
        {
        $('.menubar').stop().animate({left: "-140px"},500);
        var newwidth = $(document).width();
        $('.chatframe').stop().animate({width:newwidth,left:"140px"},500);
			
//		$('.message-left').stop().animate({
//			width: "40px"
//			//float: right;
//		},500);
			
        $('.submitmessage').stop().animate({width:newwidth,left:"0px"},500);
        left=!left;
        }
		document.body.style.overflow = "hidden";
		$(this).toggleClass('open');
    });
});