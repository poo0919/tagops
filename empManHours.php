<?php
include 'api/empSession.php';
include 'api/config.php';
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
    $( "#of_date" ).datepicker({ dateFormat: 'yy-mm-dd', maxDate: "m" });
    $( "#of_date" ).val($.datepicker.formatDate("yy-mm-dd", new Date()));
  });

</script>
<style type="text/css">
  #outer
  {
      width:100%;
      text-align: center;
  }
  .inner
  {
      display: inline-block;
  }
  body{
    background-color: #eeeeee;
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
 
    .btn-twitter {
      padding-left: 30px;
      background: rgba(0, 0, 0, 0) url(https://platform.twitter.com/widgets/images/btn.27237bab4db188ca749164efd38861b0.png) -20px 6px no-repeat;
      background-position: -20px 11px !important;
    }
    .btn-twitter:hover {
      background-position:  -20px -18px !important;
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
      <div class="submenu">
        <div class="submenu-heading" id="expenses"><a href="empExpenses.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Expenses.png" alt="expenses" >Expenses</h5> </a></div>                   
      </div>
      <div class="submenu">
        <div class="submenu-heading" id="leaves"><a href="empLeaves.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" id="leaves"><img src="images/Leaves.png" alt="leaves" >Leaves</h5></a> </div>                   
      </div>
      <div class="submenu" >
        <div class="submenu-heading" id="assets"><a href="empAssets.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" id="assest"><img src="images/Assets.png" alt="assets" >Assets</h5></a> </div>                   
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
      <div class="submenu" style="background: #373737;">
        <div class="submenu-heading" id="manhours"><a href="empManHours.php" style="text-decoration: none !important;color:#ffffff;"> <h5 class="submenu-title" id="manhours"><img src="images/Man-Hours-W.png" alt="manhours" >Man Hours</h5></a> </div>                   
      </div>
    </div>
  </div>
</div>
</nav>


<div id="page-wrapper" class="container" >
  <div class="bs-example">
  <center>   
    <ul class="nav nav-pills" style="display:inline-block;" id="myTab" >
      <li class="active " ><a data-toggle="tab" href="#man_hours_log_tab" >MAN HOURS LOG</a></li>
      <li class=" " ><a data-toggle="tab" href="#new_log_tab" >NEW LOG</a></li>
    </ul>
  </center> 
     
  <div class="tab-content" id="myContent">
    <div id="man_hours_log_tab" class="tab-pane fade in active">
    <br><br>
    <div id="outer">
      <?php
        $date=""; $val="";
          if(isset($_POST['date'])){ 
            $date=$_POST['date'];
            if(isset($_POST['sub'])){
              $date=date('Y-m-d', strtotime("-1 months", strtotime($date))); $val="sub";
            }else if(isset($_POST['add'])){
              $date=date('Y-m-d', strtotime("+1 months", strtotime($date))); $val="add";
            }
          }else {
            $date=date('Y-m-d');
          }
      ?>
          <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" class="inner">
              <input type="hidden" name="sub" value="1"><br>
              <input type="hidden" name="date" value=<?php
                echo $date;
                 ?>>
              <button type="submit" class="btn btn-primary" id="backward"><span class='glyphicon glyphicon-chevron-left'></span></button>
          </form>
          <div class="inner">
            <h4 id="displayDate"><?php
                $displayDate=date('F Y',strtotime($date));
                echo $displayDate;
            ?>
            </h4>
          </div>
          <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" class="inner">
              <input type="hidden" name="add" value="1"><br>
              <input type="hidden" name="date" value=<?php 
                  echo $date;
                 ?>>
              <button type="submit" class="btn btn-primary" id="forward"><span class='glyphicon glyphicon-chevron-right'></span></button>
          </form>
  </div>
      <br>
      <div>
        <table class="table table-bordered table-condensed" style="max-width: 900px;">
            <?php
              $user_id=$_SESSION['userid']; $joining_date=""; $startManHours = "";
              $usql = "SELECT joining_date FROM user WHERE id=$user_id";
              $ure=mysqli_query($conn,$usql)or die(mysqli_error($conn));
              if ($ure->num_rows > 0) {
                $uro = $ure->fetch_array();
                $joining_date = $uro['joining_date'];
              }

              if($joining_date=="0000-00-00")
                $startManHours = $manHoursModuleStartDate;
              else if($joining_date>$manHoursModuleStartDate)
                $startManHours = $joining_date;
              else
                $startManHours = $manHoursModuleStartDate;

              $usql1 = "SELECT * FROM leave_data WHERE user_id='$user_id' AND (status='2' || status='4') ";
              $ure1 = mysqli_query($conn,$usql1)or die(mysqli_error($conn)); $leavearray = [];
              if ($ure1->num_rows > 0) {
                while($uro1 = $ure1->fetch_array()){
                  if($uro1['type_id']==1 ){
                    if($uro1['half_full']=="Half"){
                      $leavearray[$uro1['for_date']] = true;
                    }else if($uro1['half_full']=="Full" && empty($uro1['to_date'])){
                      $leavearray[$uro1['for_date']] = true;
                    }else if($uro1['half_full']=="Full" && $uro1['to_date']==$uro1['for_date']){
                      $leavearray[$uro1['for_date']] = true;
                    }else{
                      $begin = new DateTime($uro1['for_date']);
                      $end = new DateTime($uro1['to_date']);
                      $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
                      foreach($daterange as $datexx){
                        $date1 = $datexx->format("Y-m-d");
                        $leavearray[$date1] = true;
                      }
                      $leavearray[$uro1['to_date']] = true;
                    }
                  }else if($uro1['type_id']==2 || $uro1['type_id']==3){
                    $leavearray[$uro1['for_date']] = true ;
                  }
                }
              }
              //echo var_dump($leavearray);

              $currentDate=date('Y-m-d'); $flag=0;
              for($i = 1; $i <=  date('t', strtotime($date)); $i++){
                // add the date to the dates array
                $dates[] = date('Y', strtotime($date)) . "-" . date('m', strtotime($date)) . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                
                if($dates[$i-1]>=$currentDate && ($val=="add" || $val=="")){
                  echo "<script language='javascript'>document.getElementById('forward').disabled = true;</script>";
                  $flag=1;
                  break;
                }
                if($dates[$i-1]==$startManHours && ($val=="sub" || $val=="")){
                  echo "<script language='javascript'>document.getElementById('backward').disabled = true;</script>";
                }
              }
              $length = sizeof($dates);

              echo "<thead>
                  <tr><th>S.No.</th><th>Date</th><th>Total Hours</th><th>Show</th></tr>
                    </thead>
                    <tbody>";
              for($i=0;$i<$length;$i++){

                $q1="SELECT SUM(hours) as sum,date,half_full FROM man_hours_log where user_id='$user_id' AND date='$dates[$i]' GROUP BY date";
                $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                if ($re1->num_rows > 0) {
                  $index=$i+1;
                  while($ro1 = $re1->fetch_array()){
            ?>
                    <tr id=<?php echo "row".$i;?> class="rowClass">
                      <td><?php echo $index."."; ?></td>
                      <td><?php $dateCreated1=date_create($ro1['date']); $formattedForDate1=date_format($dateCreated1, 'd-m-Y'); echo $formattedForDate1; ?></td>
                      <td><?php echo $ro1['sum']; ?></td>
                      <td class='accordion-toggle' data-toggle='collapse'  data-target=<?php echo "#".$index;?>><span class='glyphicon glyphicon-chevron-down'></span></td>
                    </tr>
                    <tr class="accordion-body collapse accordianCol" id=<?php echo $index;?> style="background: white;">
                      <td colspan="5" >
                        <div class="bs-example"><br>
                          <?php
                            $query="Select * from man_hours_log where user_id='$user_id' AND date='$ro1[date]'";
                            $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                            if ($result->num_rows > 0) {
                              $inc = 1; 
                          ?>
                          <table  class="table table-hover table-condensed table-bordered" style="table-layout: fixed; width: 1000px;margin-left: 55px;">
                            <thead> <tr> <th>S.No.</th> <th>Project</th> <th>Hours</th> <th>Description</th> </tr> </thead> 
                            <tbody>
                            <?php 
                              while ($row = $result->fetch_array()){
                                $projectid=$row['project_id']; $projectName="";
                                $sql2="select * from projects where id=$projectid";
                                $resultset=mysqli_query($conn,$sql2)or die(mysqli_error($conn));
                                if ($resultset->num_rows > 0) {
                                  while ($rowset = $resultset->fetch_array()) {
                                    $projectName=$rowset['name'];
                                  }
                                }
                                echo "<tr> <td>".$inc.".</td> <td>".$projectName."</td> <td>".$row['hours']."</td> <td>".$row['description']."</td> </tr>";
                                $inc++; 
                              }
                            }
                            ?>
                            </tbody></table> 
                        </div><?php
                          }
                        }else{ 
                            $date = $dates[$i];
                            $weekendDay = false;
                            $day="";
                            if(date('w', strtotime($date))== 6 ){
                                //Set our $weekendDay variable to TRUE.
                                $weekendDay = true; $day.='Saturday';
                            }else if(date('w', strtotime($date))== 0){
                                $weekendDay = true; $day.='Sunday';
                            }
                            
                            if($weekendDay==true){ ?>
                            <tr  class="rowClass" style="background-color: #EEF4FF;">
                              <td><?php $index=$i+1; echo "$index."; ?></td>
                              <td><?php $dateCreated1=date_create($dates[$i]);
                                $formattedForDate1=date_format($dateCreated1, 'd-m-Y'); echo $formattedForDate1; ?> </td>
                              <td>0</td>
                                  <td style="color: #0046C2;"><?php echo $day; ?> </td>
                            </tr>
                          <?php  }else if(array_key_exists($dates[$i],$leavearray)){
                            ?>
                            <tr  class="rowClass" style="background-color: #D6FFD4;">
                              <td><?php $index=$i+1; echo "$index."; ?></td>
                              <td><?php $dateCreated1=date_create($dates[$i]);
                                $formattedForDate1=date_format($dateCreated1, 'd-m-Y'); echo $formattedForDate1; ?> </td>
                              <td>0</td>
                                  <td style="color: #089D01;"><?php echo "LEAVE"; ?> </td>
                            </tr>
                            <?php
                          }else{
                          echo "<script type='text/javascript'>document.getElementById('displayDate').style.color = '#FF0000';</script>"; ?>
                            <tr  class="rowClass" style="background-color: #FFE6E6;">
                          <td><?php $index=$i+1; echo "$index."; ?></td>
                          <td><?php $dateCreated1=date_create($dates[$i]);
                            $formattedForDate1=date_format($dateCreated1, 'd-m-Y'); echo $formattedForDate1; ?> </td>
                          <td>0</td>
                            <td><span class='glyphicon glyphicon-remove' style="color: #FF0000;"></span></td>
                        </tr>
                          <?php }
                          ?>
                      <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div id="new_log_tab" class="tab-pane fade">
      <br><br>
          <div class="row col-sm-12">
            <div class="form-group col-sm-4"> 
              <label class="control-label col-sm-4 " for="of_date">Log Date</label>
              <div class="col-sm-8">
                <input type="text" class="form-control dateSelector" id="of_date" name="of_date" placeholder="Select Date">
              </div>
            </div>
            <div class="form-group col-sm-4"> 
              <label class="control-label col-sm-4 " for="half_full">Half/Full</label>
              <div class="col-sm-8">
                <select class='form-control select' id='half_full' name='half_full'>
                  <option value='Full' >Full</option>
                  <option value='Half' >Half</option>
                </select>
              </div>
            </div>
            <button type="button" class="btn btn-primary" id="add" name="add" style="float: right;margin-right: 100px;">Add Row</button>
          </div>
        <form class="form-horizontal row" id="form" style="padding-left: 30px;">
          <br><br><br><br>
          <div id="buttons" class="row">  
            <center>
              <button type="button" class="btn btn-success" id="submit" name="submit">Submit</button>
              
            </center>
          </div>
        </form>
      </div>
      <br>                
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

  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeManHoursTabs', $(e.target).attr('href'));
  });
  var activeManHoursTabs = localStorage.getItem('activeManHoursTabs');
  if(activeManHoursTabs){
    $('#myTab a[href="' + activeManHoursTabs + '"]').tab('show');
  }

  
  $('#add').click(function() {
    var element = "<div class='row col-sm-12'>"+
                    "<div class='form-group col-sm-3'>"+ 
                      "<label class='control-label col-sm-4' for='projectid'>Project:</label>"+
                      "<div class='col-sm-8'>"+
                        "<select class='form-control select selectproject' id='projectid' name='projectid'>"+
                          "<option value='0' >--select--</option>"+
                        "</select>"+
                      "</div>"+
                    "</div>"+    
                    "<div class='form-group col-sm-3'>"+ 
                      "<label class='control-label col-sm-4' for='hours'>Hours:</label>"+
                      "<div class='col-sm-8'>"+
                        "<input type='number' class='form-control' id='hours' step='0.1' name='hours' placeholder='Enter Hours'>"+
                      "</div>"+
                    "</div>"+
                    "<div class='form-group col-sm-6'>"+ 
                      "<label class='control-label col-sm-4 ' for='description'>Description:</label>"+
                      "<div class='col-sm-8'>"+
                        "<textarea class='form-control' id='description' name='description' rows='4' maxlength='100' placeholder='Describe in brief'></textarea>"+
                      "</div>"+
                    "</div>"+
                  "</div>";       
                  
    $("#buttons").prepend(element);
    
    $.ajax({
      url: "api/getProjectList.php",
      type: "GET",
      contentType: false,
      processData: false,
      success: function(response){ 
        response = JSON.parse(response);
        console.log(response);
        var markup;
        for (var i=0; i <response.length; i++) {   
          var markup = markup + '<option value='+response[i].id+'>'+response[i].name+'</option>';
        }
        
        $('.selectproject').append(markup);
        var select = $('#form').find('select');
        for (var i = 0; i < select.length; i++) {
          $(select[i]).removeClass("selectproject");
        }
      }
    });
  });

  $('#submit').click(function() {
    var man_hours_log = buildRequestStringData($('#form'));
    $.ajax({
      type: "POST",
      data: {man_hours_log:man_hours_log},
      url: "api/empManHoursAPI.php",
      success: function(response){
        var data=$.trim(response);
        if(data=="0"){
          alert("Submit Again!");
        }else if(data=="1"){
          alert("Log Submitted.");
          window.location.reload();
        }
      }
    });

  });

  document.getElementById("login_user_name").prepend(localStorage.getItem('name'));

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

function buildRequestStringData(form) {
  var select = form.find('select'), input = form.find('input'), textarea = form.find('textarea'), data1 = [],sum=0;
  var length = select.length;
  for (var i = 0; i < length; i++) {

    var data = {};

    if($(select[i]).val()!=""){
      data[$(select[i]).attr('name')]=$(select[i]).val();
    }else {
      alert("Fill all the fields!");
      return;
    }
    
    if($(input[i]).val()!=""){
      data[$(input[i]).attr('name')]=$(input[i]).val();
      sum=sum+$(input[i]).val();
    }else {
      alert("Fill all the fields!");
      return;
    }

    if($(textarea[i]).val()!=""){
      data[$(textarea[i]).attr('name')]=$(textarea[i]).val();
    }else {
      alert("Fill all the fields!");
      return;
    }
    
    data1[i]=data;
  }
  console.log("sum: "+sum);
  if($("#half_full").val()=="Half"){
    if(sum>24){
      alert("Not Possible as working hours in a day can't be more than 24.");
      return;
    }else if(sum>=4){

    }else{
      alert("For half day sum of working hours should be greater than 4.");
      return;
    }
  }else if($("#half_full").val()=="Full"){
    if(sum>24){
      alert("Not Possible as working hours in a day can't be more than 24.");
      return;
    }else if(sum>=8){

    }else{
      alert("For full day sum of working hours should be greater than 8.");
      return;
    }
  }
  data1.push($("#of_date").val());
  data1.push($("#half_full").val());
  data1.push(localStorage.getItem('user_id'));
  console.log("json data1: "+JSON.stringify(data1));
  console.log("date: "+ data1[length]);
  console.log("half/full: "+ data1[length++]);
  return JSON.stringify(data1);
}

</script>
</html>