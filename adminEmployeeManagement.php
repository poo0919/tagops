<?php
include_once('api/database.php');
$conn = getDB();
include 'api/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Admin Panel</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="css/adminBars.css">
    <link rel="stylesheet" href="css/empExpenses.css">
    <link rel="stylesheet" href="css/editable.css">
   <style type="text/css">
     .btn-xs{
        height:22px ;
        width:55px ;
      }
      .btn-round {
        width: 40px;
        height: 40px;
        border-radius: 50%;
      }
      .btn-round.btn-sm {
        width: 34px;
        height: 34px;
      }
      .icon-size{  
        font-size:2em;
      }
   </style>

<script>
  $( function() {
    $( "#joiningDate" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#joiningDate1" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>

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
                <li><a href="api/logout.php" id="logout-button" >Log Out</a></li>
              </ul>
          </li>
           
        </ul>
        <div id="sidebar-wrapper" class="sidebar-toggle">
            <div id="nav-menu">
                <div class="submenu" >
                    <div class="submenu-heading" id="expenses"><a href="adminExpenseManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Expenses.png" alt="expenses" >Expense Management</h5> </a></div>                   
                </div>
                <div class="submenu" style="background: #373737;">
                    <div class="submenu-heading " id="reportees" ><a href="adminEmployeeManagement.php" style="text-decoration: none !important;color:#ffffff;"> <h5 class="submenu-title" ><img src="images/Reportees-W.png" alt="leaves" >Employee Management</h5></a> </div>                   
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

    
<div id="page-wrapper" class="container">
    <div class="bs-example">
    <center>   <ul class="nav nav-pills" style="display:inline-block;" id="adminEmployeeManagementTabs" >
            <li class="active " ><a data-toggle="tab" href="#EmployeesTab" >Employees</a></li>
            <li ><a data-toggle="tab" href="#PermissionsTab" >Permissions</a></li>
        </ul></center> 

        <div class="tab-content" id="myContent">
            <div id="EmployeesTab" class="tab-pane fade in active">
             
             <form class="form-inline"  id="form-filter-emp" style="float:left;" >
                    <div class="form-group" >
                    <label style="color: #2a409f;">Status </label>
                        <select name="filter-master-employees" class="form-control" id="filter-master-employees" style="background: #fcf9f9;" >
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                            <option value="all" >All</option>
                        </select>                
                    </div>
                </form>
               <!-- <span class="glyphicon glyphicon-download" style="float: right;"></span>-->

              <button style="float: right;background:#2a409f;color: #ffffff;" type='button' class='btn' data-toggle='modal' data-target='#exampleModal2' ><span class='glyphicon glyphicon-plus' style="color: #ffffff;" ></span> Add Employee</button>
              <a href="api/exportEmployeeRecords.php" download> <span class="glyphicon glyphicon-download icon-size" style="float: right;margin-right: 5px;color:#2a409f ;"></span></a>
              <!--  <button type="button" class="btn btn-info btn-sm" style="float: right;margin-right: 5px;" id="mailButton"> mail</button>  -->
               
                <hr  >​
                <table class="table table-bordered table-hover table-condensed" id="employeeDetailsTable" >
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Name</th>
                      <th>Designation</th>
                      <th>Phone Number</th>
                      <th>Company Email</th>
                      <th>Personal Email</th>
                      <th>RM</th>
                      <th>Joining Date</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!isset($_GET['filter-master-employees']) || $_GET['filter-master-employees']=='1' ){ 
                        
                        $query="Select * from user where status='1' order by name";
                          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                                  $status=$row1['status'];
                                  $rm_id=$row1['rm_id'];
                                  $personal_email=$row1['personal_email'];
                                  if(empty($personal_email))
                                    $personal_email="empty";
                                  $phone_number=$row1['phone_number'];
                                  if(empty($phone_number))
                                    $phone_number="empty";
                                  $designation=$row1['designation'];
                                  if(empty($designation))
                                    $designation="not assigned";

                                  $rm_name="";
                                  $rm_mail="";
                                  if(empty($rm_id))
                                    $rm_name="not assigned";
                                  else{
                                        $q1="SELECT name,email FROM user WHERE id='$rm_id'";
                                        $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $ro1 = $re1->fetch_array();
                                        $rm_name=$ro1['name'];
                                        $rm_mail=$ro1['email'];
                                    }

                                    if(empty($status)){
                                        $status="Inactive";
                                        $bckColor="#ec585d";
                                    }else{
                                        $status="Active";
                                        $bckColor="#7cc576";
                                    }

                                    $joining_date=$row1['joining_date'];
                                    if($joining_date=="0000-00-00")
                                      $formattedJoiningDate="not added";
                                    else{
                                      $dateCreated=date_create($joining_date);
                                      $formattedJoiningDate=date_format($dateCreated, 'd-m-Y');
                                 
                                    }

                                    echo "<tr><td>".$index.".</td>
                                    <td >".$row1['name']."</td>
                                    <td >".$designation."</td>
                                    <td >".$phone_number."</td>
                                    <td >".$row1['email']."</td>
                                    <td >".$personal_email."</td>
                                    <td >".$rm_name."</td>
                                    <td >".$formattedJoiningDate."</td>
                                    <td> 
                                    <span class='glyphicon glyphicon-pencil' id='editbtn".$index."' data-toggle='modal' data-target='#exampleModal1' onclick='modalFunction1()' data-name='".$row1['name']."' data-joiningdate='".$row1['joining_date']."' data-id='".$row1['id']."' data-designation='".$designation."' data-companymail='".$row1['email']."' data-rm='".$rm_name."' data-rm_mail='".$rm_mail."'  style='color: #2a409f;cursor:pointer;'>Edit</span>&nbsp;&nbsp;<button onclick=removeUser(".$row1['id'].") class='btn btn-xs' id='remove".$index."' style='color:#ffffff;background:".$bckColor.";'> ".$status."</button></td>
                                    </tr>";

                                    $index++;
                              }
                          }
                }else {

                    $filter=$_GET['filter-master-employees'];
                    $query="";
                    if($filter=='0'){
                        $query.="Select * from user where status='0' order by name";
                    }else if($filter=='all'){
                        $query.="Select * from user order by name";
                    }

                    $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                                  $status=$row1['status'];
                                  $rm_id=$row1['rm_id'];
                                  $personal_email=$row1['personal_email'];
                                  if(empty($personal_email))
                                    $personal_email="empty";
                                  $phone_number=$row1['phone_number'];
                                  if(empty($phone_number))
                                    $phone_number="empty";
                                  $designation=$row1['designation'];
                                  if(empty($designation))
                                    $designation="not assigned";

                                  $rm_name="";
                                  $rm_mail="";
                                  if(empty($rm_id))
                                    $rm_name="not assigned";
                                  else{
                                        $q1="SELECT name,email FROM user WHERE id='$rm_id'";
                                        $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $ro1 = $re1->fetch_array();
                                        $rm_name=$ro1['name'];
                                        $rm_mail=$ro1['email'];
                                    }

                                    if(empty($status)){
                                        $status="Inactive";
                                        $bckColor="#ec585d";
                                    }else{
                                        $status="Active";
                                        $bckColor="#7cc576";
                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                    echo "<tr><td >".$index.".</td>
                                    <td >".$row1['name']."</td>
                                    <td >".$designation."</td>
                                    <td >".$phone_number."</td>
                                    <td >".$row1['email']."</td>
                                    <td >".$personal_email."</td>
                                    <td >".$rm_name."</td>
                                    <td >".$row1['joining_date']."</td>
                                    <td> 
                                    <span class='glyphicon glyphicon-pencil' id='editbtn".$index."' data-toggle='modal' data-target='#exampleModal1' onclick='modalFunction1()' data-name='".$row1['name']."' data-joiningdate='".$row1['joining_date']."' data-id='".$row1['id']."' data-designation='".$designation."' data-companymail='".$row1['email']."' data-rm='".$rm_name."' data-rm_mail='".$rm_mail."'  style='color: #2a409f;cursor:pointer;'>Edit</span>&nbsp;&nbsp;<button onclick=removeUser(".$row1['id'].") class='btn btn-xs' id='remove".$index."' style='color:#ffffff;background:".$bckColor.";'> ".$status."</button></td>
                                    </tr>";

                                    $index++;
                              }
                          }
                      }
                    ?>
                    </tbody>
                </table>

                <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel1">Upadate Details </h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="api/adminEmployeeManagementAPI.php">
                                    <div class="form-group">
                                        <label for="oldName" class="control-label">Name:</label>
                                        <input type="text" class="form-control" id="oldName" name="oldName" >
                                    </div>
                                    <div class="form-group">
                                        <label for="joiningDate1" class="control-label">Joining Date:</label>
                                        <input type="text" class="form-control" id="joiningDate1" name="joiningDate1" >
                                    </div>
                                    <div class="form-group">
                                        <label for="designation" class="control-label">Designation:</label>
                                        <input type="text" class="form-control" id="designation" name="designation" >
                                    </div>
                                    <div class="form-group">
                                        <label for="companymail" class="control-label">Company Email:</label>
                                        <input type="text" class="form-control" id="companymail" name="companymail" >
                                    </div><br>
                                    <label class="control-label">Details of RM:</label>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                        <label for="repMgr" class="control-labelcol-sm-2">Name:</label>
                                        <input type="text" class="form-control col-sm-4" id="repMgr" name="repMgr" readonly>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="repMgrMail" class="control-label">Email:</label>
                                        <input type="email" class="form-control" id="repMgrMail" name="repMgrMail" >
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="id">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="ACTION" id="ACTION" value="updateEmployeeDetails">
                                    </div>
                                    <button type="button-inline" id="submit" class="btn btn-primary" name="submit" value="submit">Update</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel2">New Employee</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal">
                                    <div class="form-group ">
                                        <label for="newName" class="control-label col-sm-3">Name:</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control " id="newName" name="newName" >
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="joiningDate" class="control-label col-sm-3">Joining Date:</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control " id="joiningDate" name="joiningDate" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="companyMail" class="control-label col-sm-3"> Email:</label>
                                        <div class="col-sm-8">
                                        <input type="email" class="form-control" id="companyMail" name="companyMail" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="designation1" class="control-label col-sm-3">Designation:</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="designation1" name="designation1" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="rmMail" class="control-label col-sm-3">RM:</label>
                                        <div class="col-sm-8">
                                        <select class="form-control " id="rmMail" name="rmMail">
                                            <option value="0">----select email-id----</option>
                                                <?php
                                                    $query = "SELECT * FROM user where status='1' order by email";
                                                    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                                    while ($rows = mysqli_fetch_array($result)) {
                                                        echo "<option value=" .$rows['id']. ">" .$rows['email']. "</option>";
                                                    }
                                                ?>     
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="id">
                                    </div>
                                     <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-10">
                                    <button type="button-inline" id="addNewEmployeeButton" class="btn btn-primary" name="addNewEmployeeButton" >Add</button>
                                    </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            <script type="text/javascript">
                function modalFunction1(){
                     $("#exampleModal1").on("show.bs.modal", function (event){
                          var button = $(event.relatedTarget);
                          var name = button.data('name');
                          var id = button.data('id');

                          var modal = $(this);
                          modal.find('.modal-title').text('Update details of ' + name);
                
                         $('#exampleModal1').find('input#id').val($(event.relatedTarget).data('id'));
                         $('#exampleModal1').find('input#repMgr').val($(event.relatedTarget).data('rm'));
                         $('#exampleModal1').find('input#designation').val($(event.relatedTarget).data('designation'));
                         $('#exampleModal1').find('input#companymail').val($(event.relatedTarget).data('companymail'));
                         $('#exampleModal1').find('input#repMgrMail').val($(event.relatedTarget).data('rm_mail'));
                         $('#exampleModal1').find('input#oldName').val($(event.relatedTarget).data('name'));
                         $('#exampleModal1').find('input#joiningDate1').val($(event.relatedTarget).data('joiningdate'));
                         
                     });
                     
                }
            </script>
            
        </div>

        <div id="PermissionsTab" class="tab-pane fade">
                <hr  >​

            <div class="col-sm-12">
              <div class="col-sm-6">
                <center>   <h3> HR</h3>
                <form class="form-horizontal ">
                  <div class="form-group">
                    <label for="currentHR" class="control-label col-sm-5 ">Current HR</label>
                    <div class=" col-sm-6">
                      <p class="form-control-static">
                      <?php
                        $sql="select name from user where hr='1'";
                        $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
                        if ($result->num_rows > 0) {
                          $row = $result->fetch_array();
                          echo $row['name'];
                        }
                      ?></p>
                    </div>
                  </div>
                </form>

                <form class="form-inline col-sm-10"   id="hrForm" >
                <div class="input-group" >
                  <select class="form-control " id="hrEmail">
                    <option value="0">----select email-id----</option>
                      <?php
                        $query = "SELECT * FROM user where status='1' order by email";
                        $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                        while ($rows = mysqli_fetch_array($result)) {
                          echo "<option value=" .$rows['id']. ">" .$rows['email']. "</option>";
                        }
                      ?>     
                  </select>
                  <span class="input-group-btn">
                    <button class="btn btn-default" id="new-hr-user" style="color:#2a409f !important;"><span class="glyphicon glyphicon-plus" style="color:#2a409f !important;"></span>&nbsp;Add as HR</button>
                  </span>
                </div>
                </form></center>

                <br><br><br><br>

                 <center>   <h3> SYSTEM ADMIN</h3>
                  <form class="form-horizontal ">
                    <div class="form-group">
                      <label for="currentSystemAdmin" class="control-label col-sm-5 ">Current SYSTEM ADMIN</label>
                      <div class=" col-sm-6">
                        <p class="form-control-static">
                        <?php
                          $sql="select name from user where system_admin='1'";
                          $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
                          if ($result->num_rows > 0) {
                            $row = $result->fetch_array();
                            echo $row['name'];
                          }
                        ?></p>
                      </div>
                    </div>
                  </form>

                <form class="form-inline col-sm-10"   id="systemAdminForm" >
                <div class="input-group" >
                  <select class="form-control " id="systemAdminEmail">
                    <option value="0">----select email-id----</option>
                    <?php
                      $query = "SELECT * FROM user where status='1' order by email";
                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                      while ($rows = mysqli_fetch_array($result)) {
                        echo "<option value=" .$rows['id']. ">" .$rows['email']. "</option>";
                      }
                    ?>     
                  </select>
                  <span class="input-group-btn">
                    <button class="btn btn-default" id="new-systemAdmin-user" style="color:#2a409f !important;"><span class="glyphicon glyphicon-plus" style="color:#2a409f !important;"></span>&nbsp;Add as SYSTEM ADMIN</button>
                  </span>
                </div>
                </form></center>
               
                </div>
            <div class="col-sm-6">
                <center>   <h3> ADMINS</h3></center>
                  <form class="form-horizontal ">
                    <?php
                      $sql="select id,name from user where (type='1')";
                      $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
                      $index=1;
                      if ($result->num_rows > 0) {
                        while(  $row = mysqli_fetch_array($result)){
                          echo" <div class='form-group'>
                                <label for='currentHR' class='control-label col-sm-2'>".$index.".</label>
                                <div class='col-sm-5'>
                                    <p class='form-control-static'>";
                          echo $row['name'];
                          echo "</p> </div>
                                <div class='col-sm-2'><span class='glyphicon glyphicon-remove-sign' style='cursor:pointer;' onclick='removeFromAdmin(".$row['id'].")'></span></div>
                                </div>";
                          $index++;
                        }
                      }
                    ?>
                  </form>
                <form class="form-inline col-sm-10"   id="admnForm" >
                  <div class="input-group" >
                    <select class="form-control " id="admnEmail">
                      <option value="0">----select email-id----</option>
                        <?php
                          $query = "SELECT * FROM user where status='1' order by email";
                          $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                          while ($rows = mysqli_fetch_array($result)) {
                            echo "<option value=" .$rows['id']. ">" .$rows['email']. "</option>";
                          }
                        ?>     
                    </select>
                    <span class="input-group-btn">
                      <button class="btn btn-default" id="new-admn-user" style="color:#2a409f;"><span class="glyphicon glyphicon-plus" style="color:#2a409f;"></span>&nbsp;Add as ADMIN</button>
                    </span>
                  </div>
                </form>
                </center>
            </div>
            </div>
            <!-- form for adding new Admin -->
        </div>
    </div>
