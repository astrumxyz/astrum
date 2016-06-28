$(document).ready(function(){    
    loadstation();
    
    $('.messagebox').keydown(function(event) {
        console.log("hit");
        if (event.keyCode == 13) {
            $(this.form).submit()
            return false;
        }
    });
});

function loadstation(){
    $("#messagebox").load("../php/livemessages.php");
    //console.log("ran");
    setTimeout(loadstation, 250);
}