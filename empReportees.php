<?php
include 'empSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Employee Reportees - TagOps</title>

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
.btn{
      width: 72px;
      height: 25px;
      color: white;
    }
</style>
<script>
  $( function() {
    $( "#againstDate" ).datepicker({ dateFormat: 'yy-mm-dd' });
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
                    <div class="submenu-heading" id="leaves" > <h5 class="submenu-title" id="leaves"><img src="Leaves.png" alt="leaves" >Leaves</h5> </div>                   
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
            <li class="active " ><a data-toggle="tab" href="#myReporteesTab" >MY REPORTEES</a></li>
            <li ><a data-toggle="tab" href="#leaveRequestsTab" >LEAVE REQUESTS</a></li>
            
        </ul></center> <br><br>
     

        <div class="tab-content" id="myContent">
            
            <div id="myReporteesTab" class="tab-pane fade in active">
            <table class="table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Employee</th>
                        <th>CL+PL+ML</th>
                        <th>Comp Off</th>
                        <th>RH</th>
                        <th>Total Leaves</th>    
                        <th>Show</th>                    
                    </tr>
                </thead>
                <tbody>
                <?php
                    include 'connection.php';
                        $user_id=$_SESSION['userid'];

                        $q1="SELECT * FROM user where rm_id='$user_id' AND status='1' ORDER BY name";
                        $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                        if ($re1->num_rows > 0) {
                            $index=1;
                            while($ro1 = $re1->fetch_array()){
                                $rp_id=$ro1['id'];

                                $q2="select * from leaves where user_id='$rp_id'";
                                $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                if ($re2->num_rows > 0) {
                                    while($ro2 = $re2->fetch_array()){
                                        //pl cl leaves table
                                        $total=$ro2['pl_cl_ml']+$ro2['comp_off']+$ro2['rh'];

                ?>
                    <tr id=<?php echo "row".$index;?> class="rowClass">
                        <td><?php echo $index."."; ?></td>
                        <td><?php echo $ro1['name']; ?></td>
                        <td><?php echo $ro2['pl_cl_ml']; ?></td>
                        <td><?php echo $ro2['comp_off']; ?></td>
                        <td><?php echo $ro2['rh']; ?></td>
                        <td><?php echo $total;?></td>
                        <td class='accordion-toggle' data-toggle='collapse' onclick='changeRowColor(<?php echo "row".$index;?>)' data-target=<?php echo "#".$index;?>><span class='glyphicon glyphicon-chevron-down'></span>
                        </td>
                    </tr>
                    <tr class="accordion-body collapse accordianCol" id=<?php echo $index;?> style="background: white;">
                        <td colspan="7" >
                            <div class="bs-example"><br>
                                <center><ul class="nav nav-pills" style="display:inline-block;" id="myTab1" >
                                        <li class="active "  ><a data-toggle="tab" href=<?php echo "#leaveRecords".$index;?> style="background: white;" >Leave Records</a></li>
                                        <li ><a data-toggle="tab" href=<?php echo "#pendingCompOff".$index;?> style="background: white;">Pending Comp Off</a></li>
                                    
                                </ul></center>
                             

                                <div class="tab-content" id="myContent">
                                    
                                    <div id=<?php echo "leaveRecords".$index;?> class="tab-pane fade in active"><br><br>

                                    <?php
                                           $query="Select * from leave_data where user_id='$rp_id' AND (status='2' OR status='4')";
                                           $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                           if ($result->num_rows > 0) {
                                               
                                                $inc = 1;
                                                $tableRows = array();

                                            ?>
                                            <table  class="table table-hover table-condensed table-bordered" style="table-layout: fixed; width: 1000px;margin-left: 55px;">
                                                <thead>
                                                    <tr>
                                                        <th>S.No.</th>
                                                        <th>Leave Type</th>
                                                        <th>Leave Date</th>
                                                        <th>Against Date</th>
                                                        <th>Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <?php
                                                while ($row = $result->fetch_array()){

                                                  $type="";
                                                  $againstDate="";
                                                  $reason="";

                                                  $dateCreated1=date_create($row['for_date']);
                                                  $formattedForDate1=date_format($dateCreated1, 'd-m-Y');
                                                    

                                                  if($row['type_id']=="1"){
                                                    $type="CL+PL+ML";
                                                    $formattedAgainstDate2="NA";
                                                    $reason="NA";
                                                  }else if($row['type_id']=="2"){
                                                    $type="Comp Off";
                                                    $againstDate=$row['against_date'];
                                                    $dateCreated2=date_create($againstDate);
                                                    $formattedAgainstDate2=date_format($dateCreated2, 'd-m-Y');
                                                    $reason=$row['reason'];
                                                  }else if($row['type_id']=="3"){
                                                    $type="RH";
                                                    $formattedAgainstDate2="NA";
                                                    $reason="NA";
                                                  }

                                                  echo "<tr>
                                                        <td>".$inc.".</td>
                                                        <td>".$type."</td>
                                                        <td>".$formattedForDate1."</td>
                                                        <td>".$formattedAgainstDate2."</td>
                                                        <td>".$reason."</td>
                                                  </tr>";

                                                
                                                    

                                                   
                                                    $inc++;    
                                                }
                                                ?></tbody></table> <?php
                                                                                                
                                           }
                                    ?>
                                    </div>

                                    <div id=<?php echo "pendingCompOff".$index;?> class="tab-pane fade ">

                                    <button id=<?php echo "editbtn".$index;?> type='button' class='btn btn-sm' style="float: right;margin-right: 72px;background-color: #2a409f;" data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1() data-userid=<?php  echo $_SESSION['userid'];; ?> data-rpid=<?php echo $ro1['id'];?>><span class='glyphicon glyphicon-plus'></span> Add</button><br><br>

                                        <table class="table table-hover table-condensed table-bordered" style="table-layout: fixed; width: 1000px;margin-left: 55px;">
                                                            
                                                            

                                        <?php
                                            $q3="select * from leave_data where user_id='$rp_id' AND type_id='2' order by against_date";
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
                                                                <th>Action</th>
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
                                                                <td>".$ro3['reason']."</td>
                                                                <td style='color:".$color."'>".$status."</td><td>";

                                                                if($status=="Available"){

                                                                        echo  "<span onclick=deleteCompOffEntry(".$ro3['id'].",".$ro1['id'].") style='color: black;'><i class='fa fa-trash'></i></span>

                                                                       </td></tr>";

                                                                }else{
                                                                    echo  "<span style='color:#a8a8a8 ;'><i class='fa fa-trash'></i></span>

                                                                       </td></tr>";
                                                                }
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
            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                              <h4 class="modal-title" id="exampleModalLabel1">New </h4>
                                          </div>
                                          <div class="modal-body">
                                              <form method="POST" action="addNewCompOff.php" id="compOffForm">
                                                  <div class="form-group">
                                                      <label for="againstDate" class="control-label">Against Date:</label>
                                                      <input type="text" class="form-control" id="againstDate" name="againstDate" >
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="reason" class="control-label">Reason:</label>
                                                      <input type="text" class="form-control" id="reason" name="reason" >
                                                  </div>
                                                  <div class="form-group">
                                                      <input type="hidden" name="rpId" id="rpId">
                                                  </div>
                                                  <div class="form-group">
                                                      <input type="hidden" name="userId" id="userId">
                                                  </div>
                                                  <button type="button-inline" id="addNewCompOff" class="btn btn-primary" style="width: 70px;height: 34px;" name="addNewCompOff">Add</button>
                                              </form>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 70px;height: 34px; " >Cancel</button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <script type="text/javascript">
                                  function modalFunction1(){
                                       $("#exampleModal1").on("show.bs.modal", function (event){
                                            var button = $(event.relatedTarget);
                                            var id = button.data('id');

                                            var modal = $(this);
                                            modal.find('.modal-title').text('Add new comp off ');

                                           $('#exampleModal1').find('input#rpId').val($(event.relatedTarget).data('rpid'));
                                           $('#exampleModal1').find('input#userId').val($(event.relatedTarget).data('userid'));
                                      
                                       });
                                       
                                  }
                              </script>
            </div>

            <div id="leaveRequestsTab" class="tab-pane fade ">
            
            <table class="table table-condensed table-bordered table-hover" >
                                

                                <?php
                              $user_id=$_SESSION['userid'];

                                    $q2="SELECT * FROM user where rm_id='$user_id' ORDER BY name";             
                                    $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                    if ($re2->num_rows > 0) {
                                        while($ro2 = $re2->fetch_array()){
                                              $reportee_id=$ro2['id'];
                                            $q3="select * from leave_data where user_id='$reportee_id'AND status='1'";
                                            $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                            if ($re3->num_rows > 0) {
                                                $index=1;
                                                ?>
                                                <thead>
                                                <tr>
                                                    <th>S.no</th>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>For Date</th>
                                                    <th>Against Date</th>
                                                    <th>Reason</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                  </tr>
                                                </thead>

                                                <tbody >
                                                <?php
                                                while($ro3 = $re3->fetch_array()){

                                                    $dateCreated1=date_create($ro3['for_date']);
                                                    $formattedForDate1=date_format($dateCreated1, 'd-m-Y');
                                                    
                                                    $formattedAgainstDate2="";
                                                    if($ro3['type_id']=="1"){
                                                        $type="CL+PL+ML";
                                                        $formattedAgainstDate2="NA";
                                                    }else if($ro3['type_id']=="2"){
                                                        $type="Comp Off";
                                                        $againstDate=$ro3['against_date'];
                                                        $dateCreated2=date_create($againstDate);
                                                        $formattedAgainstDate2=date_format($dateCreated2, 'd-m-Y');
                                                    }else if($ro3['type_id']=="3"){
                                                        $type="RH";
                                                        $formattedAgainstDate2="NA";
                                                    }

                                                    if($ro3['status']=="1"){
                                                        $status="Applied";
                                                    }else if($ro3['status']=="4"){
                                                        $status="Used";
                                                    }else if($ro3['status']=="6"){
                                                        $status="Rejected";
                                                    }else if($ro3['status']=="5"){
                                                        $status="Expired";
                                                    }
                                                    

                                                    echo "<tr>
                                                            <td>".$index.".</td>
                                                            <td>".$ro2['name']."</td>
                                                            <td>".$type."</td>
                                                            <td>".$formattedForDate1."</td>
                                                            <td>".$formattedAgainstDate2."</td>
                                                            <td>".$ro3['reason']."</td>
                                                            <td>".$status."</td><td>";


                                                            if($status=="Applied"){
                                                            echo "<button id='rejectbtn".$index."' onclick='rejectLeaveRequest(".$ro3['id'].",".$ro3['type_id'].",".$ro2['id'].")' class='btn btn-xs' style='background-color: #ec585d;color='#ffffff'>Reject</button><button id='changebtn".$index."' onclick='approveLeaveRequest(".$ro3['id'].",".$ro3['type_id'].",".$ro2['id'].")' class='btn btn-xs' style='background-color: #7cc576; color:'#ffffff'> Approve</button>";
                                                            }
                                                           echo "</td></tr>";


                                                $index++;
                                                }
                                               
                                            }


                                        }
                                    }

                                    
                                ?>


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

        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeEmpReporteesTabs', $(e.target).attr('href'));
        });
        var activeEmpReporteesTabs = localStorage.getItem('activeEmpReporteesTabs');
        if(activeEmpReporteesTabs){
            $('#myTab a[href="' + activeEmpReporteesTabs + '"]').tab('show');
        }

        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeCollapsibleTab', $(e.target).attr('href'));
        });
        var activeCollapsibleTab = localStorage.getItem('activeCollapsibleTab');
        if(activeCollapsibleTab){
            $('#myTab1 a[href="' + activeCollapsibleTab + '"]').tab('show');
        }

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
       $('#leaveType').change(function(){
                        if($(this).val()=="4"){
                            $('#against_date').show();
                        }else{
                          $('#against_date').hide();
                        }
                      });
          });
                 


           $("#addNewCompOff").click(function(e) {
                var reason = $("#reason").val();
                var againstDate = $("#againstDate").val();
                var rpId = $("#rpId").val();
                var userId = $("#userId").val();

                $.ajax({
                        url: "addNewCompOff.php",
                        type: "POST",
                        data: "action=newCompOff&againstDate="+againstDate+"&reason="+reason+"&rpId="+rpId+"&userId="+userId,
                       
                        success: function(data){
                             if(data=="2"){
                                alert("Field is empty!");
                            }else if(data=="0"){
                              alert("Comp Off can't be added!");
                            }else{
                              //alert(data);
                                var subject="New Comp Off Given";
                                var message="<p>Hi,<br><br>You are assigned a new Comp Off <b>Against date:</b> <i>"+againstDate+"</i> for <b>reason:</b> <i>"+reason+"</i>.<br><br>Thanks.</p>";
                                var cc="";
                                $.ajax({
                                                                                   
                                    url: "http://dev.tagbin.in/phpHandler/mailer/mailgun/tagbinMailer.php",
                                    type: "POST",
                                    data: "_ACTION=send_email&_SUBJECT="+subject+"&_EMAIL="+data+"&_MESSAGE="+message+"&_CC="+cc,
                                    success: function(data){
                                        alert("Mail has been sent!");
                                        $('#compOffForm')[0].reset();
                                    }
                                })
                                window.location.reload();
                                //href=window.location.href;
                                  alert("New Comp Off Assigned and Mail is sent");
                                  $('#compOffForm')[0].reset();
                                    

                            }
                        }
                    })



           });
     
                            
    });

    function changeRowColor(rowId){
       // $(".accordianCol").accordion({collapsible : true, active : 'none'});
       // $('#1').attr('area-expanded','false');
      
    /*   if($(rowId).css('background-color') == '#FFFFFF'){
             $(rowId).css('background-color','#eeeeee');
       }else{
            $( ".rowClass" ).css('background-color','#eeeeee');
            $(rowId).css('background-color','#FFFFFF');
       }*/
        
        
    }

    function rejectLeaveRequest(applyLeaveId,leaveTypeId,userId){

         var r = confirm("Are you sure you want reject this Leave Request?");
                    if (r == true) {
                        $.ajax({
                                    url: "rejectLeaveRequest.php",
                                    type: "POST",
                                    data: "ACTION=reject&applyLeaveId="+applyLeaveId+"&leaveTypeId="+leaveTypeId+"&userId="+userId,
                                    success: function(data){
                                        
                                        if(data=='1'){
                                          alert("Leave Rejected!");
                                            window.location.href = window.location.href;
                                          //  window.loaction.href='adminPanelUpdateEmp.php';
                                          //  window.loaction.reload();
                                        }else if(data=='0'){
                                          alert("Can't update!");
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }

    }

    function deleteCompOffEntry(applyLeaveId,userId){

         var r = confirm("Are you sure you want delete this Comp Off?");
                    if (r == true) {
                        $.ajax({
                                    url: "deleteCompOffEntry.php",
                                    type: "POST",
                                    data: "ACTION=reject&applyLeaveId="+applyLeaveId+"&userId="+userId,
                                    success: function(data){
                                        
                                        if(data=='1'){
                                          alert("Comp Off deleted!");
                                            window.location.href = window.location.href;
                                          //  window.loaction.href='adminPanelUpdateEmp.php';
                                          //  window.loaction.reload();
                                        }else if(data=='0'){
                                          alert("Can't delete!");
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }

    }


       function approveLeaveRequest(applyLeaveId,leaveTypeId,userId){

         var r = confirm("Are you sure you want approve this Leave Request?");
                    if (r == true) {
                        $.ajax({
                                    url: "approveLeaveRequest.php",
                                    type: "POST",
                                    data: "ACTION=approve&applyLeaveId="+applyLeaveId+"&leaveTypeId="+leaveTypeId+"&userId="+userId,
                                    success: function(data){
                                        
                                        if(data=='1'){
                                          alert("Leave Approved!");
                                            window.location.href = window.location.href;
                                        
                                        }else if(data=='0'){
                                          alert("Can't update!");
                                        }else if(data=='2'){
                                          alert("All RH used!");
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }

    }



   
    </script>

</html>                                        