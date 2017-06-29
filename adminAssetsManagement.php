<?php
include_once('api/database.php');
$conn = getDB();
include 'api/session.php';

if(isset($_GET['addNewAsset'])){
  if(!empty($_GET['NewAsset'])){
    $asset=$_GET['NewAsset'];
    $sql = "INSERT INTO asset_type (asset_name) VALUES ('$asset')";
    if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
      echo "<script type='text/javascript'>alert('New Asset added to database!');window.location.replace('adminAssetsManagement.php');</script>";
    }else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    } 
  }else{
    echo "<script type='text/javascript'>alert('Field is not set!');window.location.replace('adminAssetsManagement.php');</script>";
  }
}

if(isset($_GET['addNewCompany'])){
  if(!empty($_GET['NewCompany'])){
    if(!isset($_SESSION['login_email'])){
      header("location:index.php");
    }else{
      $rental_company_name=$_GET['NewCompany'];
      $sql = "INSERT INTO rental_companies (rental_company_name) VALUES ('$rental_company_name')";
      if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
        echo "<script type='text/javascript'>alert('New Company added to database!');window.location.replace('adminAssetsManagement.php');</script>";
      }else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  }else{
    echo "<script type='text/javascript'>alert('Field is not set!');window.location.replace('adminAssetsManagement.php');</script>";
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
    <link rel="stylesheet" href="css/adminBars.css">
    <link rel="stylesheet" href="css/empExpenses.css">
    <link rel="stylesheet" href="css/editable.css">
    <style type="text/css">
      .btn-xs{
        height:22px ;
        width:60px ;
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
                <div class="submenu">
                  <div class="submenu-heading" id="expenses"><a href="adminExpenseManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Expenses.png" alt="expenses" >Expense Management</h5> </a></div>                   
                </div>
                <div class="submenu">
                  <div class="submenu-heading " id="reportees" ><a href="adminEmployeeManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title"><img src="images/Reportees.png" alt="reportees" >Employee Management</h5></a> </div>                   
                </div>
                <div class="submenu"  style="background: #373737;">
                  <div class="submenu-heading" id="assets"><a href="adminAssetsManagement.php" style="text-decoration: none !important;color:#ffffff !important;"> <h5 class="submenu-title" ><img src="images/Assets-W.png" alt="assets" >Assets Management</h5></a> </div>                   
                </div>
                <div class="submenu">
                  <div class="submenu-heading" id="leaves"><a href="adminLeaveManagement.php" style="text-decoration: none !important;color:#000000 ;"> <h5 class="submenu-title" ><img src="images/Leaves.png" alt="leaves" >Leave Management</h5></a> </div>                   
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
    <center>   <ul class="nav nav-pills" style="display:inline-block;" id="adminAssetManagementTabs" >
            <li class="active " ><a data-toggle="tab" href="#inventoryRecordsTab" >All Assets</a></li>
            <li ><a data-toggle="tab" href="#newAssetTab" >Asset Type</a></li>
            <li ><a data-toggle="tab" href="#rentalCompaniesTab" >Rental Companies</a></li>
        </ul></center> 
      <br><br>

      <div class="tab-content" id="myContent">
        <div id="inventoryRecordsTab" class="tab-pane fade in active">
             
          <!-- filter1 on basis of company/rent -->
          <form class="form-inline" id="form-filter1-assets" style="float: left;" >
            <div class="form-group" >
              <label style="color: #2a409f">Owner  </label>
              <select class="form-control" id="filter1-assets" >
                <option value="all" selected="">All</option>
                <option value="company" >Company</option>
                <option value="Rent">Rent</option>
              </select>
            </div>

            <!-- filter2 on basis of status free/given/assigned/returned  -->
            <div class="form-group" style="margin-left: 10px;">
              <label style="color: #2a409f;">Status  </label>
              <select class="form-control" id="filter2-assets" >
                <option value="all" >All</option>
                <option value="1">Free</option>
                <option value="2">Given</option>
                <option value="3">Assigned</option>
                <option value="4">Returned</option>
              </select>
            </div>

            <!-- filter3 on basis of status category  -->
            <div class="form-group" style="margin-left: 10px;">
              <label style="color: #2a409f;">Category  </label>
              <select class="form-control" id="filter3-assets" >
                <option value="all" selected="">All</option>
                  <?php
                    $query="Select * from asset_type order by asset_name";
                    $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                    if ($result1->num_rows > 0) {
                      while($row1 = $result1->fetch_array()){
                        echo "<option value='".$row1['id']."'>".$row1['asset_name']."</option>";
                      }
                    }
                  ?>
              </select>
            </div>
          </form>
               
          <button style="float: right;background:#2a409f;color: #ffffff;margin-left: 10px;" type='button' class='btn' data-toggle='modal' data-target='#exampleModal2'><span class='glyphicon glyphicon-plus' style="color: #ffffff;"></span> Add Asset</button>
          <form action="api/exportAdminAssetsExcel.php" method="post" id="exportTo" class="form-inline" style="float: right;mar">
            <div class="input-group" >
              <select class="form-control" id="asset_idEx" name="asset_idEx">
                <option value="0">--select--</option>
                <option value="Rent">Rent</option>
                <option value="tagbin">Company</option>
              </select>
              <span class="input-group-btn">
                <input type="submit" class="btn btn-default" name="exportSubmit" value="EXPORT" style="color:#2a409f; ">
              </span>
            </div>
          </form>
          <br><br>

          <table class='table table-bordered table-hover table-condensed' id='assetsData' >
            <script type="text/javascript">
              window.onload = function() {
                var action;
                var filterType = localStorage.getItem('filterAssetType');
                var valueFilter = localStorage.getItem('filterAssetsAdmin');
                if(filterType==1){
                  action="ACTION=getAdminFilteredData&filter1-assets="+valueFilter+"&filter2-assets=all&filter3-assets=all";
                }else if(filterType==2){
                  action="ACTION=getAdminFilteredData&filter2-assets="+valueFilter+"&filter1-assets=all&filter3-assets=all";
                }else if(filterType==3){
                  action="ACTION=getAdminFilteredData&filter3-assets="+valueFilter+"&filter2-assets=all&filter1-assets=all";
                }
                var val=localStorage.getItem('filterAdminAssets');
                $("#assetsData").empty();
                $.ajax({
                  url: "api/adminAssetsManagementAPI.php",
                  type: "POST",
                  data: action,
                  success: function(json){
                    $("#assetsData").append(json);
                  }
                })
              };
            
            $(function() { 
              $('#filter1-assets').change(function(){
                $("#assetsData").empty();
                $("#filter2-assets").val("all");
                $("#filter3-assets").val("all");
                var value;
            
                if($(this).val()=="all"){
                  value="all";
                }else if($(this).val()=="company" ){
                  value="company";
                }else if($(this).val()=="Rent"){
                  value="Rent";
                }
              
                $.ajax({
                  url: "api/adminAssetsManagementAPI.php",
                  type: "POST",
                  data: "ACTION=getAdminFilteredData&filter1-assets="+value+"&filter2-assets=all&filter3-assets=all",
                  success: function(json){
                    $("#assetsData").append(json);
                  }
                })
              });
              
              $('#filter2-assets').change(function(){
                $("#assetsData").empty();
                $("#filter1-assets").val("all");
                $("#filter3-assets").val("all");
                var value;
                if($(this).val()=="all"){
                  value="all";
                }else if($(this).val()=="1" ){
                  value="1";
                }else if($(this).val()=="2"){
                  value="2";
                }else if($(this).val()=="3" ){
                  value="3";
                }else if($(this).val()=="4"){
                  value="4";
                }
                
                $.ajax({
                  url: "api/adminAssetsManagementAPI.php",
                  type: "POST",
                  data: "ACTION=getAdminFilteredData&filter2-assets="+value+"&filter1-assets=all&filter3-assets=all",
                  success: function(json){
                    $("#assetsData").append(json);
                  }
                })
              });
              
              $('#filter3-assets').change(function(){
                $("#assetsData").empty();
                $("#filter2-assets").val("all");
                $("#filter1-assets").val("all");
                var value;
                if($(this).val()=="all"){
                  value="all";
                }else {
                  value=$(this).val();
                }
                
                $.ajax({
                  url: "api/adminAssetsManagementAPI.php",
                  type: "POST",
                  data: "ACTION=getAdminFilteredData&filter3-assets="+value+"&filter1-assets=all&filter2-assets=all",
                  success: function(json){
                    $("#assetsData").append(json);
                  }
                })
              });
            });
          </script>
        </tbody>
        </table>
        
        <a href="writeToAssetCSV.php" download  style="float: right;color: #2a409f;">Download Sample CSV</a><br><br>

        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1"> Asset Assign</h4>
              </div>
              <div class="modal-body">
                <form id="assetAssignForm">
                  <div class="form-group ">
                    <label for="assignTo" class="col-sm-3 control-label">Assign To:</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="assignTo" name="assignTo" placeholder="enter Email-Id">
                    </div>
                  </div>
                                    
                  <div class="form-group">
                    <input type="hidden" name="id" id="id">
                  </div> 
                  <br><br><br>
                  <center> 
                    <button type="button-inline" id="assignInventoryButton" class="btn btn-primary" name="assignInventoryButton" >Assign</button>
                  </center>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel3"> </h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="POST" action="changeInventoryDetails.php" id="changeInventoryDetailsForm">
                  <p><b>NOTE:</b> Fill all fields relatively</p><br>
                  <div class="form-group">
                    <label for="assetId" class="col-sm-4 control-label">Asset Name</label>
                    <div class="col-sm-6">
                      <select class="form-control" id="assetId" name="assetId">
                        <option value="0">--select--</option>
                        <?php
                          $query = "SELECT * FROM asset_type order by asset_name";
                          $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                          while ($rows = mysqli_fetch_array($result)) {
                            echo "<option value=" .$rows['id']. ">" .$rows['asset_name']. "</option>";
                          }
                        ?>     
                      </select>
                    </div>
                  </div>
                                    
                  <div class="form-group">
                    <label for="ownerName" class="col-sm-4 control-label">Owner</label>
                    <div class="col-sm-6">
                      <select class="form-control" id="ownerName" name="ownerName">
                        <option value="0" >--select--</option>
                        <option value="Tagbin" >Tagbin</option>
                        <option value="Rent" >Rent</option> 
                      </select>
                    </div>
                  </div>
                                     
                  <div class="form-group">
                    <label for="rentName" class="col-sm-4 control-label">Rental Company</label>
                    <div class="col-sm-6">
                      <select class="form-control" id="rentName" name="rentName">
                        <option value="0">--NA--</option>
                        <?php
                          $query = "SELECT * FROM rental_companies order by rental_company_name";
                          $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                          while ($rows = mysqli_fetch_array($result)) {
                            echo "<option value=" .$rows['id']. ">" .$rows['rental_company_name']. "</option>";
                          }
                        ?>      
                      </select>
                    </div>
                  </div>
                                     
                  <div class="form-group" >
                    <label for="chgDescription" class="col-sm-4 control-label">Description</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="chgDescription" name="chgDescription" placeholder="Description" >
                    </div>
                  </div>

                  <div class="form-group" >
                    <label for="chgPrice" class="col-sm-4 control-label">Price</label>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" id="chgPrice" name="chgPrice" placeholder="Price" step="0.01">
                    </div>
                  </div>
                                      
                  <div class="form-group">
                    <input type="hidden" name="chgInvId" id="chgInvId">
                  </div>
                                      
                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-10">
                      <button id="change" name="change" type="button-inline" class="btn btn-primary">Change</button>
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

      <?php
        //message shown on csv upload
        if(!empty($_GET['status'])){
          switch($_GET['status']){
            case 'succ':
              $statusMsgClass = 'alert-success';
              $statusMsg = 'CSV file imported successfully.';
              break;
            case 'err':
              $statusMsgClass = 'alert-danger';
              $statusMsg = 'Some problem occurred, please try again.';
              break;
            case 'invalid_file':
              $statusMsgClass = 'alert-danger';
              $statusMsg = 'Please upload a valid CSV file.';
              break;
            case 'mail':
              $statusMsgClass = 'alert-message';
              $statusMsg = 'Email id is wrong.';
              break;
            default:
              $statusMsgClass = '';
              $statusMsg = '';
          }
        }
      
        if(!empty($statusMsg)){
          echo '<div id="alert_message" class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
        } 
      ?>

      <script type="text/javascript">
        window.setTimeout(function() {
          $("#alert_message").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
          });
        }, 3000);
      </script>
    </div>

    <div id="newAssetTab" class="tab-pane fade ">
      <form class="form-inline"  id="form-filter-assets" style="float:left;" >
        <div class="form-group" >
          <label style="color: #2a409f;">Status </label>
          <select name="filter-master-assets" class="form-control" id="filter-master-assets" style="background: #fcf9f9;" >
            <option value="1" selected>Active</option>
            <option value="0">Inactive</option>
            <option value="all">All</option>
          </select>                
        </div>
      </form>

      <form style="float: right;" class="col-sm-4"  method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
        <div class="input-group" >
          <input type="text" class="form-control" id="NewAsset" name="NewAsset" placeholder="Enter New Asset Type">
          <span class="input-group-btn">
            <button class="btn btn-default" id="addNewAsset" name="addNewAsset" type="submit"><span class="glyphicon glyphicon-plus" style="color:#2a409f;"></span></button>
          </span>
        </div>
      </form>
      <br><br>

      <center>  
      <table class="table table-bordered table-hover table-condensed" id="tableItems" >
        <thead>
          <tr> <th>S.no</th> <th>Asset Type</th> <th>Status</th>  </tr>
        </thead>
        <tbody>
        <?php
          if(!isset($_GET['filter-master-assets']) || $_GET['filter-master-assets']=='1'){ 
            $query="Select * from asset_type where status='1' order by asset_name";
            $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
            if ($result1->num_rows > 0) {
              $index=1;
              while($row1 = $result1->fetch_array()){
                $status=$row1['status'];
                if(empty($status)){
                  $status="Inactive";
                  $bckColor="#ec585d";
                }else{
                  $status="Active";
                  $bckColor="#7cc576";
                }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
                echo "<tr><td align='left'>".$index.".</td>
                        <td class='edit_td' id='".$row1['id']."' >
                        <span id='first_".$row1['id']."' class='text'>".$row1['asset_name']."</span>
                          <input type='text' value='".$row1['asset_name']."' class='editbox' id='first_input_".$row1['id']."' >
                        </td>
                      <td>
                      <button onclick=changeAssetsStatus(".$row1['id'].") class='btn btn-xs' id='change".$index."' style='color:#ffffff;background:".$bckColor.";'> ".$status."</button></td></tr>";

                $index++;
              }
            }
          }else{
            $filter=$_GET['filter-master-assets'];
            if($filter=='0'){
              $query="Select * from asset_type where status='0' order by asset_name";
            }else if($filter=='all'){
              $query="Select * from asset_type order by asset_name";
            }
            $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
            if ($result1->num_rows > 0) {
              $index=1;
              while($row1 = $result1->fetch_array()){
                $status=$row1['status'];
                if(empty($status)){
                  $status="Inactive";
                  $bckColor="#ec585d";
                }else{
                  $status="Active";
                  $bckColor="#7cc576";
                }
                          
                echo "<tr><td align='left'>".$index.".</td>
                        <td class='edit_td' id='".$row1['id']."' >
                        <span id='first_".$row1['id']."' class='text'>".$row1['asset_name']."</span>
                          <input type='text' value='".$row1['asset_name']."' class='editbox' id='first_input_".$row1['id']."' >
                        </td>
                      <td>
                      <button onclick=changeAssetsStatus(".$row1['id'].") class='btn btn-xs' id='change".$index."' style='color:#ffffff;background:".$bckColor.";'> ".$status."</button></td></tr>";
                $index++;
              }
            }
          }
        ?>
        </tbody>
      </table> 
    </center>
  </center>
  </div>

  <div id="rentalCompaniesTab" class="tab-pane fade">
    <form style="float: right;" class="col-sm-4"  method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
      <div class="input-group" >
        <input type="text" class="form-control" id="NewCompany" name="NewCompany" placeholder="Enter New Rental Company">
        <span class="input-group-btn">
          <button class="btn btn-default" id="addNewCompany" name="addNewCompany" type="submit"><span class="glyphicon glyphicon-plus" style="color:#2a409f;"></span></button>
        </span>
      </div>
    </form>
    <br><br>

    <table class="table table-bordered table-hover table-condensed" id="tableItems" >
      <thead>
        <tr> <th>S.no</th> <th>Rental Company</th> <th>Action</th> </tr>
      </thead>
      <tbody>
      <?php
        if(!isset($_SESSION['login_email'])){
          header("location:index.php");
        }else{
          $query="Select * from rental_companies order by rental_company_name";
          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
          if ($result1->num_rows > 0) {
            $index=1;
            while($row1 = $result1->fetch_array()){
              echo "<tr><td align='left'>".$index.".</td>
                      <td class='edit_td1' id='".$row1['id']."' >
                      <span id='second_".$row1['id']."' class='text'>".$row1['rental_company_name']."</span>
                        <input type='text' value='".$row1['rental_company_name']."' class='editbox1' id='second_input_".$row1['id']."' >
                      </td>
                      <td><span onclick=removeRentalCompany(".$row1['id'].")  id='remove".$index."' class='glyphicon glyphicon-trash' style='cursor:pointer;'></span>  
                      </td>
                    </tr>";
              $index++;
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
    
    $('#newAssetTab').css('width',screen.width-280);
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
      localStorage.setItem('activeAssetMgmtTabs', $(e.target).attr('href'));
    });
    
    var activeAssetMgmtTabs = localStorage.getItem('activeAssetMgmtTabs');
    if(activeAssetMgmtTabs){
      $('#adminAssetManagementTabs a[href="' + activeAssetMgmtTabs + '"]').tab('show');
    }
    if(localStorage.getItem('filter-master-assets')){
      $('#filter-master-assets').val(localStorage.getItem('filter-master-assets'));
    }

    $('#filter-master-assets').change(function(){
      localStorage.setItem('filter-master-assets',$('#filter-master-assets').val());
      window.location.href="adminAssetsManagement.php?filter-master-assets="+$('#filter-master-assets').val();
    });

    var filterType = localStorage.getItem('filterAssetType');
    if(filterType==1){
      $('#filter1-assets').val(localStorage.getItem('filterAssetsAdmin'));
    }else if(filterType==2){
      $('#filter2-assets').val(localStorage.getItem('filterAssetsAdmin'));
    }else if(filterType==3){
      $('#filter3-assets').val(localStorage.getItem('filterAssetsAdmin'));
    }

    $('#filter1-assets').change(function(){
      localStorage.setItem('filterAssetType','1' );
      localStorage.setItem('filterAssetsAdmin',$('#filter1-assets').val() );
    });

    $('#filter2-assets').change(function(){
      localStorage.setItem('filterAssetType','2' );
      localStorage.setItem('filterAssetsAdmin',$('#filter2-assets').val() );
    });

    $('#filter3-assets').change(function(){
      localStorage.setItem('filterAssetType','3' );
      localStorage.setItem('filterAssetsAdmin',$('#filter3-assets').val() );
    });

    $(function() {    
      $('#status').change(function(){
        if($(this).val()=="2" || $(this).val()=="3" || $(this).val()=="4"){
          $('#assignToStatus').show();
        }else{
          $('#assignToStatus').hide();
        }
      });

      $('#owner').change(function(){
        if($(this).val()=="Rent"){
          $('#rentalCompanyName').show();
        }else{
          $('#rentalCompanyName').hide();
        }
      });
    });

    $(".edit_td").click(function()
    {
        var ID=$(this).attr('id');
        $("#first_"+ID).css("display","none")
        $("#first_input_"+ID).css("display","block")
    }).change(function() {
        var ID=$(this).attr('id');
        var first=$("#first_input_"+ID).val();
        var dataString = 'ACTION=updateAsset&id='+ ID +'&assetName='+first;

        if(first.length>0)
        {
          $.ajax({
            type: "POST",
            url: "api/adminAssetsManagementAPI.php",
            data: dataString,
            cache: false,
            success: function(data){
              if(data==1){
                window.location.reload();
              }  
            }
          });
        }else{
          alert('Enter something.');
        }
    });

    $(".edit_td1").click(function(){
        var ID=$(this).attr('id');
        $("#second_"+ID).css("display","none")
        $("#second_input_"+ID).css("display","block")
    }).change(function(){
        var ID=$(this).attr('id');
        var second=$("#second_input_"+ID).val();
        var dataString = 'ACTION=updateRentalCompany&id='+ ID +'&companyname='+second;

        if(second.length>0)
        {
            $.ajax({
              type: "POST",
              url: "api/adminAssetsManagementAPI.php",
              data: dataString,
              cache: false,
              success: function(data){
                if(data==1){
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

    $(document).mouseup(function(){
      $(".editbox1").css("display","none")
      $(".editbox").css("display","none")
      $(".text").css("display","block")
    });

    $("#assignInventoryButton").click(function(e) {
      e.preventDefault();
      var id = $("#id").val();
      var assignTo = $("#assignTo").val();
      if ( assignTo == '') {
        alert("Please Enter Email-Id!");
      }else{
        $.ajax({
          url: "api/adminAssetsManagementAPI.php",
          type: "POST",
          data:"ACTION=assignAsset&id="+id+"&assignTo="+assignTo,
          success: function(response){
            var data=$.trim(response);
            if(response.success==true){
              console.log("send assign inventory email: "+JSON.stringify(response));
              alert("Asset Given!");
              window.location.reload();
            }else if(data=="0"){
              alert('Please Fill All the fields!');
            }else if(data=="2"){
              alert('Not a valid user Or wrong email-id.');
            }else if(data=="3"){
              alert('Unable to Assign.');
            }else if(data=="5"){
              alert("Set System Admin First!");
            }
          }
        })
      }
    });

    $("#add").click(function(e) {
      e.preventDefault();
      var assetType = $("#assetType").val();
      var description = $("#description").val();
      var owner = $("#owner").val();
      var rentCompany = $("#rentCompany").val();
      var price = $("#price").val();

      if ( description == '' || assetType == '0' || owner=='0') {
        alert("Please fill the empty fields!");
      } else {
        $.ajax({
          url: "api/adminAssetsManagementAPI.php",
          type: "POST",
          data:"ACTION=addInventory&TYPE="+assetType+"&DESCRIPTION="+description+"&PRICE="+price+"&OWNER="+owner+"&RENTCOMPANY="+rentCompany,
          success: function(data){
            if(data=="1"){
              alert ("Inventory Added!");
              window.location.reload();
            }else if(data=="0"){
              alert('Cannot Add!');
            }else if(data=="2"){
              alert('Wrong email id!');
            }
          }
        })
      }
    });

    $("#change").click(function(e) {
      e.preventDefault();
      var assetId = $("#assetId").val();
      var chgDescription = $("#chgDescription").val();
      var ownerName = $("#ownerName").val();
      var newStatus = $("#newStatus").val();
      var newAssignedEmail = $("#newAssignedEmail").val();
      var rentName = $("#rentName").val();
      var chgInvId = $("#chgInvId").val();
      var chgPrice = $("#chgPrice").val();

      $.ajax({
        url: "api/adminAssetsManagementAPI.php",
        type: "POST",
        data:"ACTION=changeInventoryDetails&assetId="+assetId+"&chgDescription="+chgDescription+"&ownerName="+ownerName+"&newStatus="+newStatus+"&newAssignedEmail="+newAssignedEmail+"&rentName="+rentName+"&chgInvId="+chgInvId+"&chgPrice="+chgPrice,
        success: function(data){
          if(data=="1"){
            alert ("Inventory Details Changed!");
            window.location.reload();
          }else if(data=="0"){
            alert('Cannot change!');
          }else if(data=="2"){
            alert('Wrong email id!');
          }
        }
      })
    });
            
    $("#cancel").click(function(e){
      e.preventDefault();
      $('#inventory_form')[0].reset();                                   
    });

    $('#logout-button').click(function(e){
      localStorage.removeItem('activeExpenseMgmtTabs');
      localStorage.removeItem('activeEmployeeMgmtTabs');
      localStorage.removeItem('activeAssetMgmtTabs');
      localStorage.removeItem('activeLeaveMgmtTabs');
      localStorage.removeItem('filter-projects');
      localStorage.removeItem('filter-employees');
      localStorage.removeItem('filter-master-projects');
      localStorage.removeItem('filter-master-employees');
      localStorage.removeItem('filter-master-expense-categories');
      localStorage.removeItem('filter-master-assets');
    });
      localStorage.removeItem('filter-projects');
      localStorage.removeItem('filter-employees');
      localStorage.removeItem('filter-master-projects');
      localStorage.removeItem('filter-master-expense-categories');
      localStorage.removeItem('filter-master-employees');
  });

  function modalFunction1(){
    $("#exampleModal1").on("show.bs.modal", function (event){
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var modal = $(this);
      modal.find('.modal-title').text('Assign Asset ');
      $('#exampleModal1').find('input#id').val($(event.relatedTarget).data('id')); 
    });                     
  }

  function modalFunction3(){
    $("#exampleModal3").on("show.bs.modal", function (event){
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var status = button.data('status');
      var assetId = button.data('type');
      var ownerName = button.data('owner');
      var rental_company_name = button.data('rent_company');
      var modal = $(this);
      modal.find('.modal-title').text(' Update Inventory ');
      
      $('#exampleModal3').find('input#chgInvId').val($(event.relatedTarget).data('id'));
      $('#exampleModal3').find('input#chgDescription').val($(event.relatedTarget).data('description'));
      $('#exampleModal3').find('input#newAssignedEmail').val($(event.relatedTarget).data('name'));
      $('#newStatus').val(status);
      $('#rentName').val(rental_company_name);
      $('#assetId').val(assetId);
      $('#ownerName').val(ownerName);
      $('#exampleModal3').find('input#chgPrice').val($(event.relatedTarget).data('price'));               
    });
  }

  function removeRentalCompany(rentId){
    var r = confirm("Are you sure you want delete this Company?");
    if (r == true) {
      $.ajax({
        url: "api/adminAssetsManagementAPI.php",
        type: "POST",
        data: "ACTION=deleteRentalCompany&rentId="+rentId,
        success: function(data){
          if(data=='1'){
            alert("Company deleted!");
            window.location.href = window.location.href;
          }
        }
      })
    }              
  }

  function modalFunction4(){
    $("#exampleModal4").on("show.bs.modal", function (event){
      var button = $(event.relatedTarget);
      var companyname = button.data('companyname');
      var id = button.data('id');
      var modal = $(this);
      modal.find('.modal-title').text('Update Inventory: ' + companyname);
       
      $('#exampleModal4').find('input#id').val($(event.relatedTarget).data('id'));
      $('#exampleModal4').find('input#companyname').val($(event.relatedTarget).data('companyname'));
    });
  }

  function acceptAdminAsset(invId){
    var r = confirm("Are you sure you want to accept this asset?");
    if (r == true) {
      $.ajax({
        url: "api/adminAssetsManagementAPI.php",
        type: "POST",
        data: "ACTION=acceptAsset&invId="+invId,
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
    
  function rejectAdminAsset(invId){
    var r = confirm("Are you sure you want to reject this asset?");
    if (r == true) {
      $.ajax({
        url: "api/adminAssetsManagementAPI.php",
        type: "POST",
        data: "ACTION=rejectAsset&invId="+invId,
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
  
  function deleteAssetRow(rowId){
    var r = confirm("Are you sure you want delete this entry?");
    if (r == true) {
      $.ajax({
        url: "api/adminAssetsManagementAPI.php",
        type: "POST",
        data: "ACTION=deleteAssetRow&rowId="+rowId,
        success: function(data){                                   
          if(data=='1'){
            alert("Row deleted!");
            window.location.href = window.location.href;
          }
        }
      })
    }                  
  }
  
  function changeAssetsStatus(rowId){
     $.ajax({
      url: "api/adminAssetsManagementAPI.php",
      type: "POST",
      data: "ACTION=changeAssetRowStatus&rowId="+rowId,
      success: function(data){                                 
        if(data=="1"){
          window.location.reload();
        }else if(data=="0"){
          alert("Can't change Status!");
        }
      }
    })
  }

</script>
 
 <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <CENTER>  
          <h4 class="modal-title" id="exampleModalLabel2">Add New Asset </h4>
        </CENTER>
      </div>
      <div class="modal-body">
        <!-- form for adding new inventory manually -->
        <center><h5>Add Manually</h5></center>
        <form class="form-horizontal"  id="inventory_form">
          <div class="form-group">
            <label for="assetType" class="col-sm-2 control-label">Asset Type</label>
            <div class="col-sm-10">
              <select class="form-control" id="assetType" name="assetType">
                <option value="0">--select--</option>
                <?php
                  $query = "SELECT * FROM asset_type where status='1' order by asset_name";
                  $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                  while ($rows = mysqli_fetch_array($result)) {
                    echo "<option value=" .$rows['id']. ">" .$rows['asset_name']. "</option>";
                  }
                ?>     
              </select>
            </div>
          </div>

          <div class="form-group" >
            <label for="description" class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="description" name="description" placeholder="Description">
            </div>
          </div>
          
          <div class="form-group" >
            <label for="price" class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="price" name="price" placeholder="Price">
            </div>
          </div>
          
          <div class="form-group">
            <label for="owner" class="col-sm-2 control-label">Owner</label>
            <div class="col-sm-10">
              <select class="form-control" id="owner" name="owner">
                <option value="0" >--select--</option>
                <option value="Tagbin" >Tagbin</option>
                <option value="Rent" >Rent</option>
              </select>
            </div>
          </div>
          
          <div class="form-group" id="rentalCompanyName" style="display: none;">
            <label for="rentCompany" class="col-sm-2 control-label">Rental Company</label>
            <div class="col-sm-10">
              <select class="form-control" id="rentCompany" name="rentCompany">
                <option value="0">--select--</option>
                <?php
                  $query = "SELECT * FROM rental_companies order by rental_company_name";
                  $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                  while ($rows = mysqli_fetch_array($result)) {
                    echo "<option value=" .$rows['id']. ">" .$rows['rental_company_name']. "</option>";
                  }
                ?>     
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button id="cancel" name="cancel" type="button-inline" class="btn btn-default">Cancel</button>
              <button id="add" name="add" type="button-inline" class="btn btn-primary">Add</button>
            </div>
          </div>
        </form>
        <hr>
        
        <center><h2>OR</h2></center>
        <hr>

        <center>
        <form action="import_asset_csv.php" method="post" enctype="multipart/form-data" id="importFrm" class="form-inline">
          <div class="form-group" >
            <input type="file" name="file" class="form-control" />
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT CSV">
          </div>
        </form>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelModal">Cancel</button>
      </div>
    </div>
  </div>
</div>    
   
</body>
</html>