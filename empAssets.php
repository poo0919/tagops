<?php
include 'api/empSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Employee Panel</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="css/empBars.css">
  <link rel="stylesheet" href="css/empExpenses.css">

  <script>
    $(function(){
      $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
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
        <img src="images/logo.png" style="width:120px;height:45px;padding-bottom: 20px;margin-top: 0px;">
      </a>
    </div>
        
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" id="login_user_name" data-toggle="dropdown" href="#" style="background-color: white; ">
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="empProfile.php">My Profile</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="api/logout.php" id="logout-button" >Log Out</a></li>
        </ul>
      </li>
    </ul>
    
    <div id="sidebar-wrapper" class="sidebar-toggle">
      <div id="nav-menu">
        <div class="submenu">
          <div class="submenu-heading" id="expenses">
            <a href="empExpenses.php" style="text-decoration: none !important;color:#000000;"> 
              <h5 class="submenu-title" ><img src="images/Expenses.png" alt="expenses" >Expenses</h5>
            </a>
          </div>                   
        </div>
        <div class="submenu">
          <div class="submenu-heading" id="leaves">
            <a href="empLeaves.php" style="text-decoration: none !important;color:#000000;"> 
              <h5 class="submenu-title"><img src="images/Leaves.png" alt="leaves" >Leaves</h5>
            </a> 
          </div>                   
        </div>
        <div class="submenu" style="background: #373737;">
          <div class="submenu-heading" id="assets">
            <a href="empAssets.php" style="text-decoration: none !important;color:#ffffff;"> 
              <h5 class="submenu-title"><img src="images/Assets-W.png" alt="assets" >Assets</h5>
            </a> 
          </div>                   
        </div>
        <?php include_once('api/database.php');
                  $conn = getDB();
                  $user_id=$_SESSION['userid'];
                  if(!empty($user_id)){
                        $sql = "SELECT * FROM user WHERE rm_id='$user_id'";  //fetching RM details
                        $mgrResult=mysqli_query($conn,$sql)or die(mysqli_error($conn));
                        $flag=0;
                        if ($mgrResult->num_rows > 0) {
                            while($rowResult = $mgrResult->fetch_array()){
                               $flag=1;
                            }
                        }
                        if($flag==1){
                          ?>
                            <div class="submenu">
                                <div class="submenu-heading" id="reportees"><a href="empReportees.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" id="reportees"><img src="images/Reportees.png" alt="reportees" >Reportees</h5></a> </div>                   
                            </div>

                          <?php
                        }
                  }
                ?>
        <div class="submenu">
          <div class="submenu-heading" id="manhours">
            <a href="empManHours.php" style="text-decoration: none !important;color:#000000;"> 
              <h5 class="submenu-title"><img src="images/Man-Hours.png" alt="manhours" >Man Hours</h5>
            </a>
          </div>                   
        </div>
      </div>
    </div>

  </div>
</nav>


<div id="page-wrapper" class="container" >
  <div class="bs-example">
    <center>   
      <ul class="nav nav-pills" style="display:inline-block;" id="myTab" >
        <li class="active " ><a data-toggle="tab" href="#myAssets" >MY ASSETS</a></li>
      </ul>
    </center> 
    
    <div class="tab-content" id="myContent">

      <div id="myAssets" class="tab-pane fade in active">

        <form class="form-inline" id="form-filter-assets" style="float:left;" >
          <div class="form-group" >
            <label style="color: #2a409f">Filters </label>
            <select name="filter-assets" class="form-control" id="filter-assets" style="background: #fcf9f9" >
              <option value="0" selected>All</option>
              <option value="2">Given</option>
              <option value="3">Assigned</option>
              <option value="4">Returned</option>
            </select>
          </div>
        </form> 
       <hr  >​
        
        <table class="table table-hover table-bordered table-condensed"  style="font-family: Montserrat ;" id="filterEmpAssetsData">
        <script type="text/javascript">
          window.onload = function() {
            var val=localStorage.getItem('filter-assets');
              $.ajax({
                url: "api/empAssetsAPI.php",
                type: "POST",
                data: "ACTION=getFilteredData&filter-assets="+val,
                success: function(json){
                  $("#filterEmpAssetsData").append(json);
                }
              })
          };
        
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
                  url: "api/empAssetsAPI.php",
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
    $("#leaves").hover(
      function () {
        $(this).find('img').attr('src', 'images/Leaves-W.png');
      }, 
      function () {
        $(this).find('img').attr('src', 'images/Leaves.png');
      }
    );
    $("#expenses").hover(
      function () {
        $(this).find('img').attr('src', 'images/Expenses-W.png');
      }, 
      function () {
        $(this).find('img').attr('src', 'images/Expenses.png');
      }
    );
    $("#reportees").hover(
      function () {
        $(this).find('img').attr('src', 'images/Reportees-W.png');
      }, 
      function () {
        $(this).find('img').attr('src', 'images/Reportees.png');
      }
    );
    $("#manhours").hover(
      function () {
        $(this).find('img').attr('src', 'images/Man-Hours-W.png');
      }, 
      function () {
        $(this).find('img').attr('src', 'images/Man-Hours.png');
      }
    );

    var userid=localStorage.getItem('user_id');
    document.getElementById("login_user_name").prepend(localStorage.getItem('name')); 

    if(localStorage.getItem('filter-assets')){
      $('#filter-assets').val(localStorage.getItem('filter-assets'));
    }
    $('#filter-assets').change(function(){
      localStorage.setItem('filter-assets',$('#filter-assets').val() );   
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
  });

  function acceptUserAsset(invId){
    var r = confirm("Are you sure you want to accept this asset?");
    if (r == true) {
      var userId=localStorage.getItem('user_id');
      $.ajax({
        url: "api/empAssetsAPI.php",
        type: "POST",
        data: "ACTION=accept&invId="+invId+"&userId="+userId,
        success: function(response){
          var data=$.trim(response);
          if(response.success==true){
            console.log("send asset email: "+JSON.stringify(response));
            alert("Asset Accepted");
            window.location.reload();
          }else if(data=="0"){
            alert("Not Accepted!");
          }else if(data=="5"){
            alert("Set System Admin First!");
          }
        }
      })
    }              
  }

  function rejectUserAsset(invId){
    var r = confirm("Are you sure you want to reject this asset?");
    if (r == true) {
      var userId=localStorage.getItem('user_id');
      $.ajax({
        url: "api/empAssetsAPI.php",
        type: "POST",
        data: "ACTION=reject&invId="+invId+"&userId="+userId,
        success: function(response){
          var data=$.trim(response);
          if(response.success==true){
            console.log("send asset email: "+JSON.stringify(response));
            alert("Asset Rejected");
            window.location.reload();
          }else if(data=="0"){
            alert("Not Rejected!");
          }else if(data=="5"){
            alert("Set System Admin First!");
          }
        }
      })
    }              
  }

  function returnAsset(invId){
    var r = confirm("Are you sure you want to return this asset?");
    if (r == true) {
      $.ajax({
        url: "api/empAssetsAPI.php",
        type: "POST",
        data: "ACTION=return&invId="+invId,
        success: function(response){
          var data=$.trim(response);
          if(response.success==true){
            console.log("send asset email: "+JSON.stringify(response));
            alert("Asset Returned");
            window.location.reload();
          }else if(data=="0"){
            alert("Not Returned!");
          }else if(data=="5"){
            alert("Set System Admin First!");
          }
        }
      })
    }                
  }
</script>
</html>                                        