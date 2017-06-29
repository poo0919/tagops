<?php
include_once('api/database.php');
$conn = getDB();
include 'api/session.php';
//add new RH
if(isset($_GET['occasion1'])){
    if(!empty($_GET['occasion1']) && !empty($_GET['date'])){
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        }else{
            $occasion1=$_GET['occasion1'];
            $date=$_GET['date'];
            $sql = "INSERT INTO restricted_holidays (occasion,date) VALUES ('$occasion1','$date')";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('New RH added to database!'); window.location.replace('adminLeaveManagement.php');</script>";
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }else{
        echo "<script type='text/javascript'>alert('Field is not set!'); window.location.replace('adminLeaveManagement.php');</script>";
    }
}

if(isset($_GET['gh_occasion'])){
    if(!empty($_GET['gh_occasion']) && !empty($_GET['gh_date']))
    {
        $occasion1=$_GET['gh_occasion'];
        $date=$_GET['gh_date'];
        $sql = "INSERT INTO general_holidays (occasion,date) VALUES ('$occasion1','$date')";
        if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))){
            echo "<script type='text/javascript'>alert('New GH added to database!');window.location.replace('adminLeaveManagement.php');</script>";
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }else{
        echo "<script type='text/javascript'>alert('Field is not set!');window.location.replace('adminLeaveManagement.php');</script>";
    }
} 
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
    <link href='reportees-calender/css/jquery-ui.min.css' rel='stylesheet' />
    <link href='reportees-calender/css/fullcalendar.min.css' rel='stylesheet' />
    <link href='reportees-calender/css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <script src='reportees-calender/js/moment.min.js'></script>
    <script src='reportees-calender/js/fullcalendar.min.js'></script>
    <link rel="stylesheet" href="css/editable.css">
    <script>
        $( function() {
            $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
            $( "#gh_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
            $( "#date1" ).datepicker({ dateFormat: 'yy-mm-dd' });
            $( "#ghdate1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        });
    </script>
    <style type="text/css">
        .fc-view-container{
            background-color: #ffffff;
        } 
        .fc-today-button{
            display: none;
        }
        #calendar {
            margin-left: 20px;
            font-size: 14px;
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
                <li><a href="api/logout.php" id="logout-button" >Log Out</a></li>
              </ul>
          </li>
        </ul>
        <div id="sidebar-wrapper" class="sidebar-toggle">
            <div id="nav-menu">
                <div class="submenu">
                    <div class="submenu-heading" id="expenses"><a href="adminExpenseManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Expenses.png" alt="expenses" >Expense Management</h5> </a></div>
                </div>
                <div class="submenu">
                    <div class="submenu-heading " id="reportees" ><a href="adminEmployeeManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Reportees.png" alt="leaves" >Employee Management</h5></a> </div>                   
                </div>
                <div class="submenu" >
                    <div class="submenu-heading" id="assets"><a href="adminAssetsManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Assets.png" alt="assets" >Assets Management</h5></a> </div>                   
                </div>
                <div class="submenu" style="background: #373737;">
                    <div class="submenu-heading" id="leaves"><a href="adminLeaveManagement.php" style="text-decoration: none !important;color:#ffffff !important;"> <h5 class="submenu-title" ><img src="images/Leaves-W.png" alt="assets" >Leave Management</h5></a> </div>
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
    <center>   
        <ul class="nav nav-pills" style="display:inline-block;" id="adminLeaveMgmtTabs" >
            <li class="active "><a data-toggle="tab" href="#adminLeaveCalenderTab" >Leave Calender</a></li>
            <li ><a data-toggle="tab" href="#aminLeaveRecordsTab" >Leaves Record</a></li>
            <li ><a data-toggle="tab" href="#adminRestrictedHolidaysTab" >Restricted Holidays</a></li>
            <li ><a data-toggle="tab" href="#adminGeneralHolidaysTab" >General Holidays</a></li>
        </ul>
    </center> 
    <br><br>

    <div class="tab-content" id="myContent">
    <div id="adminLeaveCalenderTab" class="tab-pane fade in active">
        <div id='script-warning'>
        <!--<code>php/get-events.php</code> must be running.-->
        </div>
        <div id='calendar'></div>
        <br><br>
    </div>
    <div id="aminLeaveRecordsTab" class="tab-pane fade ">
        <table class="table table-bordered table-condensed table-hover">
            <thead>
                <tr> <th>S.No.</th> <th>Employee</th> <th>CL+PL+ML</th> <th>Comp Off</th> <th>RH</th> <th>Total Leaves</th> <th>Edit</th> <th>Show</th> </tr>
            </thead>
            <tbody>
            <?php
                $q1="SELECT * FROM user where  status='1' ORDER BY name";
                $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                if ($re1->num_rows > 0) {
                    $index=1;
                    while($ro1 = $re1->fetch_array()){
                        $rp_id=$ro1['id'];
                        $q2="SELECT * from leaves where user_id='$rp_id'";
                        $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                        if ($re2->num_rows > 0) {
                            while($ro2 = $re2->fetch_array()){
                                $total=$ro2['pl_cl_ml']+$ro2['comp_off']+$ro2['rh'];

            ?>
                    <tr id="<?php echo "row".$index;?>" class="rowClass">
                      <td> <?php echo $index."."; ?></td>
                      <td><?php echo $ro1['name']; ?></td>
                      <td >
                        <span id="first_<?php echo $ro2['id']; ?>" class="text"><?php echo $ro2['pl_cl_ml']; ?></span>
                      </td>
                      <td><?php echo $ro2['comp_off']; ?></td>
                      <td  >
                        <span id="second_<?php echo $ro2['id']; ?>" class="text"><?php echo $ro2['rh']; ?></span>
                      </td>
                      <td><?php echo $total;?></td>
                      <td><span class="glyphicon glyphicon-pencil" style="color: #2a409f;cursor: pointer;" id="editleavebtn<?php echo $index; ?>" data-toggle='modal' data-target='#exampleModal2' onclick='modalFunction2()' data-clplml="<?php echo $ro2['pl_cl_ml']; ?>" data-rh1="<?php echo $ro2['rh']; ?>" data-leaveid="<?php echo $ro2['id']; ?>"></span></td>
                      <td class="accordion-toggle" data-toggle="collapse" data-target=<?php echo "#".$index;?> ><span class="glyphicon glyphicon-chevron-down" style="color: #2a409f;cursor: pointer;"></span>
                      </td>
                    </tr>
                    <tr class="accordion-body collapse accordianCol" id="<?php echo $index;?>" style="background: white;">
                        <td colspan="8" >
                            <div class="bs-example"><br>
                                <center>
                                <ul class="nav nav-pills" style="display:inline-block;" id="myTab1" >
                                        <li class="active "  ><a data-toggle="tab" href="<?php echo "#leaveRecords".$index;?>" style="background: white;" >Leave Record</a></li>
                                        <li ><a data-toggle="tab" href="<?php echo "#pendingCompOff".$index;?>" style="background: white;">Pending Comp Off</a></li>
                                    
                                </ul>
                                </center>
                                <div class="tab-content" id="myContent1">
                                    <div id="<?php echo "leaveRecords".$index;?>" class="tab-pane fade in active"><br>

                                    <?php
                                           $query="Select * from leave_data where user_id='$rp_id' AND (status='1' || status='2' || status='4' || status='6') order by for_date DESC";
                                           $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                           if ($result->num_rows > 0) {
                                               
                                                $inc = 1;
                                                $tableRows = array();

                                            ?>
                                            <table  class="table table-hover table-condensed table-bordered" style="table-layout: fixed; width: 1000px;margin-left: 55px;margin-right: 55px;">
                                                <thead>
                                                    <tr>
                                                        <th>S.No.</th>
                                                        <th>Leave Type</th>
                                                        <th>Half/Full</th>
                                                        <th>Count</th>
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
                                                 //   $reason="NA";
                                                  }else if($row['type_id']=="2"){
                                                    $type="Comp Off";
                                                    $againstDate=$row['against_date'];
                                                    $dateCreated2=date_create($againstDate);
                                                    $formattedAgainstDate2=date_format($dateCreated2, 'd-m-Y');
                                                //    $reason=$row['reason'];
                                                  }else if($row['type_id']=="3"){
                                                    $type="RH";
                                                    $formattedAgainstDate2="NA";
                                                 //   $reason="NA";
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
                                                  //  $reason="NA";
                                                  }

                                                  $statusColor="";
                                                  $reason=$row['reason'];
                                                  $statusNum=$row['status'];
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

                                                  echo "<tr>
                                                        <td>".$inc.".</td>
                                                        <td>".$type."</td>
                                                        <td>".$row['half_full']."</td>
                                                        <td>".$count."</td>
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

                                    <div id=<?php echo "pendingCompOff".$index;?> class="tab-pane fade "><br>

                                        <table class="table table-hover table-condensed table-bordered" style="table-layout: fixed; width: 1000px;margin-left: 55px;margin-right: 55px;">
                                                            
                                                            

                                        <?php
                                            $q3="select * from leave_data where user_id='$rp_id' AND type_id='2' order by against_date DESC";
                                            $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                            if ($re3->num_rows > 0) {
                                                $in=1;
                                                ?>
                                                <thead>
                                                                <th>S.No.</th>
                                                                <th>Against Date</th>
                                                                <th>Expiry</th>
                                                                <th>Reason</th>
                                                                <th>Status</th>
                                                            </thead>
                                                            <tbody>
                                                <?php
                                                while($ro3 = $re3->fetch_array()){
                                                          //comp off table
                                                    $color="";
                                                            if($ro3['status']=="3"){
                                                                $status="Available";
                                                                $color= "#7cc576";
                                                            }else if($ro3['status']=="4"){
                                                                $status="Used";
                                                                $color= "#ec585d";
                                                            }else if($ro3['status']=="5"){
                                                                $status="Expired";
                                                                $color= "#fea862";
                                                            }else if($ro3['status']=="1"){
                                                                $status="Applied";
                                                                $color= "#71D3f4";
                                                            }

                                                            $dateCreated1=date_create($ro3['against_date']);
                                                            $formattedAgainstDate1=date_format($dateCreated1, 'd-m-Y');
                                                            $dateCreated2=date_create($ro3['expiry_date']);
                                                            $formattedExpiryDate2=date_format($dateCreated2, 'd-m-Y');

                                                    echo "<tr>
                                                                <td>".$in.".</td>
                                                                <td>".$formattedAgainstDate1."</td>
                                                                <td>".$formattedExpiryDate2."</td>
                                                                <td>".$ro3['compoff_reason']."</td>
                                                                <td style='color:".$color."'>".$status."</td></tr>";

                                                                $in++;
                                                }
                                            }
                                        echo   "</tbody>
                                                          </table>"; ?>
                                    </div>
                                </div>
                            </div>
                            
                        </td>
                    </tr>
                    <?php
                        $index++;}}}}?>
                </tbody>
            </table>
                       
        </div>
        
        <div id="adminRestrictedHolidaysTab" class="tab-pane fade">
        <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1" style="float: right; ">
                    <div class="form-group">
                            <div class="input-group">
                                <input id="date" type="text" class="form-control" name="date"  autocomplete="off" placeholder="Select Date" />
                                <label for="date" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>

                                </label>
                            </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                          <input class="form-control" id="occasion1" type="text" name="occasion1" placeholder="Enter Occasion"/>
                          <span class="input-group-btn">
                            <button class="btn btn-default" id="new-hr-user" style="color: #2a409f;" type="submit"><span class="glyphicon glyphicon-plus" style="color: #2a409f;"></span>&nbsp;Add RH</button>
                          </span>
                        </div>
                    </div>
                </form><br><br>

            <table class="table table-bordered table-hover table-condensed" id="tableItems" >
                <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Occasion</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                          $query="Select * from restricted_holidays order by date";
                          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                                                                     
                                    $dateCreated=date_create($row1['date']);
                                    $formattedDate=date_format($dateCreated, 'd-m-Y');

                                    echo "<tr><td align='left'>".$index.".</td>
                                    <td align='left'>".$row1['occasion']."</td>
                                    <td align='left'>".$formattedDate."</td>
                                    <td>
                                    <span class='glyphicon glyphicon-pencil' id='editbtn".$index."' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1() data-occasion='".$row1['occasion']."' data-date='".$row1['date']."' data-id='".$row1['id']."' style='color: #2a409f;cursor:pointer;'>Edit</span>&nbsp;&nbsp;
                                    <span onclick='deleteRH(".$row1['id'].")' class='glyphicon glyphicon-trash' id='remove".$index."'></span>
                                    
                                   </td>
                                    </tr>";

                                    $index++;
                              }
                          }
                    ?>
                    </tbody>
                </table>
        </div>

        <div id="adminGeneralHolidaysTab" class="tab-pane fade">
            <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1" style="float: right; ">
                <div class="form-group">
                    <div class="input-group">
                        <input id="gh_date" type="text" class="form-control" name="gh_date"  autocomplete="off" placeholder="Select Date" />
                        <label for="gh_date" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input class="form-control" id="gh_occasion" type="text" name="gh_occasion" placeholder="Enter Occasion"/>
                        <span class="input-group-btn">
                            <button class="btn btn-default" id="" style="color: #2a409f;" type="submit"><span class="glyphicon glyphicon-plus" style="color: #2a409f;"></span>&nbsp;Add GH</button>
                        </span>
                    </div>
                </div>
            </form>
            <br><br>

            <table class="table table-bordered table-hover table-condensed" id="tableItems" >
                <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Occasion</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                          $query="Select * from general_holidays order by date";
                          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                                    $dateCreated=date_create($row1['date']);
                                    $formattedDate=date_format($dateCreated, 'd-m-Y');
                                    echo "<tr><td align='left'>".$index.".</td>
                                    <td align='left'>".$row1['occasion']."</td>
                                    <td align='left'>".$formattedDate."</td>
                                    <td>
                                    <span class='glyphicon glyphicon-pencil' id='editbtn".$index."' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-ghoccasion1='".$row1['occasion']."' data-ghdate1='".$row1['date']."' data-ghid='".$row1['id']."' style='color: #2a409f;cursor:pointer;'>Edit</span>&nbsp;&nbsp;<span onclick='deleteGH(".$row1['id'].")' class='glyphicon glyphicon-trash' id='remove".$index."'></span>
                                   </td>
                                    </tr>";
                                    $index++;
                              }
                          }
                    ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>
    
