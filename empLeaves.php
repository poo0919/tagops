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
    <script src="js/config.js" type="text/javascript"></script>
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
            <img src="images/logo.png" style="width:120px;height:45px;padding-bottom: 20px;margin-top: 0px;">
            </a>
        </div>
        
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
              <a class="dropdown-toggle" id="login_user_name" data-toggle="dropdown" href="#" style="background-color: white; ">
              <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="empProfile.php">My Profile</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="api/logout.php" id="logout-button" >Log Out</a></li>
              </ul>
          </li>
           
        </ul>
        <div id="sidebar-wrapper" class="sidebar-toggle">
            <div id="nav-menu">
                <div class="submenu" >
                    <div class="submenu-heading" id="expenses"><a href="empExpenses.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Expenses.png" alt="expenses" >Expenses</h5> </a></div>                   
                </div>
                <div class="submenu" style="background: #373737;">
                    <div class="submenu-heading" id="leaves"><a href="empLeaves.php" style="text-decoration: none !important;color:#ffffff;"> <h5 class="submenu-title" ><img src="images/Leaves-W.png" alt="leaves" >Leaves</h5></a> </div>                   
                </div>
                <div class="submenu" >
                    <div class="submenu-heading" id="assets"><a href="empAssets.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Assets.png" alt="assets" >Assets</h5></a> </div>                   
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
                  <div class="submenu-heading" id="manhours"><a href="empManHours.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" id="manhours"><img src="images/Man-Hours.png" alt="manhours" >Man Hours</h5></a> </div>                   
                </div>
            </div>
        </div>
    </div>
</nav>

