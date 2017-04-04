
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
    <div class="container-fluid">
        <div class="navbar-header">
            <a id="menu-toggle" href="#" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
            </a>

            <a class="navbar-brand" href="#">
             <img src="logo.png" style="width:155px;height:33px;">
            </a>
        </div>
        
       
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#"><label id="login_user_name" >Name</label>
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="userProfile.php">My Profile</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="logout.php" id="logout-button" >Log Out</a></li>
              </ul>
          </li>
           
        </ul>
        <div id="sidebar-wrapper" class="sidebar-toggle">
            <div id="nav-menu">
                <div class="submenu">
                    <div class="submenu-heading"> <h5 class="submenu-title"><b>Expenses</b></h5> </div>                   
                </div>
                <div class="submenu">
                    <div class="submenu-heading"> <h5 class="submenu-title"><b>Leaves</b></h5> </div>                   
                </div>
                <div class="submenu">
                    <div class="submenu-heading"> <h5 class="submenu-title"><b>My Assets</b></h5> </div>                   
                </div>
                <div class="submenu">
                    <div class="submenu-heading"> <h5 class="submenu-title"><b>Reportees</b></h5> </div>                   
                </div>
                

            </div>
            
        </div>
        
    </div>
</nav>



<script type="text/javascript">
    $(window).resize(function() {
    var path = $(this);
    var contW = path.width();
    if(contW >= 751){
        document.getElementsByClassName("sidebar-toggle")[0].style.left="200px";
    }else{
        document.getElementsByClassName("sidebar-toggle")[0].style.left="-200px";
    }
});
$(document).ready(function() {
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
        if(left == "200px"){
            document.getElementsByClassName("sidebar-toggle")[0].style.left="-200px";
            $('#overlay').css('opacity', 0);
            setTimeout(function() {
                $('#overlay').remove();
            }, 300);
        }
        // showing the sidebar
        else if(left == "-200px"){
          document.getElementById("page-wrapper").style.marginTop = "52px";
            document.getElementsByClassName("sidebar-toggle")[0].style.left="200px";
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
</script>


  