<script type="text/javascript">
$(document).ready(function(){
      document.getElementById("login_admin_name").prepend(localStorage.getItem('adminName'));
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
      $('#page-wrapper').css('width',screen.width-270);

      $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeLeaveMgmtTabs', $(e.target).attr('href'));
        });
        var activeLeaveMgmtTabs = localStorage.getItem('activeLeaveMgmtTabs');
        if(activeLeaveMgmtTabs){
            $('#adminLeaveMgmtTabs a[href="' + activeLeaveMgmtTabs + '"]').tab('show');
        }

        $('#calendar').fullCalendar({
           // theme: true,
          header: {
            //left: 'prev,next today',
            //center: 'title',
            //right: 'month'
          },
          defaultDate: new Date(),
          editable: true,
          //navLinks: true, // can click day/week names to navigate views
          eventLimit: true, // allow "more" link when too many events
          events: {
            url: 'reportees-calender/php/get-events.php',
            error: function() {
              $('#script-warning').show();
            }
          },
          loading: function(bool) {
            $('#loading').toggle(bool);
          }
      });

    $(".edit_td").click(function()
    {
        var ID=$(this).attr('id');
        $("#first_"+ID).css("display","none")
        $("#first_input_"+ID).css("display","block")
    }).change(function(){
        var ID=$(this).attr('id');
        var first=$("#first_input_"+ID).val();
        var dataString = 'id='+ ID +'&first='+first;

        if(first.length>0){
            $.ajax({
                type: "POST",
                url: "cl_pl_ml_edit_ajax.php",
                data: dataString,
                cache: false,
                success: function(data){
                  if(data==1){
                      alert("success");
                      window.location.reload();
                  }  
                }
            });
        }else{
            alert('Enter something.');
        }
    });

    // Edit input box click action
    $(".editbox").mouseup(function(){
        return false
    });

    $(".edit_td1").click(function(){
        var ID=$(this).attr('id');
        $("#second_"+ID).css("display","none")
        $("#second_input_"+ID).css("display","block")
    }).change(function(){
        var ID=$(this).attr('id');
        var first=$("#second_input_"+ID).val();
        var dataString = 'id='+ ID +'&first='+first;

        if(first.length>0){
            $.ajax({
                type: "POST",
                url: "rh_edit_ajax.php",
                data: dataString,
                cache: false,
                success: function(data){
                  if(data==1){
                      alert("success");
                      window.location.reload();
                  }  
                }
            });
        }else{
            alert('Enter something.');
        }
    });

    // Edit input box click action
    $(".editbox").mouseup(function(){
        return false
    });
    // Outside click action
    $(document).mouseup(function(){
        $(".editbox").css("display","none")
        $(".text").css("display","block")
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
      localStorage.removeItem('filter-master-projects');
      localStorage.removeItem('filter-master-expense-categories');
      localStorage.removeItem('filter-master-assets');
      localStorage.removeItem('filter-master-employees');
});

