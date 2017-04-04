 $(window).resize(function() {
    var path = $(this);
    var contW = path.width();
    if(contW >= 751){
        document.getElementsByClassName("sidebar-toggle")[0].style.left="160px";
    }else{
        document.getElementsByClassName("sidebar-toggle")[0].style.left="-160px";
    }
});
$(document).ready(function() {
    document.getElementById("#login_user_name").append("hey");

  document.getElementById("page-wrapper").style.marginTop = "52px";
    $('.dropdown').on('show.bs.dropdown', function(e){
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
    });
    $('.dropdown').on('hide.bs.dropdown', function(e){
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(300);
    });
    
    toggleMenu = function() {
        var elem = document.getElementById("sidebar-wrapper");
        left = window.getComputedStyle(elem,null).getPropertyValue("left");
        
      //  document.getElementById("page-wrapper").style.margin = "52px";
        // hiding the sidebar
        if(left == "160px"){
            document.getElementsByClassName("sidebar-toggle")[0].style.left="-160px";
            $('#overlay').css('opacity', 0);
            setTimeout(function() {
                $('#overlay').remove();
            }, 300);
        }
        // showing the sidebar
        else if(left == "-160px"){
          document.getElementById("page-wrapper").style.marginTop = "52px";
            document.getElementsByClassName("sidebar-toggle")[0].style.left="160px";
            // adding overlay to darken #page-wrapper and dismiss the left drawer...
            $overlay = $('<div id="overlay" style="position: absolute; height: 100%; width: 100%; top: 0; left: 0; background: rgb(0, 0, 0); opacity: 0; transition: ease-in-out all .3s"></div>');
            $overlay.click(toggleMenu);            
            setTimeout(function() {
                $overlay.css('opacity', .1);
            }, 200);
            $('#page-wrapper').prepend($overlay);
        }
    }
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        toggleMenu();        
    });
    
 
});