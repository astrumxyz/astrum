$(document).ready(function() {
    console.log("home.js");
    var left=true
    $('#menutoggle').click(function(){
        if(left)
        {
        $('.menubar').stop().animate({left: "0px"},500);
        left=!left;
        }
        else
        {
        $('.menubar').stop().animate({left: "-140px"},500);
        left=!left;
        }
		//document.body.style.overflow = "hidden";
        $(this).toggleClass('open');
    });
    $('.headertext').css('visibility','visible').hide().fadeIn(1000).animate({top:0,opacity:0},2000,'linear',function(){$(this).remove()});
});