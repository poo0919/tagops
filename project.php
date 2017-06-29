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
    </style>
    <script>
      $( function() {
        $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
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
                <div class="submenu" >
                    <div class="submenu-heading " id="reportees" ><a href="adminEmployeeManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title"><img src="images/Reportees.png" alt="leaves" >Employee Management</h5></a> </div>                   
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
            <li class="active " ><a data-toggle="tab" href="#particularEmployeeTab" ><?php
                $project_id= $_GET['id'];
                $query="select name from projects where id='$project_id'";
                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_array()){
                    echo $row['name'];
                  }          
                }  
                                        
              ?></a></li>
        </ul></center> 


       <div class="tab-content" id="myContent">
            <div id="particularEmployeeTab" class="tab-pane fade in active">

            <form class="form-inline"  id="form-filter" style="float:left;" >
                    <div class="form-group" >
                    <label style="color: #2a409f;">Status </label>
                        <select  class="form-control" style="background: #fcf9f9;" id="filter1-projects">
                           <option value="0" selected="">Submitted</option>
                            <option value="all">All</option>
                            <option value="1">Approved</option>
                            <option value="2">Rejected</option>
                        </select>                
                    </div>
                </form>

             <hr><br>
                <table class="table table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.No.</th>  
                      <th>Name</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Details</th>
                      <th>Category</th>
                      <th>Payment Mode</th>
                      <th>Bill</th>
                      <th>View </th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
               
                 
                    $project_id=$_GET['id'];
                    if(!isset($_GET['filter1-projects']) || $_GET['filter1-projects']=='0'){
                        
                        $query = "Select id,user_id,amount,date,details,category_id,payment_id,bill,reimbursed,file from data where project_id='$project_id' AND reimbursed='0' ";
       
                        $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                   
                        if ($result->num_rows > 0) {
                            $index=1;
                            while ($row = $result->fetch_array()){
                                
                                $user_id=$row['user_id'];
                                $q1="select name,email from user where id=$user_id";
                                $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                $r1=$rs1->fetch_array();
                                
                                $category_id=$row['category_id'];
                                $q2="select category from categories where id=$category_id";
                                $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                $r2=$rs2->fetch_array();
                                
                                $payment_id=$row['payment_id'];
                                $q3="select mode from payment where id=$payment_id";
                                $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                $r3=$rs3->fetch_array();
                                
                                $reimbursed=$row['reimbursed'];
                                if($reimbursed=="0"){
                                  $reimbursed="Submitted";
                                }else if($reimbursed=="1"){
                                  $reimbursed="Approved";
                                }else if($reimbursed=="2"){
                                  $reimbursed="Rejected";
                                }

                                if($row['bill']=="0")
                                  $bill="No";
                                else
                                  $bill="Yes";

                                $dateCreated=date_create($row['date']);
                                $formattedDate=date_format($dateCreated, 'd-m-Y');
    
                                echo "<tr><td>".$index."</td>
                                <td align='left'>".$r1['name']."</td>
                                <td align='left'>".$row['amount']."</td>
                                <td align='left'>".$formattedDate."</td>
                                <td align='left'>".$row['details']."</td>
                                <td align='left'>".$r2['category']."</td>
                                <td align='left'>".$r3['mode']."</td>
                                <td align='left'>".$bill."</td>
                                <td align='left'>";
                                               if(empty($row['file'])){
                                                echo "no file!";
                                              }else{
                                                echo "<a href=".$row['file']." target='_blank'>Click Me!</a>";
                                                
                                              }


                                              if($reimbursed=="Submitted"){
                                                  echo "</td>
                                                  <td style='color:#71D3f4;'>".$reimbursed."</td><td>";
                                              }else if($reimbursed=="Approved")
                                              {
                                                echo "</td>
                                                  <td style='color:#7cc576;'>".$reimbursed."</td><td>";

                                              }else if($reimbursed=="Rejected")
                                              {
                                                echo "</td>
                                                  <td style='color:#fea862;'>".$reimbursed."</td><td>";
                                              }

                                              if($reimbursed!="Submitted"){
                                                  echo "<span class='glyphicon glyphicon-remove-circle' id='rejectbtn".$index."'  style='color:#B5B5B5;'></span>&nbsp;&nbsp;<span class='glyphicon glyphicon-ok-circle' id='changebtn".$index."'   style='color:#B5B5B5;'></span></td>";
                                              }else{
                                                  echo "<span class='glyphicon glyphicon-remove-circle' id='rejectbtn".$index."' onclick='entryRejected(".$row['id'].")' style='cursor:pointer;color:#fea862;'></span>&nbsp;&nbsp;<span class='glyphicon glyphicon-ok-circle' id='changebtn".$index."' onclick='changeStatus(".$row['id'].")'  style='cursor:pointer;color:#7cc576;''></span></td>";
                                              }
                                $index++;
                            }
                        } else{
                            echo "<h4> No entry in this table ! <h4>";
                        }
                        
                      }else{

                        $filter=$_GET['filter1-projects'];
                          if($filter=='all'){
                                   //   $project_id=$_SESSION['project_id'];
                                      $query = "Select id,user_id,amount,date,details,category_id,payment_id,bill,reimbursed,file from data where project_id='$project_id'";
                 
                                  $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                             
                                  if ($result->num_rows > 0) {
                                      $index=1;
                                      while ($row = $result->fetch_array()){
                                          
                                          $user_id=$row['user_id'];
                                          $q1="select name,email from user where id=$user_id";
                                          $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                          $r1=$rs1->fetch_array();
                                          
                                          $category_id=$row['category_id'];
                                          $q2="select category from categories where id=$category_id";
                                          $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                          $r2=$rs2->fetch_array();
                                          
                                          $payment_id=$row['payment_id'];
                                          $q3="select mode from payment where id=$payment_id";
                                          $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                          $r3=$rs3->fetch_array();
                                          
                                          $reimbursed=$row['reimbursed'];
                                          if($reimbursed=="0"){
                                            $reimbursed="Submitted";
                                          }else if($reimbursed=="1"){
                                            $reimbursed="Approved";
                                          }else if($reimbursed=="2"){
                                            $reimbursed="Rejected";
                                          }

                                          if($row['bill']=="0")
                                            $bill="No";
                                          else
                                            $bill="Yes";

                                          $dateCreated=date_create($row['date']);
                                        $formattedDate=date_format($dateCreated, 'd-m-Y');
              
                                          echo "<tr><td>".$index."</td>
                                          <td align='left'>".$r1['name']."</td>
                                          <td align='left'>".$row['amount']."</td>
                                          <td align='left'>".$formattedDate."</td>
                                          <td align='left'>".$row['details']."</td>
                                          <td align='left'>".$r2['category']."</td>
                                          <td align='left'>".$r3['mode']."</td>
                                          <td align='left'>".$bill."</td>
                                          <td align='left'>";
                                               if(empty($row['file'])){
                                                echo "no file!";
                                              }else{
                                                echo "<a href=".$row['file']." target='_blank'>Click Me!</a>";
                                                
                                              }


                                              if($reimbursed=="Submitted"){
                                                  echo "</td>
                                                  <td style='color:#71D3f4;'>".$reimbursed."</td><td>";
                                              }else if($reimbursed=="Approved")
                                              {
                                                echo "</td>
                                                  <td style='color:#7cc576;'>".$reimbursed."</td><td>";

                                              }else if($reimbursed=="Rejected")
                                              {
                                                echo "</td>
                                                  <td style='color:#fea862;'>".$reimbursed."</td><td>";
                                              }

                                              if($reimbursed!="Submitted"){
                                                  echo "<span class='glyphicon glyphicon-remove-circle' id='rejectbtn".$index."'  style='color:#B5B5B5;'></span>&nbsp;&nbsp;<span class='glyphicon glyphicon-ok-circle' id='changebtn".$index."'   style='color:#B5B5B5;'></span></td>";
                                              }else{
                                                  echo "<span class='glyphicon glyphicon-remove-circle' id='rejectbtn".$index."' onclick='entryRejected(".$row['id'].")' style='cursor:pointer;color:#fea862;'></span>&nbsp;&nbsp;<span class='glyphicon glyphicon-ok-circle' id='changebtn".$index."' onclick='changeStatus(".$row['id'].")'  style='cursor:pointer;color:#7cc576;''></span></td>";
                                              }
                                          $index++;
                                      }
                                  } else{
                                      echo "<h4> No entry in this table ! <h4>";
                                  }

                          }else {



                                      $query = "Select id,user_id,amount,date,details,category_id,payment_id,bill,reimbursed,file from data where project_id='$project_id' AND reimbursed='$filter'";
                 
                                  $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                             
                                  if ($result->num_rows > 0) {
                                      $index=1;
                                      while ($row = $result->fetch_array()){
                                          
                                          $user_id=$row['user_id'];
                                          $q1="select name,email from user where id=$user_id";
                                          $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                          $r1=$rs1->fetch_array();
                                          
                                          $category_id=$row['category_id'];
                                          $q2="select category from categories where id=$category_id";
                                          $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                          $r2=$rs2->fetch_array();
                                          
                                          $payment_id=$row['payment_id'];
                                          $q3="select mode from payment where id=$payment_id";
                                          $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                          $r3=$rs3->fetch_array();
                                          
                                          $reimbursed=$row['reimbursed'];
                                          if($reimbursed=="0"){
                                            $reimbursed="Submitted";
                                          }else if($reimbursed=="1"){
                                            $reimbursed="Approved";
                                          }else if($reimbursed=="2"){
                                            $reimbursed="Rejected";
                                          }

                                          if($row['bill']=="0")
                                            $bill="No";
                                          else
                                            $bill="Yes";

                                          $dateCreated=date_create($row['date']);
                                        $formattedDate=date_format($dateCreated, 'd-m-Y');
              
                                          echo "<tr><td>".$index."</td>
                                          <td align='left'>".$r1['name']."</td>
                                          <td align='left'>".$row['amount']."</td>
                                          <td align='left'>".$formattedDate."</td>
                                          <td align='left'>".$row['details']."</td>
                                          <td align='left'>".$r2['category']."</td>
                                          <td align='left'>".$r3['mode']."</td>
                                          <td align='left'>".$bill."</td>
                                          <td align='left'>";
                                               if(empty($row['file'])){
                                                echo "no file!";
                                              }else{
                                                echo "<a href=".$row['file']." target='_blank'>Click Me!</a>";
                                                
                                              }


                                              if($reimbursed=="Submitted"){
                                                  echo "</td>
                                                  <td style='color:#71D3f4;'>".$reimbursed."</td><td>";
                                              }else if($reimbursed=="Approved")
                                              {
                                                echo "</td>
                                                  <td style='color:#7cc576;'>".$reimbursed."</td><td>";

                                              }else if($reimbursed=="Rejected")
                                              {
                                                echo "</td>
                                                  <td style='color:#fea862;'>".$reimbursed."</td><td>";
                                              }

                                              if($reimbursed!="Submitted"){
                                                  echo "<span class='glyphicon glyphicon-remove-circle' id='rejectbtn".$index."'  style='color:#B5B5B5;'></span>&nbsp;&nbsp;<span class='glyphicon glyphicon-ok-circle' id='changebtn".$index."'   style='color:#B5B5B5;'></span></td>";
                                              }else{
                                                  echo "<span class='glyphicon glyphicon-remove-circle' id='rejectbtn".$index."' onclick='entryRejected(".$row['id'].")' style='cursor:pointer;color:#fea862;'></span>&nbsp;&nbsp;<span class='glyphicon glyphicon-ok-circle' id='changebtn".$index."' onclick='changeStatus(".$row['id'].")'  style='cursor:pointer;color:#7cc576;''></span></td>";
                                              }
                                          $index++;
                                      }
                                  } else{
                                      echo "<h4> No entry in this table ! <h4>";
                                  }

                          }


                      }
          
                    ?>

                    
                    </tbody>
                </table> 

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

      var idVariable = getQueryVariable("id");
      function getQueryVariable(variable) {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
          var pair = vars[i].split("=");
          if (pair[0] == variable) {
            return pair[1];
          }
        } 
        alert('Query Variable ' + variable + ' not found');
      }

      if(localStorage.getItem('filter1-projects')){
        $('#filter1-projects').val(localStorage.getItem('filter1-projects'));
      }

      $('#filter1-projects').change(function(){
        localStorage.setItem('filter1-projects',$('#filter1-projects').val() );
        window.location.href="project.php?filter1-projects="+$('#filter1-projects').val()+"&id="+idVariable;  
      }) 

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
});