function deleteRH(rhId){
    var r = confirm("Are you sure you want delete this RH?");
    if (r == true) {
        $.ajax({
            url: "api/adminLeaveManagementAPI.php",
            type: "POST",
            data: "ACTION=deleteRH&rhId="+rhId,
            success: function(data){
                if(data=='1'){
                    alert("RH deleted!");
                    window.location.href = window.location.href;
                }
            }
        })
    }
}

function deleteGH(ghId){
    var r = confirm("Are you sure you want delete this GH?");
    if (r == true) {
        $.ajax({
            url: "api/adminLeaveManagementAPI.php",
            type: "POST",
            data: "ACTION=deleteGH&ghId="+ghId,
            success: function(data){
                if(data=='1'){
                    alert("GH deleted!");
                    window.location.href = window.location.href;
                }
            }
        })
    }
}

function modalFunction1(){
    $("#exampleModal1").on("show.bs.modal", function (event){
        var button = $(event.relatedTarget);
        var occasion = button.data('occasion');
        var date = button.data('date');
        var id = button.data('id');
        var modal = $(this);
        modal.find('.modal-title').text('Update RH: ' + occasion);
        
        $('#exampleModal1').find('input#id').val($(event.relatedTarget).data('id'));
        $('#exampleModal1').find('input#occasion').val($(event.relatedTarget).data('occasion'));
        $('#exampleModal1').find('input#date1').val($(event.relatedTarget).data('date'));
    });
}