<div id="page-wrapper" class="container" >
  <div class="bs-example">
    <center>   
    <ul class="nav nav-pills" style="display:inline-block;" id="myTab" >
      <li class="active " ><a data-toggle="tab" href="#leaveRecordsTab" >LEAVE RECORDS</a></li>
      <li><a data-toggle="tab" href="#leaveStatusTab" id="ref_B">LEAVE STATUS</a></li>
      <li><a data-toggle="tab" href="#applyLeavesTab" id="ref_C">APPLY LEAVES</a></li>
      <li><a data-toggle="tab" href="#listofHolidaysTab" id="ref_C">LIST OF HOLIDAYS</a></li>
    </ul>
    </center> 
  <br><br>

    <div class="tab-content" id="myContent">
      <div id="leaveRecordsTab" class="tab-pane fade in active">
        <?php
          $query="Select * from leave_data where user_id='$user_id' AND (status='1' || status='2' || status='4' || status='6') order by for_date DESC";
          $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
          if ($result->num_rows > 0) {
            $inc = 1;
            $tableRows = array();

        ?>
          <table  class="table table-hover table-condensed table-bordered" >
            <thead> <tr> <th>S.No.</th> <th>Leave Type</th> <th>Half/Full</th> <th>Count</th> <th>Leave Date</th> <th>Against Date</th> <th>Reason</th> <th>Status</th> <th>Action</th> </tr> </thead>
            <tbody>
            <?php
              while ($row = $result->fetch_array()){
                $type=""; $againstDate=""; $reason=""; $status="";

                $dateCreated1=date_create($row['for_date']);
                $formattedForDate1=date_format($dateCreated1, 'd-m-Y');
                $dateCreated3=date_create($row['to_date']);
                $formattedtoDate3=date_format($dateCreated3, 'd-m-Y');
                                                    
                if($row['type_id']=="1"){
                  $type="CL+PL+ML";
                  $formattedAgainstDate2="NA";
                  if($row['half_full']=="Half"){
                    $formattedForDate1=$formattedForDate1;
                  }else{
                    if($row['to_date']!="0000-00-00"){
                      $formattedForDate1="from( ".$formattedForDate1." ) -> to( ".$formattedtoDate3." ) ";
                    }
                  }
                }else if($row['type_id']=="2"){
                  $type="Comp Off";
                  $againstDate=$row['against_date'];
                  $dateCreated2=date_create($againstDate);
                  $formattedAgainstDate2=date_format($dateCreated2, 'd-m-Y');
                }else if($row['type_id']=="3"){
                  $type="RH";
                  $formattedAgainstDate2="NA";
                }else if($row['type_id']=="4"){
                  $type="Work from Home";
                  $formattedAgainstDate2="NA";
                  if($row['half_full']=="Half"){
                    $formattedForDate1=$formattedForDate1;
                  }else{
                    if($row['to_date']!="0000-00-00"){
                      $formattedForDate1="from( ".$formattedForDate1." ) -> to( ".$formattedtoDate3." ) ";
                    }
                  }
                }
                      
                $reason=mysqli_escape_string($conn,$row['reason']);
                $statusNum=$row['status'];
                $statusColor="";
                if($statusNum=='1'){
                  $status="Applied";
                  $statusColor="#71D3f4";
                }else if ($statusNum=='2') {
                  $status="Approved";
                  $statusColor="#7cc576";
                }else if ($statusNum=='4') {
                  $status="Approved";
                  $statusColor="#7cc576";
                }else if ($statusNum=='6') {
                  $status="Rejected";
                  $statusColor="#fea862";
                }

                $cancelButton="";
                if($statusNum=='1'){
                  $cancelButton="<button id='cancelLeavebtn".$inc."' onclick='cancelLeaveRequest(".$row['id'].",".$row['type_id'].",".$user_id.")' class='btn btn-xs' style='background-color: #fea862;color=#ffffff;'>Cancel Leave</button>";
                }else{
                  $cancelButton="No Action";
                }

                $count="";
                if($row['half_full']=="Half"){
                  $count=0.5;
                }
                if($row['half_full']=="Full"){
                  $count=$row['leave_count'];
                }
                if(empty($row['half_full'])){
                  $row['half_full']="NA";
                  $count=1;
                }
                      
                echo "<tr> <td>".$inc.".</td> <td>".$type."</td> <td>".$row['half_full']."</td> <td>".$count."</td> <td>".$formattedForDate1."</td> <td>".$formattedAgainstDate2."</td> <td>".$reason."</td> <td style='color:".$statusColor."'>".$status."</td> <td>".$cancelButton."</td> </tr>";
                $inc++;    
              }
          ?></tbody></table> <?php  }  ?>
      </div>
    
      <div id="leaveStatusTab" class="tab-pane fade"><center>
        <table class="table table-hover table-bordered table-condensed"  style="font-family: Montserrat ;"  >
        <?php
          $q2="select * from leaves where user_id='$user_id'";
          $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
          if ($re2->num_rows > 0) {
        ?>
        <thead> <tr> <th>Leaves Pending (CL+PL+ML)</th> <th>Comp Off given</th> <th>Registered Holiday Pending</th> <th>Total Leaves Pending</th> </tr> </thead>
        <tbody>
        <?php
            while($ro2 = $re2->fetch_array()){
              $total=$ro2['pl_cl_ml']+$ro2['comp_off']+$ro2['rh'];
              echo  " <tr  > <td>".$ro2['pl_cl_ml']."</td> <td>".$ro2['comp_off']."</td> <td>".$ro2['rh']."</td> <td>".$total."</td> </tr> ";
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
        <thead> <tr> <th>S.no</th> <th>Against Date</th> <th>Expiry Date</th> <th>Reason</th> <th>Status</th> </tr> </thead>
        <tbody>
        <?php
          while($ro3 = $re3->fetch_array()){
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

            echo  " <tr> <td>".$index."</td> <td>".$formattedDate1."</td> <td>".$formattedDate2."</td> <td>".$ro3['compoff_reason']."</td> <td style='color:".$textColor."'>".$status."</td> </tr> ";
            $index++;
          }
        }else{
          echo "No comp off given!";
        }
                    
        echo  " </tbody> </table> ";
      ?>
      </tbody> </table> <br><br>
    </div>

    <div id="applyLeavesTab" class="tab-pane fade">
      <div id="applyforleaves" style="border:1px solid #ACACAC;">
        <center><h4>Apply Leaves</h4></center>
          <form class="form-horizontal">
            <div class="row">
              <div class="form-group col-sm-6">
                <label class="control-label col-sm-3" for="leaveType">Leave Type</label>
                <div class="col-sm-5">
                  <select class="form-control" id="leaveType" name="leaveType">
                    <!--  <option value="0" >  --select-- </option> -->
                    <?php
                      $query = "SELECT * FROM leave_types  order by type";
                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                      while ($rows = mysqli_fetch_array($result)) {
                        echo "<option value=" .$rows['id']. ">" .$rows['type']. "</option>";
                      }
                    ?>     
                  </select>
                </div>
              </div>
            </div>
          </form>

          <form id="clplml_div" class="form-horizontal" style=""><br><br>
            <div class="row">
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4" for="halfFull">Half/Full</label>
                <div class="col-sm-8">
                  <select class="form-control" id="halfFull" name="halfFull">
                    <option value="Full" selected="">Full Day</option>
                    <option value="Half" >Half Day</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4 " for="fromDate">From Date</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control dateSelector" id="fromDate" name="fromDate" placeholder="Select Date">
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4" for="clplmlreason">Leave Reason</label>
                <div class="col-sm-8">
                  <textarea rows="3" class="form-control" id="clplmlreason" name="clplmlreason" placeholder="Enter Reason"></textarea>
                </div>
              </div>
              <div class="form-group col-sm-6" id="to_date"> 
                <label class="control-label col-sm-4 " for="toDate">To Date</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control dateSelector" id="toDate" name="toDate" placeholder="Select Date">
                </div>
              </div>
            </div>
            <div class="form-group">     
              <input type="hidden" class="form-control" id="clplml_user_id" name="clplml_user_id" >
            </div>
            <br><br>

            <div class="form-group"> 
              <div class=" col-sm-offset-5 col-sm-10">
                <button type="button" id="clplml-leaves" name="clplml-leaves" class="btn  ">Apply</button>
                <button type="button" id="cancel-clplml-leaves" name="cancel-leaves" class="btn  ">Reset</button>
              </div>
            </div>
          </form>

          <form id="compoff_div" class="form-horizontal"  style="display: none;"><br><br>
            <div class="row">
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4" for="fromDate">Against Date</label>
                <div class="col-sm-8">
                  <select class="form-control" id="againstDate" name="againstDate">
                    <option value="0" >--select--</option>
                    <?php
                      $user_id=$_SESSION['userid'];
                      $compOffReason="";
                      $query = "SELECT * FROM leave_data where user_id='$user_id' AND status='3' order by against_date";
                      $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                      echo "<script>var compOffReason=[];</script>";
                      while ($rows = mysqli_fetch_array($result)) {
                        $compOffReason="'".$rows['compoff_reason']."'";
                        echo "<option value=" .$rows['id']. ">" .$rows['against_date']. "</option>";
                        echo "<script> compOffReason['".$rows['id']."']=".$compOffReason.";</script>";
                      }
                    ?>     
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4 " for="toDate">CompOff Reason</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="compOffReason" name="compOffReason">
                </div>
              </div>
            </div>
            <div class="form-group col-sm-6"> 
              <label class="control-label col-sm-4" for="for_compoff_date">Leave Date</label>
              <div class="col-sm-8">
                <input type="text" class="form-control dateSelector" id="for_compoff_date" name="for_compoff_date" placeholder="Select Date">
              </div>
            </div>
            <div class="form-group col-sm-6"> 
              <label class="control-label col-sm-4 " for="compoff_reason">Leave Reason</label>
              <div class="col-sm-8">
                <textarea rows="3" class="form-control" id="compoff_reason" name="compoff_reason" placeholder="Enter Reason"></textarea>
              </div>
            </div>
            <div class="form-group">     
              <input type="hidden" class="form-control" id="compoff_user_id" name="compoff_user_id" >
            </div>
            <br><br>

            <div class="form-group"> 
              <div class=" col-sm-offset-5 col-sm-10">
                <button type="button" id="compoff-leaves" name="compoff-leaves" class="btn  ">Apply</button>
                <button type="button" id="cancel-compoff-leaves" name="cancel-compoff-leaves" class="btn  ">Reset</button>
              </div>
            </div>
          </form>

          <form id="rh_div" class="form-horizontal"  style="display: none;"><br><br>
            <div class="row">
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4" for="occasion">Occasion</label>
                <div class="col-sm-8">
                  <select class="form-control" id="occasion" name="occasion">
                    <option value="0" >--select--</option>
                    <option value="Birthday">Birthday</option>;
                    <?php
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
              </div>
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4 " for="rh_date">Occasion Date</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control " id="rh_date" name="rh_date">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4" for="rh_reason">Leave Reason</label>
                <div class="col-sm-8">
                  <textarea rows="3" class="form-control" id="rh_reason" name="rh_reason" placeholder="Enter Reason"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">     
              <input type="hidden" class="form-control" id="rh_user_id" name="rh_user_id" >
            </div><br><br>
            <div class="form-group"> 
              <div class=" col-sm-offset-5 col-sm-10">
                <button type="button" id="rh-leaves" name="rh-leaves" class="btn  ">Apply</button>
                <button type="button" id="cancel-rh-leaves" name="cancel-rh-leaves" class="btn  ">Reset</button>
              </div>
            </div>
          </form>

          <form id="workfromhome_div" class="form-horizontal" style="display: none;"><br><br>
            <div class="row">
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4" for="wfhhalfFull">Half/Full</label>
                <div class="col-sm-8">
                  <select class="form-control" id="wfhhalfFull" name="wfhhalfFull">
                    <option value="Full" selected="">Full Day</option>
                    <option value="Half" >Half Day</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4" for="wfhfromDate">From Date</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control dateSelector" id="wfhfromDate" name="wfhfromDate" placeholder="Select Date">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6"> 
                <label class="control-label col-sm-4" for="wfhreason">Leave Reason</label>
                <div class="col-sm-8">
                  <textarea rows="3" class="form-control" id="wfhreason" name="wfhreason" placeholder="Enter Reason"></textarea>
                </div>
              </div>
              <div class="form-group col-sm-6" id="wfh_to_date"> 
                <label class="control-label col-sm-4 " for="wfhtoDate">To Date</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control dateSelector" id="wfhtoDate" name="wfhtoDate" placeholder="Select Date">
                </div>
              </div>
            </div>
            <div class="form-group">     
              <input type="hidden" class="form-control" id="wfh_user_id" name="wfh_user_id" >
            </div><br><br>
            <div class="form-group"> 
              <div class=" col-sm-offset-5 col-sm-10">
                <button type="button" id="wfh-leaves" name="wfh-leaves" class="btn  ">Apply</button>
                <button type="button" id="cancel-wfh-leaves" name="cancel-wfh-leaves" class="btn  ">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div id="listofHolidaysTab" class="tab-pane fade">
        <div class="row">
          <div class="col-sm-6">
            <table class="table table-hover table-bordered table-condensed"  style="font-family: Montserrat ;"  >
              <caption><center style="font-family: Montserrat  ;color: #373737;"> Restricted Holidays </center></caption>
              <thead>
                <tr> <th>S.no</th> <th>Occasion</th> <th>Date</th> </tr>
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
                    echo  "<tr>
                              <td>".$index.".</td>
                              <td>".$ro3['occasion']."</td>
                              <td>".$formattedDate."</td>
                          </tr> ";
                    $index++;
                  }
                }
                echo    " </tbody> </table> ";
              ?>
              </tbody>
              </table>
            </div>
            <div class="col-sm-6">
              <table class="table table-hover table-bordered table-condensed"  style="font-family: Montserrat ;"  >
                <caption><center style="font-family: Montserrat  ;color: #373737;"> General Holidays </center></caption>
                <thead>
                  <tr> <th>S.no</th> <th>Occasion</th> <th>Date</th> </tr>
                </thead>
                <tbody>
                <?php
                  $q3="select * from general_holidays order by date";
                  $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                  if ($re3->num_rows > 0) {
                    $index=1;
                    while($ro3 = $re3->fetch_array()){
                      $dateCreated=date_create($ro3['date']);
                      $formattedDate=date_format($dateCreated, 'd-m-Y');
                      echo  "<tr>
                              <td>".$index.".</td>
                              <td>".$ro3['occasion']."</td>
                              <td>".$formattedDate."</td>
                            </tr> ";
                      $index++;
                    }
                  }
                  echo  " </tbody> </table> ";
                ?>
                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript">
  $(document).ready(function(){
    var today = new Date();
    console.log("today: "+today);
    $( function() {
      $( ".dateSelector" ).datepicker({ 
        dateFormat: 'yy-mm-dd',
        maxDate: limitLeaveMonth
      });
    });
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

    document.getElementById("login_user_name").prepend(localStorage.getItem('name'));
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
  

        var user_id = localStorage.getItem('user_id');
         document.getElementById("clplml_user_id").value = user_id;
          document.getElementById("compoff_user_id").value = user_id;
           document.getElementById("rh_user_id").value = user_id;
            document.getElementById("wfh_user_id").value = user_id;

        $(function() { 
            $('#leaveType').change(function(){
              if($(this).val()=="0"){
                  $('#select_div').show();
                  $('#clplml_div').hide();
                  $('#compoff_div').hide();
                  $('#rh_div').hide();
                  $('#workfromhome_div').hide();
              }else if($(this).val()=="1"){
                  $('#select_div').hide();
                  $('#clplml_div').show();
                  $('#compoff_div').hide();
                  $('#rh_div').hide();
                  $('#workfromhome_div').hide();
              }else if($(this).val()=="2"){
                  $('#select_div').hide();
                  $('#clplml_div').hide();
                  $('#compoff_div').show();
                  $('#rh_div').hide();
                  $('#workfromhome_div').hide();
              }else if($(this).val()=="3"){
                  $('#select_div').hide();
                  $('#clplml_div').hide();
                  $('#compoff_div').hide();
                  $('#rh_div').show();
                  $('#workfromhome_div').hide();
              }else if($(this).val()=="4"){
                  $('#select_div').hide();
                  $('#clplml_div').hide();
                  $('#compoff_div').hide();
                  $('#rh_div').hide();
                  $('#workfromhome_div').show();
              }
            });

          $('#halfFull').change(function(){
            if($(this).val()=="Half"){
              $('#to_date').hide();
            }else if($(this).val()=="Full"){
              $('#to_date').show();
            }
          });

          $('#occasion').change(function(){
              var id=$(this).val();
              $("#rh_date").val(rhReason[id]);
              if(id!="Birthday"){
                $('#rh_date').prop('readonly', true);
                $('#rh_reason').val('');
              }else{
                $('#rh_date').prop('readonly', false);
                $('#rh_reason').val('Birthday');
                $( "#rh_date" ).datepicker({ 
                  dateFormat: 'yy-mm-dd',
                  maxDate: "+1m" });
              }
              
          });

          $('#againstDate').change(function(){
              var id=$(this).val();
              $("#compOffReason").val(compOffReason[id]);
          });

          $('#wfhhalfFull').change(function(){
            if($(this).val()=="Half"){
              $('#wfh_to_date').hide();
            }else if($(this).val()=="Full"){
              $('#wfh_to_date').show();
            }
          });

        });



           $("#clplml-leaves").click(function(e) {
                var form = $("#clplml_div");
                var params = form.serializeArray();
                var formData = new FormData();
                $(params).each(function (index, element) {
                    formData.append(element.name, element.value);
                });
                formData.append("ACTION", "CLPLML");

                $.ajax({
                        url: "api/empLeavesAPI.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response){
                          var data=$.trim(response);
                            if(data=="0"){
                                alert("Fill all Fields Properly.");
                            }else if(data=="1"){
                                 alert("For Half day leave from date should be equal to date.");
                            }else if(data=="2"){
                                alert("from date should be less than to date.");
                            }else if(data=="3"){
                                alert("You have already applied or taken leave for that date or in the given range");
                            }else if(data=="4"){
                                alert("You have negative cl+pl+ml");
                            }else if(data=="5"){
                                alert("Leave count for available days is 0 so you can't apply.");
                            }else if(response.success==true){
                              console.log("send email: "+JSON.stringify(response));
                                alert("Leave Applied");
                                window.location.reload();
                            }else if(response.success==false){
                                alert(response.message);
                            }
                        }
                    })
           });

           $("#wfh-leaves").click(function(e) {
                var form = $("#workfromhome_div");
                var params = form.serializeArray();
                var formData = new FormData();
                $(params).each(function (index, element) {
                    formData.append(element.name, element.value);
                });
                formData.append("ACTION", "WFH");

                $.ajax({

                        url: "api/empLeavesAPI.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response){
                          var data=$.trim(response);
                            if(data=="0"){
                                alert("Fill all Fields Properly.");
                            }else if(data=="1"){
                                 alert("For Half day leave from date should be equal to date.");
                            }else if(data=="2"){
                                alert("from date should be less than to date.");
                            }else if(data=="3"){
                                alert("You have already applied or taken leave for that date or in the given range");
                            }else if(data=="4"){
                                alert("You have negative cl+pl+ml");
                            }else if(data=="5"){
                                alert("Leave count for available days is 0 so you can't apply.");
                            }else if(response.success==true){
                              console.log("send email: "+JSON.stringify(response));
                                alert("Leave Applied");
                                window.location.reload();
                            }else if(response.success==false){
                                alert(response.message);
                            }
                        }
                    })
           });

           $("#compoff-leaves").click(function(e) {
                var form = $("#compoff_div");
                var params = form.serializeArray();
                var formData = new FormData();
                $(params).each(function (index, element) {
                    formData.append(element.name, element.value);
                });
                formData.append("ACTION", "CompOff");

                $.ajax({
                        url: "api/empLeavesAPI.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response){
                          data=$.trim(response);
                            if(data=="0"){
                              alert(" Field all fields properly.");
                            }else if(data=="3"){
                              alert(" You have already applied or taken leave for that date.");
                            }else if(response.success==true){
                              console.log("send email: "+JSON.stringify(response));
                                alert("Leave Applied");
                                window.location.reload();
                            }else if(response.success==false){
                                alert(response.message);
                            }
                        }
                    })

           });

           $("#rh-leaves").click(function(e) {
                var form = $("#rh_div");
                var params = form.serializeArray();
                var formData = new FormData();
                $(params).each(function (index, element) {
                    formData.append(element.name, element.value);
                });
                formData.append("ACTION", "RH");

                $.ajax({
                        url: "api/empLeavesAPI.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response){
                          data=$.trim(response);
                            if(data=="0"){
                                alert("Fill all Fields Properly.");
                            }else if(data=="1"){
                                alert("Sorry you can't apply as have 0 RH left to apply.");
                            }else if(data=="3"){
                              alert(" You have already applied or taken leave for that date.");
                            }else if(response.success==true){
                              console.log("send email: "+JSON.stringify(response));
                                alert("Leave Applied");
                                window.location.reload();
                            }else if(response.success==false){
                                alert(response.message);
                            }
                          }
                    })
           });
$("#cancel-clplml-leaves").click(function(e) {
  $('#clplml_div')[0].reset();
});
$("#cancel-rh-leaves").click(function(e) {
  $('#rh_div')[0].reset();
});
$("#cancel-compoff-leaves").click(function(e) {
  $('#compoff_div')[0].reset();
});
$("#cancel-wfh-leaves").click(function(e) {
  $('#workfromhome_div')[0].reset();
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

    function cancelLeaveRequest(applyLeaveId,leaveTypeId,userId){
      var r = confirm("Are you sure you want cancel this Leave?");
      if (r == true) {
        $.ajax({
          url: "api/empLeavesAPI.php",
          type: "POST",
          data: "ACTION=cancelLeave&applyLeaveId="+applyLeaveId+"&leaveTypeId="+leaveTypeId+"&userId="+userId,
          success: function(response){
            var data=$.trim(response);
            if(data=='0'){
              alert("Can't update!");
            }if(data=='1'){
              alert("some fields in request are missing!");
            }else if(response.success==true){
              console.log("send email: "+JSON.stringify(response));
              alert("Leave Cancelled.");
              window.location.reload();
            }else if(response.success==false){
              alert(response.message);
            }
          }
        });
      }
    }
   
    </script>

</html>