function changeStatus(dataId){
    var r = confirm("Are you sure you want to approve this entry?");
    if (r == true) {
      $.ajax({
        url: "api/adminExpenseManagementAPI.php",
        type: "POST",
        data: "ACTION=changeReimbursementStatus&id="+dataId,
        success: function(data){
          if(data=="1"){
            alert("Approved!");
            window.location.reload();  
          }else if (data=='2'){
            alert("cannot update wallet");                            
          }else if (data=='3'){
            alert("can not change reimbursed status");                            
          }else if (data=='4'){
            alert("advance balance is not set for this user");                            
          }else if (data=='5'){
            alert("already approved or rejected");                            
          }else if (data=='6'){
            alert("insufficient balance in wallet to reimburse");                            
          }
        }
      })
    }
  }

  function entryRejected(dataId){
    var r = confirm("Are you sure you want to reject this entry?");
    if (r == true) {
      $.ajax({
        url: "api/adminExpenseManagementAPI.php",
        type: "POST",
        data: "ACTION=rejectEntry&id="+dataId,
        success: function(data){
          if(data=="1"){
            alert("Rejected!");
            window.location.reload();  
          }else if (data=='2'){
            alert("cannot reject");                            
          }else if (data=='3'){
            alert("It is approved");                            
          }else if (data=='4'){
            alert("Already rejected");                            
          }
        }
      })
    }else {
      alert("You pressed Cancel!");
    } 
  }
</script>
</body>
</html>