function modalFunction3(){
    $("#exampleModal3").on("show.bs.modal", function (event){
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('.modal-title').text('Update GH: ');
        
        $('#exampleModal3').find('input#ghid').val($(event.relatedTarget).data('ghid'));
        $('#exampleModal3').find('input#ghoccasion1').val($(event.relatedTarget).data('ghoccasion1'));
        $('#exampleModal3').find('input#ghdate1').val($(event.relatedTarget).data('ghdate1'));
    });
}

function modalFunction2(){
    $("#exampleModal2").on("show.bs.modal", function (event){
        var button = $(event.relatedTarget);
        var occasion = button.data('occasion');
        var date = button.data('date');
        var id = button.data('id');
        var modal = $(this);
        modal.find('.modal-title').text('Update Leaves: ');
        
        $('#exampleModal2').find('input#leaveid').val($(event.relatedTarget).data('leaveid'));
        $('#exampleModal2').find('input#clplml').val($(event.relatedTarget).data('clplml'));
        $('#exampleModal2').find('input#rh1').val($(event.relatedTarget).data('rh1'));
    });            
}
</script>
     
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">New </h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="api/adminLeaveManagementAPI.php">
                    <div class="form-group ">
                        <label for="occasion" class="control-label"> Occasion:</label>
                        <input type="text" class="form-control col-sm-4" id="occasion" name="occasion" >
                    </div>
                    <div class="form-group ">
                        <label for="date1" class="control-label">  Date:</label>
                        <input type="date" class="form-control col-sm-4" id="date1" name="date1" >
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id" id="id">
                    </div>
                    <input type="hidden" name="ACTION" id="ACTION" value="updateRH">
                    <button type="button-inline" id="submit" class="btn btn-default" name="submit" value="submit">Update</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">New </h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="api/adminLeaveManagementAPI.php">
                    <div class="form-group ">
                        <label for="ghoccasion1" class="control-label"> Occasion:</label>
                        <input type="text" class="form-control col-sm-4" id="ghoccasion1" name="ghoccasion1" >
                    </div>
                    <div class="form-group ">
                        <label for="ghdate1" class="control-label">  Date:</label>
                        <input type="date" class="form-control col-sm-4" id="ghdate1" name="ghdate1" >
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="ghid" id="ghid">
                    </div>
                    <input type="hidden" name="ACTION" id="ACTION" value="updateGH">
                    <button type="button-inline" id="submit" class="btn btn-default" name="submit" value="submit">Update</button>
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
                <h4 class="modal-title" id="exampleModalLabel2">New </h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="api/adminLeaveManagementAPI.php">
                    <div class="col-sm-12">
                        <label for="clplml" class="control-label col-sm-4"> CL+PL+ML</label>
                        <div class="form-group col-sm-6">
                            <input type="number" class="form-control " id="clplml" name="clplml" step="0.1">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label for="rh1" class="control-label col-sm-4">  RH</label>
                        <div class="form-group col-sm-6">
                            <input type="number" class="form-control col-sm-4" id="rh1" name="rh1" step="0.1">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="leaveid" id="leaveid">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="ACTION" id="ACTION" value="updateLeaves">
                    </div>
                    <div class="col-sm-offset-5">
                        <button type="submit" class="btn btn-primary"  value="submit">Update</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
            </div>
        </div>
    </div>
</div>
 
</body>
</html>