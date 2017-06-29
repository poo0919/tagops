<?php
include 'api/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Admin Profile</title>

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
<link rel="stylesheet" href="css/adminBars.css">
<link rel="stylesheet" href="css/empExpenses.css">
<script>
  $( function() {
    $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  $( function() {
    $( "#user_bday" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
  <style type="text/css">
    .btn{
      width: 72px;
      height: 25px;
      color: white;
    }
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
            <a class="navbar-brand" href="adminExpenseManagement.php" >
            <img src="images/logo.png" style="width:120px;height:45px;padding-bottom: 20px;margin-top: 0px;">
            </a>
        </div>
        
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
              <a class="dropdown-toggle" id="login_admin_name" data-toggle="dropdown" href="#" style="background-color: white; ">
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
              <li><a href="adminProfile.php">My Profile</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="api/logout.php" id="logout-button">Log Out</a></li>
              </ul>
          </li>
           
        </ul>
        <div id="sidebar-wrapper" class="sidebar-toggle">
            <div id="nav-menu">
                <div class="submenu" >
                    <div class="submenu-heading" id="expenses"><a href="adminExpenseManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Expenses.png" alt="expenses" >Expense Management</h5> </a></div>                   
                </div>
                <div class="submenu" >
                    <div class="submenu-heading " id="reportees" ><a href="adminEmployeeManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Reportees.png" alt="leaves" >Employee Management</h5></a> </div>                   
                </div>
                <div class="submenu" >
                    <div class="submenu-heading" id="assets"><a href="adminAssetsManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Assets.png" alt="assets" >Assets Management</h5></a> </div>                   
                </div>
                <div class="submenu" >
                    <div class="submenu-heading" id="leaves"><a href="adminLeaveManagement.php" style="text-decoration: none !important;color:#000000 ;"> <h5 class="submenu-title" ><img src="images/Leaves.png" alt="assets" >Leave Management</h5></a> </div>                   
                </div>
                <div class="submenu">
                  <div class="submenu-heading" id="manhours"><a href="adminManHoursManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title"><img src="images/Man-Hours.png" alt="manhours" >Man Hours Management</h5></a> </div>                   
                </div>
            </div>
            
        </div>
        
    </div>
</nav>
<div id="page-wrapper" class="container" >
    <div class="bs-example">
    <center>   <ul class="nav nav-pills" style="display:inline-block;" id="myTab" >
            <li class="active " ><a data-toggle="tab" href="#sectionA" >MY PROFILE</a></li>
        </ul></center> 
     

        <div class="tab-content" id="myContent">
            <div id="sectionA" class="tab-pane fade in active"><br>

              <div class="bs-example">
                  <form class="form-horizontal">
                      <div class="form-group">
                          <label for="inputEmail" class="control-label col-xs-2">Name</label>
                          <div class="col-xs-4">
                              <p class="form-control-static"><?php
                            include 'api/database.php';
                            $conn = getDB();
                              $user_id=$_SESSION['adminid'];
                            $sql="select * from user where id='$user_id'";
                            $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
                              if ($result->num_rows > 0) {
                                $row = $result->fetch_array();
                                echo $row['name'];
                              }
                        ?></p>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="inputEmail" class="control-label col-xs-2">Email</label>
                          <div class="col-xs-4">
                              <p class="form-control-static"><?php
                            echo $row['email'];
                        ?></p>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="user_bday" class="control-label col-xs-2">Birthday</label>
                          <div class="col-xs-3">
                              <input type="text" class="form-control" id="user_bday" name="user_bday" value="<?php
                        $birthday=$row['birthday'];
                            if(empty($birthday))
                              $birthday="empty";
                            echo $birthday;
                        ?>" readonly>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="phone_number" class="control-label col-xs-2">Phone Number</label>
                          <div class="col-xs-3">
                              <input type="number" class="form-control" id="phone_number" name="phone_number" value="<?php
                            $phone_number=$row['phone_number'];
                            if(empty($phone_number))
                              $phone_number="empty";
                            echo $phone_number;
                        ?>" readonly>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="personal_email" class="control-label col-xs-2">Personal Email</label>
                          <div class="col-xs-3">
                              <input type="text" class="form-control" id="personal_email" name="personal_email" value="<?php
                        $personal_email=$row['personal_email'];
                            if(empty($personal_email))
                              $personal_email="empty";
                            echo $personal_email;
                        ?>" readonly>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="joiningDate" class="control-label col-xs-2">Joining Date</label>
                          <div class="col-xs-4">
                              <p class="form-control-static"><?php
                                $joining_date=$row['joining_date'];
                                if($joining_date=="0000-00-00")
                                  $formattedJoiningDate="not added";
                                else{
                                  $dateCreated=date_create($joining_date);
                                  $formattedJoiningDate=date_format($dateCreated, 'd-m-Y');
                                }
                                echo $formattedJoiningDate; 
                              ?></p>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="inputEmail" class="control-label col-xs-2">Designation</label>
                          <div class="col-xs-4">
                              <p class="form-control-static"><?php
                        $designation=$row['designation'];
                            if(empty($designation))
                              $designation="not assigned";
                            echo $designation; 
                        ?></p>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="inputEmail" class="control-label col-xs-2">Reporting Manager</label>
                          <div class="col-xs-4">
                              <p class="form-control-static"><?php
                        $rm_id=$row['rm_id'];
                        $rm_name="";
                            if(empty($rm_id))
                              $rm_name="not assigned";
                            else{
                              $q1="SELECT name FROM user WHERE id='$rm_id'";
                              $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                              $ro1 = $re1->fetch_array();
                              $rm_name=$ro1['name'];
                            }
                            echo $rm_name;
                        ?></p>
                          </div>
                      </div>
                  </form>
              </div>    
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

        $("#assets").hover(
          function () {
            $(this).find('img').attr('src', 'images/Assets-W.png');
          }, 
          function () {
             $(this).find('img').attr('src', 'images/Assets.png');
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

      $('#page-wrapper').css('width',screen.width-280);
          document.getElementById("login_admin_name").prepend(localStorage.getItem('adminName'));
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

        var userId=localStorage.getItem('user_id');

        $("#phone_number").click(function()
        {
            $("#phone_number").prop('readonly', false);
        }).change(function()
        {
            var phone_number=$("#phone_number").val();
            var dataString = 'ACTION=changeEmpPhoneNumber&userId='+ userId +'&phoneNumber='+phone_number;

            if(phone_number.length>0 && phone_number.length==10)
            {
              $.ajax({
                type: "POST",
                url: "api/adminEmployeeManagementAPI.php",
                data: dataString,
                cache: false,
                success: function(data)
                {
                  if(data==1)
                  {
                      $("#phone_number").prop('readonly', true);
                  }  
                }
              });
            }
            else
            {
                alert('Either field is empty or Phone number is not 10 digit.');
            }

        });

        $("#user_bday").click(function()
        {
            $("#user_bday").prop('readonly', false);
        }).change(function()
        {
            var user_bday=$("#user_bday").val();
            var dataString = 'ACTION=changeEmpBirthday&userId='+ userId +'&birthday='+user_bday;

            $.ajax({
                type: "POST",
                url: "api/adminEmployeeManagementAPI.php",
                data: dataString,
                cache: false,
                success: function(data)
                {
                  if(data==1)
                  {
                      $("#phone_number").prop('readonly', true);
                  }else if(data==2){
                      alert("Field is empty!");
                  }  
                }
            });
            
        });


        $("#personal_email").click(function()
        {
            $("#personal_email").prop('readonly', false);
        }).change(function()
        {
           // var ID=$(this).attr('id');
            var personal_email=$("#personal_email").val();
            var dataString = 'ACTION=changeEmpPersonalEmail&userId='+userId +'&personalEmail='+personal_email;

            if(personal_email.length>0)
            {

            $.ajax({
                type: "POST",
                url: "api/adminEmployeeManagementAPI.php",
                data: dataString,
                cache: false,
                success: function(data)
                {
                  if(data==1)
                  {
                      $("#personal_email").prop('readonly', true);
                  }  
                }
            });
            }
            else
            {
                alert('Enter something.');
            }

        });

        $("#personal_email").mouseup(function() 
        {
        return false
        });

        $("#phone_number").mouseup(function() 
        {
        return false
        });
        $("#user_bday").mouseup(function() 
        {
        return false
        });

        $(document).mouseup(function()
        {
            $("#personal_email").prop('readonly', true);
            $("#phone_number").prop('readonly', true);
            $("#user_bday").prop('readonly', true);
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
</script>
</html>                                        