</div>
    
<script type="text/javascript">

$(document).ready(function(){
  document.getElementById("login_admin_name").prepend(localStorage.getItem('adminName'));
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
  $("#manhours").hover(
    function () {
      $(this).find('img').attr('src', 'images/Man-Hours-W.png');
    }, 
    function () {
      $(this).find('img').attr('src', 'images/Man-Hours.png');
    }
  );
       
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeEmployeeMgmtTabs', $(e.target).attr('href'));
  });
  var activeEmployeeMgmtTabs = localStorage.getItem('activeEmployeeMgmtTabs');
  if(activeEmployeeMgmtTabs){
    $('#adminEmployeeManagementTabs a[href="' + activeEmployeeMgmtTabs + '"]').tab('show');
  }
  if(localStorage.getItem('filter-master-employees')){
    $('#filter-master-employees').val(localStorage.getItem('filter-master-employees'));
  }
  $('#filter-master-employees').change(function(){
    localStorage.setItem('filter-master-employees',$('#filter-master-employees').val() );
    window.location.href="adminEmployeeManagement.php?filter-master-employees="+$('#filter-master-employees').val();
  });

  $(".edit_td").click(function()
  {
      var ID=$(this).attr('id');
      $("#first_"+ID).css("display","none")
      $("#first_input_"+ID).css("display","block")
  }).change(function()
  {
      var ID=$(this).attr('id');
      var first=$("#first_input_"+ID).val();
      //var dataString = 'id='+ ID +'&first='+first;

      if(first.length>0)
      {
          window.location.href= "adminExpenseManagement.php?id="+ID+"&newProjName="+first+"&renameProj=rename";
      }
      else
      {
          alert('Enter something.');
      }
  });

  // Edit input box click action
  $(".editbox").mouseup(function() 
  {
    return false
  });

  $(document).mouseup(function()
  {
    $(".editbox").css("display","none")
    $(".text").css("display","block")
  });

  $("#addNewEmployeeButton").click(function(e) {
    e.preventDefault();               
    var newName = $("#newName").val();   
    var companyMail = $("#companyMail").val();
    var designation1 = $("#designation1").val();
    var rmMail = $("#rmMail").val();
    var joiningDate = $("#joiningDate").val();
    
    $.ajax({
      url: "api/adminEmployeeManagementAPI.php",
      type: "POST",
      data: "ACTION=addNewEmployee&newName="+newName+"&companyMail="+companyMail+"&designation1="+designation1+"&rmMail="+rmMail+"&joiningDate="+joiningDate,
      success: function(response){
        var data=$.trim(response);
        console.log(data);
        if(data=='0') {
          alert("Empty Fields");
        }else if(response.success==true){
          console.log("send email: "+JSON.stringify(response));
          alert("Employee Added.");
          window.location.reload();
        }else if(response.success==false){
          alert(response.message);
        }
      }
    })
  });

  $("#new-hr-user").click(function(e) {
    e.preventDefault();               
    var email = $("#hrEmail").val();   
    if ( email == '') {
      alert("Please fill all fields...!!!!!!");
    }else {
      $.ajax({
        url: "api/adminEmployeeManagementAPI.php",
        type: "POST",
        data: "ACTION=addHR&id="+email,
        success: function(response){
          var data=$.trim(response);
          console.log(data);
          if(data=='1'){
            $('#hrForm')[0].reset();
            alert("HR added");
            window.location.reload();
          }else {
            $('#hrForm')[0].reset();
            alert("Already an HR!");
          }
        }
      })
    }                 
  }); 

  $("#new-systemAdmin-user").click(function(e) {
    e.preventDefault();               
    var email = $("#systemAdminEmail").val();   
    if ( email == '') {
      alert("Please fill all fields...!!!!!!");
    }else {
      $.ajax({
        url: "api/adminEmployeeManagementAPI.php",
        type: "POST",
        data: "ACTION=addSystemAdmin&id="+email,
        success: function(response){
          var data=$.trim(response);
          console.log(data);
          if(data=='1'){
            $('#systemAdminForm')[0].reset();
            alert("System Admin added");
            window.location.reload();
          }else {
            $('#systemAdminForm')[0].reset();
            alert("Already an System Admin!");
          }
        }
      })
    }                 
  }); 

  $("#new-admn-user").click(function(e) {
    e.preventDefault();               
    var email = $("#admnEmail").val();   
    if ( email == '') {
      alert("Please fill all fields...!!!!!!");
    }else {
      $.ajax({
        url: "api/adminEmployeeManagementAPI.php",
        type: "POST",
        data: "ACTION=addAdmn&id="+email,
        success: function(response){
          var data=$.trim(response);
          console.log(data);
          if(data=='1'){
            $('#admnForm')[0].reset();
            alert("admin added");
            window.location.reload();
          }else {
            $('#admnForm')[0].reset();
            alert("Already an admin!");
          }
        }
      })
    }                 
  });


  $('#logout-button').click(function(e){
      localStorage.removeItem('activeExpenseMgmtTabs');
      localStorage.removeItem('activeEmployeeMgmtTabs');
      localStorage.removeItem('activeAssetMgmtTabs');
      localStorage.removeItem('activeLeaveMgmtTabs');
      localStorage.removeItem('filter-projects');
      localStorage.removeItem('filter-employees');
      localStorage.removeItem('filterAssetsAdmin');
      localStorage.removeItem('filterAssetType');
      localStorage.removeItem('filter1-assets');
      localStorage.removeItem('filter2-assets');
      localStorage.removeItem('filter3-assets');
      localStorage.removeItem('filter-master-projects');
      localStorage.removeItem('filter-master-employees');
      localStorage.removeItem('filter-master-expense-categories');
      localStorage.removeItem('filter-master-assets');
  });

      localStorage.removeItem('filter-projects');
      localStorage.removeItem('filter-employees');
      localStorage.removeItem('filter-master-employees');
      localStorage.removeItem('filter-master-assets');

});

 function removeUser(id){
    var r = confirm("Are you sure you want activate/deactivate this user?");
    if (r == true) {
      $.ajax({
        url: "api/adminEmployeeManagementAPI.php",
        type: "POST",
        data: "ACTION=changeStatusOfUser&id="+id,
        success: function(data){
          if(data=='1'){
            window.location.href = window.location.href;
          }
        }
      })
    }          
  }

  function removeFromAdmin(id){
    var r = confirm("Are you sure you want remove this from admin?");
    if (r == true) {
      $.ajax({
        url: "api/adminEmployeeManagementAPI.php",
        type: "POST",
        data: "ACTION=removeAdmin&id="+id,
        success: function(data){
          if(data=='1'){
            alert("Removed from admin!");
              window.location.href = window.location.href;
            }else if(data=='0'){
              alert("Admin Can't be less than ONE!");
            }
          }
        })
      }
    }
</script>
     

   
  </body>
</html>