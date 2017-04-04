.<?php
include 'empSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Employee Records - TagOps</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <!--   <link rel="stylesheet" href="/resources/demos/style.css">  -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <!--   <link href="css/bootstrap.min.css" rel="stylesheet">  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link rel="stylesheet" href="empBars.css">
<link rel="stylesheet" href="empExpenses.css">

<script>
  $( function() {
    $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
  <style type="text/css">
    h5,a{
  margin-top: 0px;
  margin-bottom: 0px;
    font-family:Montserrat;
    font-size: 16px;
} 
.submenu-heading {
        padding: 0px;
    padding-left: 0px;
    cursor: pointer;
}
    .btn{
      width: 72px;
      height: 25px;
      color: white;
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

            <a class="navbar-brand" href="empExpenses.php">
             <img src="logo.png" style="width:120px;height:45px;padding-bottom: 20px;margin-top: 0px;">
            </a>
        </div>
        
       
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
              <a class="dropdown-toggle" id="login_user_name" data-toggle="dropdown" href="#" style="background-color: white; ">
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="empProfile.php">My Profile</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="logout.php" id="logout-button" >Log Out</a></li>
              </ul>
          </li>
           
        </ul>
        <div id="sidebar-wrapper" class="sidebar-toggle">
            <div id="nav-menu">
                <div class="submenu">
                    <div class="submenu-heading" id="expenses"> <h5 class="submenu-title" ><img src="Expenses.png" alt="expenses" >Expenses</h5> </div>                   
                </div>
                <div class="submenu">
                    <div class="submenu-heading" id="leaves"> <h5 class="submenu-title" id="leaves"><img src="Leaves.png" alt="leaves" >Leaves</h5> </div>                   
                </div>
                <div class="submenu">
                    <div class="submenu-heading" id="assets"> <h5 class="submenu-title" id="assest"><img src="Assets.png" alt="assets" >Assets</h5> </div>                   
                </div>
                <div class="submenu">
                    <div class="submenu-heading" id="reportees"> <h5 class="submenu-title" id="reportees"><img src="Reportees.png" alt="reportees" >Reportees</h5> </div>                   
                </div>
                

            </div>
            
        </div>
        
    </div>
</nav>


<div id="page-wrapper" class="container" >
    <div class="bs-example">
    <center>   <ul class="nav nav-pills" style="display:inline-block;" id="myTab" >
            <li class="active " ><a data-toggle="tab" href="#sectionA" >MY ASSETS</a></li>
        </ul></center> 
     

        <div class="tab-content" id="myContent">
            <div id="sectionA" class="tab-pane fade in active">
            
                 <form class="form-inline" id="form-filter-assets" style="float:right;" >
                <div class="form-group" >
                <label style="color: #2a409f">Filters </label>
                    <select name="filter-assets" class="form-control" id="filter-assets" style="background: #fcf9f9" >
                            <option value="0" selected>All</option>
                            <option value="2">Given</option>
                            <option value="3">Assigned</option>
                            <option value="4">Returned</option>
                        </select>
                </div>
            </form> <br>
                <hr  >​
                <table class="table table-hover table-bordered table-condensed"  style="font-family: Montserrat ;" id="filterEmpAssetsData">
                   
                    <script type="text/javascript">
                      window.onload = function() {
                            var val=localStorage.getItem('filter-assets');
                            $.ajax({
                                                    url: "filterEmpAssets.php",
                                                    type: "POST",
                                                    data: "ACTION=getFilteredData&filter-assets="+val,
                                                    success: function(json){
                                                      $("#filterEmpAssetsData").append(json);
                                                                    
                                                    }
                                                 })
                                        
                                                              };
                    </script>
                    
                    <script type="text/javascript">
                       $(function() { 
                        
                       $('#filter-assets').change(function(){
                        $("#filterEmpAssetsData").empty();
                        var value;
                                        if($(this).val()=="0"){
                                            value="0";
                                        }else if($(this).val()=="2" ){
                                             value="2";
                                        }else if($(this).val()=="3"){
                                              value="3";
                                        }else if($(this).val()=="4"){
                                              value="4";
                                        }
                                         $.ajax({
                                                    url: "filterEmpAssets.php",
                                                    type: "POST",
                                                    data: "ACTION=getFilteredData&filter-assets="+value,
                                                    success: function(json){
                                                      $("#filterEmpAssetsData").append(json);
                                                                    
                                                    }
                                                 })
                                        
                                      });
                      });
                    </script>
                    </tbody>
                </table>
            </div>
            
     
           
        </div>
    </div>
</div>



    
</body>

    <script type="text/javascript">

    $(document).ready(function(){
                 // $("#empBars").load("empBars.html");

          document.getElementById("login_user_name").prepend(localStorage.getItem('name'));
              $("#expenses").click(function(e) {
            window.location.href="empExpenses.php";
          });
                $("#leaves").click(function(e) {
            window.location.href="empLeaves.php";
          });
                  $("#assets").click(function(e) {
            window.location.href="empAssets.php";
          });
                    $("#reportees").click(function(e) {
            window.location.href="empReportees.php";
          });

        
 
         if(localStorage.getItem('filter-assets')){
              $('#filter-assets').val(localStorage.getItem('filter-assets'));
          }

          $('#filter-assets').change(function(){
              localStorage.setItem('filter-assets',$('#filter-assets').val() );   
          });


          var userid=localStorage.getItem('user_id');
          $('#a').click(function() {
              localStorage.removeItem('filter-assets');
              window.location.href="userEntry.php";
          });

          $('#logout-button').click(function() {
              localStorage.removeItem('filter-assets');
              localStorage.removeItem('name');
              localStorage.removeItem('token');   
              localStorage.removeItem('email');
              localStorage.removeItem('user_id');
              localStorage.removeItem('activeEmpExpenseTabs');
              localStorage.removeItem('activeEmpLeavesTabs');
              localStorage.removeItem('activeCollapsibleTab');
              localStorage.removeItem('activeEmpReporteesTabs');
              localStorage.removeItem('filter2-employees');

          });

          $(function() { 
                       $('#filter-assets').change(function(){
                                        if($(this).val()=="0"){
                                            
                                        }else if($(this).val()=="1" ){
                                          
                                        }else if($(this).val()=="3"){
                                          
                                        }
                                      });
                     });
                            
    });

    function acceptUserAsset(invId){
        var r = confirm("Are you sure you want to accept this asset?");
                    if (r == true) {
                      var userId=localStorage.getItem('user_id');
                        $.ajax({
                                    url: "acceptUserAsset.php",
                                    type: "POST",
                                    data: "ACTION=accept&invId="+invId+"&userId="+userId,
                                    success: function(data){
                                        
                                        if(data=="1"){
                                          alert("Accepted");
                                            window.location.reload();
                                        }else if(data=="0"){
                                            alert("Not Accepted!");
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }
    }

    function returnAsset(invId){
        var r = confirm("Are you sure you want to return this asset?");
                    if (r == true) {
                        $.ajax({
                                    url: "returnAsset.php",
                                    type: "POST",
                                    data: "ACTION=return&invId="+invId,
                                    success: function(data){
                                        
                                     if(data=="1"){
                                          alert("Returned");
                                            window.location.reload();
                                        }else if(data=="0"){
                                            alert("Not Returned!");
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }
    }

   
    </script>
<!--<script type="text/javascript" src="empBars.js"></script>-->

</html>                                        