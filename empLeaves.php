<?php
include 'empSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Employee Leaves - TagOps</title>

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
</style>
<script>
  $( function() {
    $( "#forDate1" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#forDate2" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#forDate3" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#forDate4" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#forDate5" ).datepicker({ dateFormat: 'yy-mm-dd' });
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
            <a class="navbar-brand" href="empExpenses.php" >
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
                    <div class="submenu-heading " id="leaves" > <h5 class="submenu-title" id="leaves"><img src="Leaves.png" alt="leaves" >Leaves</h5> </div>                   
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
            <li class="active " ><a data-toggle="tab" href="#leaveRecordsTab" >LEAVE RECORDS</a></li>
            <li><a data-toggle="tab" href="#leaveStatusTab" id="ref_B">LEAVE STATUS</a></li>
            <li><a data-toggle="tab" href="#applyLeavesTab" id="ref_C">APPLY LEAVES</a></li>
        </ul></center> 
     <br><br>

        <div class="tab-content" id="myContent">
            <div id="leaveRecordsTab" class="tab-pane fade in active">
            
               <?php
               include 'connection.php';
               $user_id=$_SESSION['userid'];
                                           $query="Select * from leave_data where user_id='$user_id' AND (status='1' || status='2' || status='4' || status='6') order by for_date DESC";
                                           $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                           if ($result->num_rows > 0) {
                                               
                                                $inc = 1;
                                                $tableRows = array();

                                            ?>
                                            <table  class="table table-hover table-condensed table-bordered" >
                                                <thead>
                                                    <tr>
                                                        <th>S.No.</th>
                                                        <th>Leave Type</th>
                                                        <th>Half/Full</th>
                                                        <th>Leave Date</th>
                                                        <th>Against Date</th>
                                                        <th>Reason</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <?php
                                                while ($row = $result->fetch_array()){

                                                  $type="";
                                                  $againstDate="";
                                                  $reason="";
                                                  $status="";

                                                  $dateCreated1=date_create($row['for_date']);
                                                  $formattedForDate1=date_format($dateCreated1, 'd-m-Y');
                                                    

                                                  if($row['type_id']=="1"){
                                                    $type="CL+PL+ML";
                                                    $formattedAgainstDate2="NA";
                                                  //  $reason="NA";
                                                  }else if($row['type_id']=="2"){
                                                    $type="Comp Off";
                                                    $againstDate=$row['against_date'];
                                                    $dateCreated2=date_create($againstDate);
                                                    $formattedAgainstDate2=date_format($dateCreated2, 'd-m-Y');
                                                  //  $reason=$row['reason'];
                                                  }else if($row['type_id']=="3"){
                                                    $type="RH";
                                                    $formattedAgainstDate2="NA";
                                                  //  $reason="NA";
                                                  }

                                                  $reason=$row['reason'];
                                                  $statusNum=$row['status'];
                                                  $statusColor="";
                                                  if($statusNum=='1'){
                                                      $status="Applied";
                                                      $statusColor="#71D3f4";
                                                  }else if ($statusNum=='2') {
                                                      $status="Approved";
                                                      $statusColor="#7cc576";
                                                  }else if ($statusNum=='4') {
                                                      $status="Used";
                                                      $statusColor="#ec585d";
                                                  }else if ($statusNum=='6') {
                                                      $status="Rejected";
                                                      $statusColor="#fea862";
                                                  }

                                                  if(empty($row['half_full']))
                                                    $row['half_full']="NA";


                                                  echo "<tr>
                                                        <td>".$inc.".</td>
                                                        <td>".$type."</td>
                                                        <td>".$row['half_full']."</td>
                                                        <td>".$formattedForDate1."</td>
                                                        <td>".$formattedAgainstDate2."</td>
                                                        <td>".$reason."</td>
                                                        <td style='color:".$statusColor."'>".$status."</td>
                                                  </tr>";

                                                
                                                    

                                                   
                                                    $inc++;    
                                                }
                                                ?></tbody></table> <?php
                                                                                                
                                           }
                                    ?>
               
            </div>
            
     
            <div id="leaveStatusTab" class="tab-pane fade"><center>
           
            <table class="table table-hover table-bordered table-condensed"  style="font-family: Montserrat ;"  >
                                
                                <?php
                                   include 'connection.php';
                              $user_id=$_SESSION['userid'];

                                            $q2="select * from leaves where user_id='$user_id'";
                                            $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            if ($re2->num_rows > 0) {
                                              ?>
                                              <thead>
                                                <tr>
                                                  <th>Leaves Pending
                                                  (CL+PL+ML)</th>
                                                  <th>Comp Off given</th>
                                                  <th>Registered Holiday Pending</th>
                                                  <th>Total Leaves Pending</th>              
                                                </tr>
                                              </thead>

                                              <tbody>
                                              <?php
                                                while($ro2 = $re2->fetch_array()){
                                                          //pl cl leaves table
                                                          $total=$ro2['pl_cl_ml']+$ro2['comp_off']+$ro2['rh'];
                                                  echo  " <tr  >
                                                            <td>".$ro2['pl_cl_ml']."</td>
                                                            <td>".$ro2['comp_off']."</td>
                                                            <td>".$ro2['rh']."</td>
                                                            <td>".$total."</td>
                                                          </tr> ";
                                                }
                                            }else{
                                              echo "No entry in this table!";
                                            }
?>
                                  </tbody>
                                  </table><br>

                        <table class="table table-hover table-bordered table-condensed"  style="font-family: Montserrat ;"  >
                        
                                         <?php
                                            $q3="select * from leave_data where user_id='$user_id' AND type_id='2' order by against_date DESC ";
                                            $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                            if ($re3->num_rows > 0) {
                                              $index=1;
                                              ?>
                                              <caption><center style="font-family: Montserrat  ;color: #373737;"> Comp Off Leaves Status </center></caption>
                                              <thead>
                                                <tr>
                                                  <th>S.no</th>
                                                  <th>Against Date</th>
                                                  <th>Expiry Date</th>
                                                  <th>Reason</th>
                                                  <th>Status</th>             
                                                </tr>
                                              </thead>

                                              <tbody>
                                              <?php
                                                while($ro3 = $re3->fetch_array()){
                                                          //comp off table
                                                      $textColor="";
                                                      if($ro3['status']=="3"){
                                                          $status="Available";
                                                          $textColor="#7cc576";
                                                      }else if($ro3['status']=="4"){
                                                          $status="Used";
                                                          $textColor="#ec585d";
                                                      }else if($ro3['status']=="5"){
                                                          $status="Expired";
                                                          $textColor="#fea862";
                                                      }else if($ro3['status']=="1"){
                                                                $status="Applied";
                                                                $textColor="#71D3f4";
                                                      }

                                                      $dateCreated1=date_create($ro3['against_date']);
                                                      $formattedDate1=date_format($dateCreated1, 'd-m-Y');
                                                      $dateCreated2=date_create($ro3['expiry_date']);
                                                      $formattedDate2=date_format($dateCreated2, 'd-m-Y');

                                                    echo  " <tr>
                                                              <td>".$index."</td>
                                                              <td>".$formattedDate1."</td>
                                                              <td>".$formattedDate2."</td>
                                                              <td>".$ro3['reason']."</td>
                                                              <td style='color:".$textColor."'>".$status."</td>
                                                            </tr> ";


                                                       $index++;
                                                }
                                            }else{
                                              echo "No comp off given!";
                                            }

                                          echo    " </tbody>
                                                    </table>
                                                    ";

                                ?>
                                </tbody>
                              </table>

                         
                              
<br><br>
            </div>
            <div id="applyLeavesTab" class="tab-pane fade">

                <table class="table table-hover table-bordered table-condensed"  style="font-family: Montserrat ;"  >
                        <caption><center style="font-family: Montserrat  ;color: #373737;"> Restricted Holidays </center></caption>
                                <thead>
                                  <tr>
                                    <th>S.no</th>
                                    <th>Occasion</th>
                                    <th>Date</th>
                                  </tr>
                                </thead>

                                <tbody>
                                         <?php
                                            $q3="select * from restricted_holidays order by date";
                                            $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                            if ($re3->num_rows > 0) {
                                              $index=1;
                                                while($ro3 = $re3->fetch_array()){
                                                  $dateCreated=date_create($ro3['date']);
                                                  $formattedDate=date_format($dateCreated, 'd-m-Y');
                                               
                                                    echo  " <tr>
                                                              <td>".$index.".</td>
                                                              <td>".$ro3['occasion']."</td>
                                                              <td>".$formattedDate."</td>
                                                            </tr> ";

                                                       $index++;
                                                }
                                            }

                                          echo    " </tbody>
                                                    </table>
                                                    ";

                                ?>
                                </tbody>
                              </table><br><br>

                <p style="font: Montserrat ;">NOTE: Fill 1 row for one leave. Start filling from top row. You can fill Max. 5 leaves at a time.</p><br>
                <form class="form-inline" id="leavesForm" method="POST" action="applyUserLeaves.php">
                  <div class="form-group">
                          <label class="control-label " for="leaveType1">1.  Leave Type</label>
                          
                            <select class="form-control" id="leaveType1" name="leaveType1">
                              <option value="0" >--select--</option>
                                  <?php
                                      
                                      $query = "SELECT * FROM leave_types  order by type";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                          echo "<option value=" .$rows['id']. ">" .$rows['type']. "</option>";
                                      }
                                  ?>     
                            </select>
                          
                  </div>

                  <div class="form-group"  id="half_full1" style="display: none;" >
                          <label class="control-label " for="halfFull1">Half/Full</label>
                          
                            <select class="form-control" id="halfFull1" name="halfFull1">
                              <option value="Full" selected="">Full Day</option>
                              <option value="Half" >Half Day</option>
                            </select>
                  </div>
                 
                  <div class="form-group" id="against_date1" style="display: none;" >
                          <label class="control-label " for="againstDate1">Against Date</label>
                         
                            <select class="form-control" id="againstDate1" name="againstDate1">
                              <option value="0" >--select--</option>
                                  <?php
                              $user_id=$_SESSION['userid'];
                              $compOffReason="";
                                      $query = "SELECT * FROM leave_data where user_id='$user_id' AND status='3'";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      echo "<script>var compOffReason=[];</script>";
                                      while ($rows = mysqli_fetch_array($result)) {
                                          $compOffReason="'".$rows['reason']."'";
                                          echo "<option value=" .$rows['id']. ">" .$rows['against_date']. "</option>";
                                        
                                          echo "<script> compOffReason['".$rows['id']."']=".$compOffReason.";</script>";
                                      }
                                  ?>     
                            </select>
                        
                  </div>
                  
                  <div class="form-group" id="rh_date1" style="display: none;" >
                          <label class="control-label " for="rhDate1">RH</label>
                         
                            <select class="form-control" id="rhDate1" name="rhDate1">
                              <option value="0" >--select--</option>
                              <option value="Birthday">Birthday</option>;
                                  <?php
                            //  $user_id=$_SESSION['userid'];
                                  $rhReason1="";
                                      $query = "SELECT * FROM restricted_holidays ";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      echo "<script>var rhReason=[];</script>";
                                      while ($rows = mysqli_fetch_array($result)) {
                                          $rhReason="'".$rows['date']."'";

                                          echo "<option value=" .$rows['id']. ">" .$rows['occasion']. "</option>";
                                          echo "<script> rhReason['".$rows['id']."']=".$rhReason.";</script>";
                                      }
                                  ?>     
                            </select>
                  </div>

                  <div class="form-group" id="for_date1"> 
                    <label class="control-label " for="forDate1">Leave Date</label>
                
                      <input type="text" class="form-control" id="forDate1" name="forDate1" placeholder="Select Date">
                   
                  </div>
                  <div class="form-group" id="Reason1" > 
                    <label class="control-label " for="reason1">Reason</label>
                      <input type="text" class="form-control" id="reason1" name="reason1" placeholder="Enter Reason">
                  </div>
                  <br><br>
                  <div class="form-group">
                          <label class="control-label " for="leaveType2">2. Leave Type</label>
                          
                            <select class="form-control" id="leaveType2" name="leaveType2">
                              <option value="0" >--select--</option>
                                  <?php
                                      
                                      $query = "SELECT * FROM leave_types  order by type";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                          echo "<option value=" .$rows['id']. ">" .$rows['type']. "</option>";
                                      }
                                  ?>     
                            </select>
                          
                  </div>

                  <div class="form-group"  id="half_full2" style="display: none;" >
                          <label class="control-label " for="halfFull2">Half/Full</label>
                          
                            <select class="form-control" id="halfFull2" name="halfFull2">
                              <option value="Full" selected="">Full Day</option>
                              <option value="Half" >Half Day</option>
                            </select>
                  </div>

                 
                  <div class="form-group" id="against_date2" style="display: none;" >
                          <label class="control-label " for="againstDate2">Against Date</label>
                         
                            <select class="form-control" id="againstDate2" name="againstDate2">
                              <option value="0" >--select--</option>
                                  <?php
                              $user_id=$_SESSION['userid'];
                                      $query = "SELECT * FROM leave_data where user_id='$user_id' AND status='3'";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                       
                                          echo "<option value=" .$rows['id']. ">" .$rows['against_date']. "</option>";
                                      }
                                  ?>     
                            </select>
                        
                  </div>
                  
                  <div class="form-group" id="rh_date2" style="display: none;" >
                          <label class="control-label " for="rhDate2">RH </label>
                         
                            <select class="form-control" id="rhDate2" name="rhDate2">
                              <option value="0" >--select--</option>
                              <option value="Birthday">Birthday</option>;
                                  <?php
                            //  $user_id=$_SESSION['userid'];
                                      $query = "SELECT * FROM restricted_holidays ";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                       
                                          echo "<option value=" .$rows['id']. ">" .$rows['occasion']. "</option>";
                                      }
                                  ?>     
                            </select>
                  </div>

                  <div class="form-group" id="for_date2">
                    <label class="control-label " for="forDate2">Leave Date</label>
                
                      <input type="text" class="form-control" id="forDate2" name="forDate2" placeholder="Select Date">
                   
                  </div>

                  <div class="form-group" id="Reason2"> 
                    <label class="control-label " for="reason2">Reason</label>
                      <input type="text" class="form-control" id="reason2" name="reason2" placeholder="Enter Reason">
                  </div><br><br>
                  <div class="form-group">
                          <label class="control-label " for="leaveType3">3. Leave Type</label>
                          
                            <select class="form-control" id="leaveType3" name="leaveType3">
                              <option value="0" >--select--</option>
                                  <?php
                                      
                                      $query = "SELECT * FROM leave_types  order by type";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                          echo "<option value=" .$rows['id']. ">" .$rows['type']. "</option>";
                                      }
                                  ?>     
                            </select>
                  </div>

                  <div class="form-group"  id="half_full3" style="display: none;" >
                          <label class="control-label " for="halfFull3">Half/Full</label>
                          
                            <select class="form-control" id="halfFull3" name="halfFull3">
                              <option value="Full" selected="">Full Day</option>
                              <option value="Half" >Half Day</option>
                            </select>
                  </div>

                 
                  <div class="form-group" id="against_date3" style="display: none;" >
                          <label class="control-label " for="againstDate3">Against Date</label>
                         
                            <select class="form-control" id="againstDate3" name="againstDate3">
                              <option value="0" >--select--</option>
                                  <?php
                              $user_id=$_SESSION['userid'];
                                      $query = "SELECT * FROM leave_data where user_id='$user_id' AND status='3'";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                       
                                          echo "<option value=" .$rows['id']. ">" .$rows['against_date']. "</option>";
                                      }
                                  ?>     
                            </select>
                        
                  </div>

                  <div class="form-group" id="rh_date3" style="display: none;" >
                          <label class="control-label " for="rhDate3">RH </label>
                         
                            <select class="form-control" id="rhDate3" name="rhDate3">
                              <option value="0" >--select--</option>
                              <option value="Birthday">Birthday</option>;
                                  <?php
                            //  $user_id=$_SESSION['userid'];
                                      $query = "SELECT * FROM restricted_holidays ";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                       
                                          echo "<option value=" .$rows['id']. ">" .$rows['occasion']. "</option>";
                                      }
                                  ?>     
                            </select>
                  </div>
                  
                  <div class="form-group" id="for_date3">
                    <label class="control-label " for="forDate3">Leave Date</label>
                
                      <input type="text" class="form-control" id="forDate3" name="forDate3" placeholder="Select Date">
                   
                  </div>
                  <div class="form-group" id="Reason3"> 
                    <label class="control-label ">Reason</label>
                      <input type="text" class="form-control" id="reason3" name="reason3" placeholder="Enter Reason">
                  </div>
                  <br><br>
                  <div class="form-group">
                          <label class="control-label " for="leaveType4">4. Leave Type</label>
                          
                            <select class="form-control" id="leaveType4" name="leaveType4">
                              <option value="0" >--select--</option>
                                  <?php
                                      
                                      $query = "SELECT * FROM leave_types  order by type";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                          echo "<option value=" .$rows['id']. ">" .$rows['type']. "</option>";
                                      }
                                  ?>     
                            </select>
                          
                  </div>

                  <div class="form-group"  id="half_full4" style="display: none;" >
                          <label class="control-label " for="halfFull4">Half/Full</label>
                          
                            <select class="form-control" id="halfFull4" name="halfFull4">
                              <option value="Full" selected="">Full Day</option>
                              <option value="Half" >Half Day</option>
                            </select>
                  </div>

                 
                  <div class="form-group" id="against_date4" style="display: none;" >
                          <label class="control-label " for="againstDate4">Against Date</label>
                         
                            <select class="form-control" id="againstDate4" name="againstDate4">
                              <option value="0" >--select--</option>
                                  <?php
                              $user_id=$_SESSION['userid'];
                                      $query = "SELECT * FROM leave_data where user_id='$user_id' AND status='3'";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                       
                                          echo "<option value=" .$rows['id']. ">" .$rows['against_date']. "</option>";
                                      }
                                  ?>     
                            </select>
                        
                  </div>
                  <div class="form-group" id="rh_date4" style="display: none;" >
                          <label class="control-label " for="rhDate4">RH </label>
                         
                            <select class="form-control" id="rhDate4" name="rhDate4">
                              <option value="0" >--select--</option>
                              <option value="Birthday">Birthday</option>;
                                  <?php
                            //  $user_id=$_SESSION['userid'];
                                      $query = "SELECT * FROM restricted_holidays ";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                       
                                          echo "<option value=" .$rows['id']. ">" .$rows['occasion']. "</option>";
                                      }
                                  ?>     
                            </select>
                  </div>
                  <div class="form-group" id="for_date4">
                    <label class="control-label " for="forDate4">Leave Date </label>
                
                      <input type="text" class="form-control" id="forDate4" name="forDate4" placeholder="Select Date">
                   
                  </div>
                  <div class="form-group" id="Reason4"> 
                    <label class="control-label " for="reason4">Reason</label>
                      <input type="text" class="form-control" id="reason4" name="reason4" placeholder="Enter Reason">
                  </div>
                  <br><br>
                  <div class="form-group">
                          <label class="control-label " for="leaveType5">5. Leave Type</label>
                          
                            <select class="form-control" id="leaveType5" name="leaveType5">
                              <option value="0" >--select--</option>
                                  <?php
                                      
                                      $query = "SELECT * FROM leave_types  order by type";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                          echo "<option value=" .$rows['id']. ">" .$rows['type']. "</option>";
                                      }
                                  ?>     
                            </select>
                          
                  </div>

                  <div class="form-group"  id="half_full5" style="display: none;" >
                          <label class="control-label " for="halfFull5">Half/Full</label>
                          
                            <select class="form-control" id="halfFull5" name="halfFull5">
                              <option value="Full" selected="">Full Day</option>
                              <option value="Half" >Half Day</option>
                            </select>
                  </div>

                 
                  <div class="form-group" id="against_date5" style="display: none;" >
                          <label class="control-label " for="againstDate5">Against Date</label>
                         
                            <select class="form-control" id="againstDate5" name="againstDate5">
                              <option value="0" >--select--</option>
                                  <?php
                              $user_id=$_SESSION['userid'];
                                      $query = "SELECT * FROM leave_data where user_id='$user_id' AND status='3'";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                       
                                          echo "<option value=" .$rows['id']. ">" .$rows['against_date']. "</option>";
                                      }
                                  ?>     
                            </select>
                  </div>

                  <div class="form-group" id="rh_date5" style="display: none;" >
                          <label class="control-label " for="rhDate5">RH </label>
                         
                            <select class="form-control" id="rhDate5" name="rhDate5">
                              <option value="0" >--select--</option>
                              <option value="Birthday">Birthday</option>;
                                  <?php
                            //  $user_id=$_SESSION['userid'];
                                      $query = "SELECT * FROM restricted_holidays ";
                                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                      while ($rows = mysqli_fetch_array($result)) {
                                       
                                          echo "<option value=" .$rows['id']. ">" .$rows['occasion']. "</option>";
                                      }
                                  ?>     
                            </select>
                  </div>
                  
                  <div class="form-group" id="for_date5">
                    <label class="control-label " for="forDate5">Leave Date</label>
                
                      <input type="text" class="form-control" id="forDate5" name="forDate5" placeholder="Select Date">
                   
                  </div>
                  <div class="form-group" id="Reason5"> 
                    <label class="control-label " for="reason5">Reason</label>
                      <input type="text" class="form-control" id="reason5" name="reason5" placeholder="Enter Reason">
                  </div>
                  
                  <div class="form-group">     
                     <input type="hidden" class="form-control" id="id" name="id" >
                  </div><br><br>
                  <div class="form-group"> 
                      <button type="button" id="submit-leaves" name="submit-leaves" class="btn  ">Apply</button>
                      <button type="button" id="cancel-leaves" name="cancel-leaves" class="btn  ">Reset</button>
                  </div>
                </form>
           
                 
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

        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeEmpLeavesTabs', $(e.target).attr('href'));
        });
        var activeEmpLeavesTabs = localStorage.getItem('activeEmpLeavesTabs');
        if(activeEmpLeavesTabs){
            $('#myTab a[href="' + activeEmpLeavesTabs + '"]').tab('show');
        }
            
        if(localStorage.getItem('filter2-employees')){
              $('#filter2-employees').val(localStorage.getItem('filter2-employees'));
          }

          $('#filter2-employees').change(function(){
              localStorage.setItem('filter2-employees',$('#filter2-employees').val() );   
          });


          var userid=localStorage.getItem('user_id');
          $('#a').click(function() {
              localStorage.removeItem('filter2-employees');
              window.location.href="userEntry.php";
          });

        var user_id = localStorage.getItem('user_id');
         document.getElementById("id").value = user_id;
        $(function() { 
                        $('#rhDate1').change(function(){
                                        var id=$(this).val();
                                        $("#forDate1").val(rhReason[id]);
                                      });
                        $('#againstDate1').change(function(){
                                        var id=$(this).val();
                                        $("#reason1").val(compOffReason[id]);
                                      });

                       $('#leaveType1').change(function(){
                                        if($(this).val()=="2"){
                                            $('#against_date1').show();
                                            $('#for_date1').val("");
                                            $('#for_date1').show();
                                            $('#rh_date1').hide();
                                            $("#Reason1").show();
                                            $("#half_full1").hide();
                                            $("#reason1").val("Select Against Date");
                                        //    $("#reason1").prop('disabled', true);
                                        }else if($(this).val()=="1"){
                                          $('#against_date1').hide();
                                          $('#rh_date1').hide();
                                          $('#for_date1').val("");
                                          $('#for_date1').show();
                                          $("#Reason1").show();
                                          $("#half_full1").show();
                                          $("#reason1").val("");
                                      //    $("#reason1").prop('disabled', false);
                                        }else if($(this).val()=="3"){
                                          $('#against_date1').hide();
                                          $('#for_date1').show();
                                           $('#rh_date1').show();
                                           $("#half_full1").hide();
                                           $("#Reason1").hide();
                                        //   $("#reason1").val("Select RH Date");
                                      //     $("#reason1").prop('disabled', true);
                                        }
                                      });

                          $('#rhDate2').change(function(){
                                        var id=$(this).val();
                                        $("#forDate2").val(rhReason[id]);
                                      });
                        $('#againstDate2').change(function(){
                                        var id=$(this).val();
                                        $("#reason2").val(compOffReason[id]);
                                      });
                        $('#leaveType2').change(function(){
                                        if($(this).val()=="2"){
                                            $('#against_date2').show();
                                             $('#for_date2').val("");
                                             $('#for_date2').show();
                                            $('#rh_date2').hide();
                                            $("#Reason2").show();
                                            $("#half_full2").hide();
                                            $("#reason2").val("Select Against Date");
                                        //    $("#reason2").prop('disabled', true);
                                        }else if($(this).val()=="1"){
                                          $('#against_date2').hide();
                                          $('#rh_date2').hide();
                                          $('#for_date2').val("");
                                          $('#for_date2').show();
                                          $("#Reason2").show();
                                          $("#half_full2").show();
                                          $("#reason2").val("");
                                      //    $("#reason2").prop('disabled', false);
                                        }else if($(this).val()=="3"){
                                          $('#against_date2').hide();
                                          $('#for_date2').show();
                                           $('#rh_date2').show();
                                           $("#half_full2").hide();
                                           $("#Reason2").hide();
                                        //   $("#reason2").val("Select RH Date");
                                        //   $("#reason2").prop('disabled', true);
                                        }
                                      });
                          
                          $('#rhDate3').change(function(){
                                        var id=$(this).val();
                                        $("#forDate3").val(rhReason[id]);
                                      });
                        $('#againstDate3').change(function(){
                                        var id=$(this).val();
                                        $("#reason3").val(compOffReason[id]);
                                      });
                        $('#leaveType3').change(function(){
                                            if($(this).val()=="2"){
                                                $('#against_date3').show();
                                                $('#for_date3').show();
                                                $('#rh_date3').hide();
                                                $("#Reason3").show();
                                                $("#half_full3").hide();
                                               $("#reason3").val("Select Against Date");
                                            //    $("#reason3").prop('disabled', true);
                                            }else if($(this).val()=="1"){
                                              $('#against_date3').hide();
                                              $('#for_date3').show();
                                              $('#rh_date3').hide();
                                              $("#Reason3").show();
                                              $("#half_full3").show();
                                              $("#reason3").val("");
                                            //  $("#reason3").prop('disabled', false);
                                            }else if($(this).val()=="3"){
                                              $('#against_date3').hide();
                                              $('#for_date3').show();
                                               $('#rh_date3').show();
                                               $("#half_full3").hide();
                                               $("#Reason3").hide();
                                             //  $("#reason3").val("Select RH Date");
                                            //   $("#reason3").prop('disabled', true);
                                            }
                                          });
                          
                          $('#rhDate4').change(function(){
                                        var id=$(this).val();
                                        $("#forDate4").val(rhReason[id]);
                                      });
                        $('#againstDate4').change(function(){
                                        var id=$(this).val();
                                        $("#reason4").val(compOffReason[id]);
                                      });
                        $('#leaveType4').change(function(){
                                                if($(this).val()=="2"){
                                                    $('#against_date4').show();
                                                     $('#for_date4').show();
                                                     $('#rh_date4').hide();
                                                     $("#Reason4").show();
                                                     $("#half_full4").hide();
                                                     $("#reason4").val("Select Against Date");
                                                  //   $("#reason4").prop('disabled', true);
                                            $('#rh_date4').hide();
                                                }else if($(this).val()=="1"){
                                                  $('#against_date4').hide();
                                                  $('#rh_date4').hide();
                                                  $('#for_date4').show();
                                                  $("#Reason4").show();
                                                  $("#half_full4").show();
                                                  $("#reason4").val("");
                                                }else if($(this).val()=="3"){
                                                  $('#against_date4').hide();
                                                  $('#for_date4').show();
                                                   $('#rh_date4').show();
                                                   $("#half_full4").hide();
                                                   $("#Reason4").hide();
                                                 //  $("#reason4").val("Select RH Date");
                                                //   $("#reason4").prop('disabled', true);
                                                }
                                              });
                          
                          $('#rhDate5').change(function(){
                                        var id=$(this).val();
                                        $("#forDate5").val(rhReason[id]);
                                      });
                        $('#againstDate5').change(function(){
                                        var id=$(this).val();
                                        $("#reason5").val(compOffReason[id]);
                                      });
                        $('#leaveType5').change(function(){
                                                if($(this).val()=="2"){
                                                    $('#against_date5').show();
                                                    $('#rh_date5').hide();
                                                     $('#for_date5').show();
                                                     $("#Reason5").show();
                                                     $("#half_full5").hide();
                                                     $("#reason5").val("Select Against Date");
                                                  //   $("#reason5").prop('disabled', true);
                                            $('#rh_date5').hide();
                                                }else if($(this).val()=="1"){
                                                  $('#against_date5').hide();
                                                  $('#for_date5').show();
                                                  $('#rh_date5').hide();
                                                  $("#Reason5").show();
                                                  $("#half_full5").show();
                                                  $("#reason5").val("");
                                                }else if($(this).val()=="3"){
                                                  $('#against_date5').hide();
                                                  $('#for_date5').show();
                                                  $('#rh_date5').show();
                                                  $("#Reason5").hide();
                                                  $("#half_full5").hide();
                                                  $("#reason5").val("Select RH Date");
                                                //  $("#reason5").prop('disabled', true);
                                                }
                                              });
          });


           $("#submit-leaves").click(function(e) {


                var form = $("#leavesForm");
                var params = form.serializeArray();
                var formData = new FormData();
                $(params).each(function (index, element) {
                    formData.append(element.name, element.value);
                });

                $.ajax({
                        url: "applyUserLeaves.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data){
                             if(data=="2"){
                                alert("Field not set to apply!");
                            }else if(data=="3"){
                              window.location.reload();
                            }else if(data=="4"){
                              alert("Fill fields properly!");
                            }else{
                                
                                var response=JSON.parse(data);

                                var userName=response.userName;
                                var userEmail=response.userEmail;
                                var mgrName=response.mgrName;
                                var mgrEmail=response.mgrEmail;
                                var hrName=response.hrName;
                                var hrEmail=response.hrEmail;
                                var message=response.message;
                                var subject="Leave Request - "+userName;
                                var leaveMessage="<pre>Hi "+mgrName+",<br><br>"+userName+" ("+userEmail+") has applied for following leaves:<br><br>"+message+"<br>Thanks.</pre>";
                                var cc="##"+userEmail+"##"+hrEmail;

                                $.ajax({
                                                                                   
                                    url: "http://dev.tagbin.in/phpHandler/mailer/mailgun/tagbinMailer.php",
                                    type: "POST",
                                    data: "_ACTION=send_email&_SUBJECT="+subject+"&_EMAIL="+mgrEmail+"&_MESSAGE="+leaveMessage+"&_CC="+cc,
                                    success: function(data){
                                        alert("Mail has been sent!");
                                        $('#leavesForm')[0].reset();
                                    }
                                })

                                  alert("Applied for leaves!");
                                  $('#leavesForm')[0].reset();
                                    window.location.href=window.location.href;

                            }
                        }
                    })

           });

$("#cancel-leaves").click(function(e) {
  $('#leavesForm')[0].reset();
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

    function removeRecord(dataId){
            var r = confirm("Are you sure you want delete this entry?");
                        if (r == true) {
                            $.ajax({
                                        url: "removeEntry.php",
                                        type: "POST",
                                        data: "ACTION=delete&dataId="+dataId,
                                        success: function(data){
                                            window.location.reload();
                                        }
                                    })
                        }
                       
        }
   
    </script>
<!--<script type="text/javascript" src="empBars.js"></script>-->

</html>                                        