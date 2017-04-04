<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<style type="text/css">
    nav {
    z-index: 1;
}
#sidebar-wrapper {
  top: 52px;
  left: -2000px;
  width: 200px;
  background-color: rgb(300, 300, 300   );
  color: black;
  position: fixed;
  height: 100%;
  z-index: 1;
}
.sidebar-nav {
  position: absolute;
  top: 0;
  margin: 0;
  padding: 0;
  width: 250px;
  list-style: none;
}
#sidebar-wrapper.sidebar-toggle {
  transition: all 0.3s ease-out;
  margin-left: -200px;
}
@media (min-width: 768px) {
  #sidebar-wrapper.sidebar-toggle {
    transition: 0s;
    left: 200px;
  }
  #page-wrapper {
      margin-left: 200px;
      margin-top: 52px;
  }
}

.submenu-heading {
    padding: 2px;
    padding-left: 15px;
    cursor: pointer;
}

.submenu-heading h4 {
    margin: 0;
}

.submenu-heading:hover {
    background: rgb(27, 99, 232);
    color: white;
}

.submenu .list-group {
    margin: 0;
}

.submenu .list-group-item {
    border-radius: 0;
    background: rgba(0, 0, 0, .07);
    border: 0;
    color: black;
    padding: .75em 1.7em;
}

.submenu .list-group-item:hover {
    background: rgb(103, 146, 227);
    color:white;
}
.navbar {
  background: rgb(300, 300, 300   );
}
body {
  background: rgb(217, 214, 213);
}
</style>
  </head>
  <body >
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
              <a class="dropdown-toggle" data-toggle="dropdown" id="login_user_name" href="#">Name
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

<div id="page-wrapper" >
<div class="container">

    Page content
    aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
</div>
</div>

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


  </body>
</html>