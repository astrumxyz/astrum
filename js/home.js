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
	
	$('.title').data('size','big');
	
	$(window).scroll(function(){
   
    
  if($(document).scrollTop() > 0)
{
    if($('.title').data('size') == 'big')
    {
        $('.title').data('size','small');
//         $('.title').stop().animate({
//            color: white 
//        },600);
        $('.title').text("A");

   
    }
}
else
  {
    if($('.title').data('size') == 'small')
      {
        $('.title').data('size','big');
//           $('.title').stop().animate({
//            color: red
//        },600);
		  
          $('.title').text("Astrum.xyz");
//     
      }  
  }
});
	
});