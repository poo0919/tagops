<?php
    include_once('api/database.php');
    $conn = getDB();
    include 'api/session.php';

    if(isset($_GET['addNewProj'])){
        if(!empty($_GET['addNewProjName']))
        {   
            if(!isset($_SESSION['login_email'])){
                header("location:index.php");
            } else{
                $name=$_GET['addNewProjName'];
                
                $sql = "INSERT INTO projects (name) VALUES ('$name')";
                if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                    echo "<script type='text/javascript'>alert('New project added to database!'); window.location.replace('adminExpenseManagement.php');</script>";
                }else {
                   echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }else{
            echo "<script type='text/javascript'>alert('Field is not set!'); window.location.replace('adminExpenseManagement.php');</script>";
        }
    }
    
    // rename a project
    if(isset($_GET['renameProj'])){
        if((!empty($_GET['id'])) && (!empty($_GET['newProjName'])))
        {
                $id=$_GET['id'];
                $newname=$_GET['newProjName'];
                $sql="UPDATE projects SET name='$newname' WHERE id='$id' ";
                if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                    echo "<script type='text/javascript'>alert('Project Renamed!'); window.location.replace('adminExpenseManagement.php');</script>";  
                }else {
                   echo "Error: " . $sql . "<br>" . $conn->error;
                }
        }else {
            echo "<script type='text/javascript'>alert('Field is empty!'); window.location.replace('adminExpenseManagement.php');</script>";
        }
    }

    if(isset($_GET['addNewCat'])){ //code for adding new category to db
      if(!empty($_GET['NewCat']))
      {
          if(!isset($_SESSION['login_email'])){
              header("location:index.php");
          }else{
              $category=$_GET['NewCat'];
              $sql = "INSERT INTO categories (category) VALUES ('$category')";
              if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                  echo "<script type='text/javascript'>alert('New Category added to database!'); window.location.replace('adminPanelCategories.php');</script>";
              }else {
                 echo "Error: " . $sql . "<br>" . $conn->error;
              }
          }
      }else{
          echo "<script type='text/javascript'>alert('Field is not set!'); window.location.replace('adminExpenseManagement.php');</script>";
      }
    }
    
    if(isset($_GET['renameCat'])){   //code for renaming a category
    if((!empty($_GET['id'])) && (!empty($_GET['newCatName'])))
      {
          $newname=$_GET['newCatName'];
          $id=$_GET['id'];
          $sql="UPDATE categories SET category='$newname' WHERE id='$id' ";
          if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
              echo "<script type='text/javascript'>alert('Category renamed!'); window.location.replace('adminExpenseManagement.php');</script>";  
          }else {
             echo "Error: " . $sql . "<br>" . $conn->error;
          }
      }
      else{
          echo "<script type='text/javascript'>alert('Field is empty!'); window.location.replace('adminExpenseManagement.php');</script>";
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
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="adminProfile.php">My Profile</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="api/logout.php" id="logout-button" >Log Out</a></li>
        </ul>
      </li>   
    </ul>
    <div id="sidebar-wrapper" class="sidebar-toggle">
      <div id="nav-menu">
        <div class="submenu" style="background: #373737;">
          <div class="submenu-heading" id="expenses"><a href="adminExpenseManagement.php" style="text-decoration: none !important;color:#ffffff;"> <h5 class="submenu-title" ><img src="images/Expenses-W.png" alt="expenses" >Expense Management</h5> </a></div>
        </div>
        <div class="submenu">
          <div class="submenu-heading " id="reportees" ><a href="adminEmployeeManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Reportees.png" alt="leaves" >Employee Management</h5></a> </div>                   
        </div>
        <div class="submenu" >
          <div class="submenu-heading" id="assets"><a href="adminAssetsManagement.php" style="text-decoration: none !important;color:#000000;"> <h5 class="submenu-title" ><img src="images/Assets.png" alt="assets" >Assets Management</h5></a> </div>                   
        </div>
        <div class="submenu" >
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
    <center>   
      <ul class="nav nav-pills" style="display:inline-block;" id="adminExpenseManagementTabs" >
        <li class="active " ><a data-toggle="tab" href="#ProjectwiseTab" >Projectwise</a></li>
        <li ><a data-toggle="tab" href="#EmployeewiseTab" >Employeewise</a></li>
        <li ><a data-toggle="tab" href="#ProjectListTab" >Project List</a></li>
        <li ><a data-toggle="tab" href="#ExpenseCategoriesTab" >Expense Categories</a></li>
      </ul>
    </center> 

    <div class="tab-content" id="myContent">
      <div id="ProjectwiseTab" class="tab-pane fade in active">
        <form class="form-inline"  id="form-filter-emp" style="float:left;" >
          <div class="form-group" >
            <label style="color: #2a409f;">Expense </label>
            <select name="filter-projects" class="form-control" id="filter-projects" style="background: #fcf9f9" >
              <option value="due">Due</option>
              <option value="all" >All</option>
              <option value="clear">Clear</option>
            </select> 
          </div>
        </form>
        
        <a href="api/sampleProjectWiseCSV.php" download style='float:right;font:   18px Montserrat ;color:  #2a409f;'>Download Sample CSV</a>
        <hr  >​

        <table class="table table-bordered table-hover table-condensed" id="tableItems" >
          <thead> 
            <tr> <th>S.no</th> <th>Project</th> <th>Approved Expense(Total)</th> <th>Download</th> <th>Upload</th> </tr> 
          </thead>
          <tbody>
            <?php
              if(!isset($_SESSION['login_email'])){
                header("location:index.php");
              }else{
                if(!isset($_GET['filter-projects']) || $_GET['filter-projects']=='due'){  
                  $sql="select d.project_id,SUM(d.amount) as total,pr.id as id,pr.name as name from data d join (select id,name from projects where state='1') as pr on d.project_id=pr.id where d.reimbursed='0' group by pr.name order by pr.name";
                  $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                  if ($result->num_rows > 0) {
                    $index=1;
                    while($row = $result->fetch_array()){
                      $project_id=$row['id'];
                      $q1="SELECT SUM(amount) as total from data where project_id='$project_id' AND reimbursed='1' group by project_id";
                      $re1 = mysqli_query($conn,$q1)or die(mysqli_error($conn));
                      $total="";
                      if ($re1->num_rows > 0) {
                        while($ro1 = $re1->fetch_array()){
                          $total=$ro1['total'];
                        }
                      }

                      if(empty($total))
                        $total="0";

                      echo "<tr><td >".$index.".</td><td><a href=project.php?id=".$row['id'].">".$row['name']."</a></td><td>".$total."</td>";
                      echo "<td><a href='api/exportProjectwiseExcel.php?project_idEx=".$project_id."' ><span class='glyphicon glyphicon-download'></span></a></td><td><a ><span class='glyphicon glyphicon-paperclip' onclick='uploadExpenseCSV(".$project_id.")' style='cursor:pointer;'></span></a></td></tr>";
                            
                      $index++;
                    }
                  }
                }else{
                  $filter=$_GET['filter-projects'];
                  if($filter=='all'){
                    $query="Select id,name from projects where state='1' order by name";
                    $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                    if ($result1->num_rows > 0) {
                      $index=1;
                      while($row1 = $result1->fetch_array()){
                        $project_id=$row1['id'];

                        $query="select id,project_id,SUM(amount) as total from data where project_id='$project_id' group by project_id";
                        $result2=mysqli_query($conn,$query)or die(mysqli_error($conn));
                        $row2 = $result2->fetch_array();
                        if(empty($row2['total']))
                        $row2['total']="0";
                        $project_id=$row1['id'];
                        
                        $q1="SELECT SUM(amount) as total from data where project_id='$project_id' AND reimbursed='1' group by project_id";
                        $re1 = mysqli_query($conn,$q1)or die(mysqli_error($conn));
                        $total="";
                        if ($re1->num_rows > 0) {
                          while($ro1 = $re1->fetch_array()){
                            $total=$ro1['total'];
                          }
                        }

                        if(empty($total))
                          $total="0";

                        echo "<tr><td>".$index.".</td><td><a href=project.php?id=".$row1['id'].">".$row1['name']."</a></td><td>".$total."</td>";
                        echo "<td><a href='api/exportProjectwiseExcel.php?project_idEx=".$project_id."' ><span class='glyphicon glyphicon-download'></span></a></td><td><a ><span class='glyphicon glyphicon-paperclip' onclick='uploadExpenseCSV(".$row1['id'].")' style='cursor:pointer;'></span></a></td></tr>";
                        
                        $index++;
                      }
                    }
                  }else{
                    $q1="select id,name from projects where state='1' order by name";
                    $re1 = mysqli_query($conn,$q1)or die(mysqli_error($conn));
                    if ($re1->num_rows > 0) {
                      $index=1;
                      while($ro1= $re1->fetch_array()){
                        $flag="0";
                        $q2="select * from data where project_id='$ro1[id]'";
                        $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                        if ($re2->num_rows > 0) {                                        
                          while($ro2= $re2->fetch_array()){
                            if($ro2['reimbursed']=="0"){
                              $flag="1"; break;
                            }
                          } 
                        }

                        $q3="SELECT SUM(amount) as total from data where project_id='$ro1[id]' AND reimbursed='1' group by project_id";
                        $re3 = mysqli_query($conn,$q3)or die(mysqli_error($conn));
                        $total="";
                        if ($re3->num_rows > 0) {
                          while($ro3 = $re3->fetch_array()){
                            $total=$ro3['total'];
                          }
                        }

                        if(empty($total))
                          $total="0";

                        if($flag=="0"){
                          $due="0";
                          echo "<tr><td>".$index.".</td><td><a href=project.php?id=".$ro1['id'].">".$ro1['name']."</a></td><td>".$total."</td>";
                          echo "<td><a href='api/exportProjectwiseExcel.php?project_idEx=".$ro1['id']."' ><span class='glyphicon glyphicon-download'></span></a></td><td><a ><span class='glyphicon glyphicon-paperclip' onclick='uploadExpenseCSV(".$ro1['id'].")' style='cursor:pointer;'></span></a></td></tr>";
                          $index++;
                        }
                      } 
                    }
                  }
                }
              }
      
            ?>
          </tbody>
          </table>
        <section>
                
        <?php  //messgage shown on csv file upload
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
          ?>

          <?php if(!empty($statusMsg)){
              echo '<div id="alert_message" class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
          } ?>
                
          <form action="import_csv.php" method="post" enctype="multipart/form-data" id="importFrm" class="form-inline" style="display: none;">
            <div class="form-group" >
              <label>Select Project: </label>
              <input type="hidden" class="form-control" id="project_id" name="project_id">
            </div>
            <div class="form-group" >
              <input type="file" name="file" id="file" class="form-control" />
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" name="importSubmit" id="importSubmit" value="IMPORT">
            </div>
          </form>
                   
          <script type="text/javascript">
            window.setTimeout(function() {
              $("#alert_message").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
              });
            }, 3000);
          </script>
        </section>
      </div>

      <div id="EmployeewiseTab" class="tab-pane fade">
        <?php
          if(!isset($_SESSION['login_email'])){
            header("location:index.php");
          }else{
            $total=0;
            if(!isset($_GET['filter-employees']) || $_GET['filter-employees']=='due'){
              $sql="select user_id,SUM(transactions) as sumBalance from wallet group by user_id";
              $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
              if ($result->num_rows > 0) {
                while($row = $result->fetch_array()){
                  $walletBalance=$row['sumBalance'];
                  if($walletBalance<0){
                    $total+=$walletBalance;
                  }
                }
              }
              echo "<p style='float:right;font:   18px Montserrat ;color:  #2a409f;'>Total Wallet Balance:&nbsp;&nbsp;".$total."</p>";                         
            }else{
              $filter=$_GET['filter-employees'];
              if($filter=='all'){
                $sql="select user_id,SUM(transactions) as sumBalance from wallet group by user_id";
                $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                if ($result->num_rows > 0) {
                  while($row = $result->fetch_array()){
                    $walletBalance=$row['sumBalance'];
                    $total+=$walletBalance;
                  }
                }
                echo "<p style='float:right;font:   18px Montserrat ;color:  #2a409f;'>Total Wallet Balance:&nbsp;&nbsp;".$total."</p>";
              }else{
                $sql="select user_id,SUM(transactions) as sumBalance from wallet group by user_id";
                $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                if ($result->num_rows > 0) {
                  while($row = $result->fetch_array()){
                    $walletBalance=$row['sumBalance'];
                    if($walletBalance>=0){
                      $total+=$walletBalance;
                    }
                  }
                }
                echo "<p style='float:right;font:   18px Montserrat ;color:  #2a409f;'>Total Wallet Balance:&nbsp;&nbsp;".$total."</p>";
              }
            }
          }
        ?>
            
      <form class="form-inline"  id="form-filter-emp" style="float:left;margin-top: 0px;" >
        <div class="form-group" >
          <label style="color: #2a409f;">Wallet </label>
          <select name="filter-employees" class="form-control" id="filter-employees" style="background: #fcf9f9" >
            <option value="due">Due</option>
            <option value="all" >All</option>
            <option value="clear">Clear</option>
          </select>     
        </div>
      </form>
      <hr >​

      <table class="table table-bordered table-hover table-condensed" id="tableItems" >
        <thead>
          <tr> <th>S.no</th> <th>Name</th> <th>Wallet Balance</th> <th>Expense Download</th> <th>Wallet Download</th> <th>Add Wallet</th> </tr>
        </thead>
        <tbody>
        <?php
          if(!isset($_SESSION['login_email'])){
            header("location:index.php");
          }else{
            if(!isset($_GET['filter-employees']) || ($_GET['filter-employees']=='due')){ //filter if wallet balance is due 

              $q1="select id, name from user where status='1' order by name";
              $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
              if ($re1->num_rows > 0) {
                $index=1;
                while($ro1 = $re1->fetch_array()){
                  $user_id=$ro1['id'];
                  $name=$ro1['name'];
                  $sql="select user_id,SUM(transactions) as sumTransactions from wallet where user_id='$user_id'";
                  $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_array()){
                      $walletBalance=$row['sumTransactions'];
                      if($walletBalance<0){
                        echo "<tr><td>".$index.".</td><td><a href=employee.php?id=".$user_id.">".$name."</a></td><td>".$walletBalance."</td><td><a href='api/exportEmployeeExpenseExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download-alt'></span></a></td><td><a href='api/exportEmployeeWalletExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download'></span></a></td><td><button id='addbtn".$index."' type='button' class='btn btn-xs' data-toggle='modal' data-target='#exampleModal2' onclick=modalFunction2()  data-id='".$user_id."' style='color:#ffffff;background:#2a409f;'><span class='glyphicon glyphicon-plus' style='color:#ffffff;'></span> Add</button></td><tr>";
                        $index++;
                      }
                    }
                  }else{
                    echo "<tr><td >".$index.".</td><td><a href=employee.php?id=".$user_id.">".$name."</a></td><td>0</td><td><a href='api/exportEmployeeExpenseExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download-alt'></span></a></td><td><a href='api/exportEmployeeWalletExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download'></span></a></td><td><button id='addbtn".$index."' type='button' class='btn btn-xs' data-toggle='modal' data-target='#exampleModal2' onclick=modalFunction2()  data-id='".$user_id."' style='color:#ffffff;background:#2a409f;'><span class='glyphicon glyphicon-plus' style='color:#ffffff;'></span> Add</button></td><tr>";
                  }
                }
              }
            }else{
              $filter=$_GET['filter-employees'];
              if($filter=='all'){  //show all user's wallet balance
                $q1="select id, name from user where status='1' order by name";
                $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                if ($re1->num_rows > 0) {
                  $index=1;
                  while($ro1 = $re1->fetch_array()){
                    $user_id=$ro1['id'];
                    $name=$ro1['name'];
                    $sql="select user_id,SUM(transactions) as sumTransactions from wallet where user_id='$user_id'";
                    $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                    if ($result->num_rows > 0) {
                      while($row = $result->fetch_array()){
                        $walletBalance=$row['sumTransactions'];
                        if(empty($walletBalance))
                          $walletBalance="0";
                                             
                        echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$user_id.">".$name."</a></td><td>".$walletBalance."</td><td><a href='api/exportEmployeeExpenseExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download-alt'></span></a></td><td><a href='api/exportEmployeeWalletExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download'></span></a></td><td><button id='addbtn".$index."' type='button' class='btn btn-xs' data-toggle='modal' data-target='#exampleModal2' onclick=modalFunction2()  data-id='".$user_id."' style='color:#ffffff;background:#2a409f;'><span class='glyphicon glyphicon-plus' style='color:#ffffff;'></span> Add</button></td><tr>";
                        $index++;
                      }
                    }
                  }
                }
              }else{ //show whose wallet balance is clear
                $q1="select id, name from user where status='1' order by name";
                $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                if ($re1->num_rows > 0) {
                  $index=1;
                  while($ro1 = $re1->fetch_array()){
                    $user_id=$ro1['id'];
                    $name=$ro1['name'];

                    $sql="select user_id,SUM(transactions) as sumTransactions from wallet where user_id='$user_id'";
                    $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                    if ($result->num_rows > 0) {
                      while($row = $result->fetch_array()){
                        $walletBalance=$row['sumTransactions'];

                        if($walletBalance<0){
                          continue;
                        }else{
                          if(empty($walletBalance))
                            $walletBalance="0";
                                                 
                          echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$user_id.">".$name."</a></td><td>".$walletBalance."</td><td><a href='writeToEmployeeExpenseExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download-alt'></span></a></td><td><a href='writeToEmployeeWalletExcel.php?EMPLOYEEID=".$user_id."' ><span class='glyphicon glyphicon-download'></span></a></td><td><button id='addbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal2' onclick=modalFunction2()  data-id='".$user_id."' style='color:#ffffff;background:#2a409f;'><span class='glyphicon glyphicon-plus' style='color:#ffffff;'></span> Add</button></td><tr>";
                          $index++;
                        }
                      }
                    }
                  }
                }
              }
            }
          }
  
        ?>
      </tbody>
      </table>        
    </div>

    <div id="ProjectListTab" class="tab-pane fade">
      <form class="form-inline"  id="form-filter-emp" style="float:left;" >
        <div class="form-group" >
          <label style="color: #2a409f;">Status </label>
          <select name="filter-master-projects" class="form-control" id="filter-master-projects" style="background: #fcf9f9;" >
            <option value="1">Active</option>
            <option value="0">Inactive</option>
            <option value="all" >All</option>
          </select>                
        </div>
      </form>
      
      <form style="float: right;" class="col-sm-4"  method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
        <div class="input-group" >
          <input type="text" class="form-control" id="addNewProjName" name="addNewProjName" placeholder="Enter New Project Name">
          <span class="input-group-btn">
            <button class="btn btn-default" id="addNewProj" name="addNewProj" type="submit"><span class="glyphicon glyphicon-plus" style="color: #2a409f;"></span></button>
          </span>
        </div>
      </form>
      <hr  >​
      
      <table class="table table-bordered table-hover table-condensed" id="tableItems" >
        <thead> 
          <tr> <th>S.no</th> <th>Project</th> <th>Status</th> </tr>
        </thead>
        <tbody>
        <?php
          if(!isset($_GET['filter-master-projects']) || $_GET['filter-master-projects']=='all'){ 
            $query="Select id,name,state from projects where state='1' order by name";
            $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
            if ($result1->num_rows > 0) {
              $index=1;
              while($row1 = $result1->fetch_array()){
                $state= $row1['state'];

                if(empty($state)){
                  $state="Inactive";
                  $bckColor="#ec585d";
                }else{
                  $state="Active";
                  $bckColor="#7cc576";
                }
                                   
                echo "<tr><td>".$index.".</td>
                      <td class='edit_td' id='".$row1['id']."' >
                        <span id='first_".$row1['id']."' class='text'>".$row1['name']."</span>
                        <input type='text' value='".$row1['name']."' class='editbox' id='first_input_".$row1['id']."' >
                      </td>
                      <td><button onclick='changeProjectState(".$row1['id'].")' class='btn btn-xs' style='background:".$bckColor.";color:#ffffff;'> ".$state."</button></td><tr>";
                $index++;
              }
            }
          }else {
            $filter=$_GET['filter-master-projects'];
            $query="";
            if($filter=='all'){
              $query.="Select id,name,state from projects order by name";
            }else if($filter=='0'){
              $query.="Select id,name,state from projects where state='0' order by name";
            }
                            
            $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
            if ($result1->num_rows > 0) {
              $index=1;
              while($row1 = $result1->fetch_array()){
                $state= $row1['state'];
                if(empty($state)){
                  $state="Inactive";
                  $bckColor="#ec585d";
                }else{
                  $state="Active";
                  $bckColor="#7cc576";
                }
                                   
                echo "<tr><td>".$index.".</td><td class='edit_td' id='".$row1['id']."' >
                        <span id='first_".$row1['id']."' class='text'>".$row1['name']."</span>
                        <input type='text' value='".$row1['name']."' class='editbox' id='first_input_".$row1['id']."' >
                        </td><td><button onclick='changeProjectState(".$row1['id'].")' class='btn btn-xs' style='background:".$bckColor.";color:#ffffff;'> ".$state."</button></td><tr>";
                $index++;
              }
            }
          }
        ?>
        </tbody>
        </table>
      </div>

      <div id="ExpenseCategoriesTab" class="tab-pane fade">
        <form class="form-inline"  id="form-filter-emp" style="float:left;" >
          <div class="form-group" >
            <label style="color: #2a409f;">Status </label>
            <select name="filter-master-expense-categories" class="form-control" id="filter-master-expense-categories" style="background: #fcf9f9;" >
              <option value="1">Active</option>
              <option value="0">Inactive</option>
              <option value="all" >All</option>
            </select>                
          </div>
        </form>
        
        <form style="float: right;" class="col-sm-4"  method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
          <div class="input-group" >
            <input type="text" class="form-control" id="NewCat" name="NewCat" placeholder="Enter New Expense Category">
            <span class="input-group-btn">
              <button class="btn btn-default" id="addNewCat" name="addNewCat" type="submit"><span class="glyphicon glyphicon-plus" style="color: #2a409f;"></span></button>
            </span>
          </div>
        </form>
        <hr  >​

        <table class="table table-bordered table-hover table-condensed" id="tableItems" >
          <thead> 
            <tr> <th>S.no</th> <th>Category</th> <th>Status</th> </tr>
          </thead>
          <tbody>
            <?php
              if(!isset($_GET['filter-master-expense-categories']) || $_GET['filter-master-expense-categories']=='1'){
                $query="Select id,category,status from  categories where status='1' order by category ASC";
                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                if ($result->num_rows > 0) {
                  $index=1;
                  while ($row = $result->fetch_array()){
                    $status= $row['status'];
                    if(empty($status)){
                      $status="Inactive";
                      $bckColor="#ec585d";
                    }else{
                      $status="Active";
                      $bckColor="#7cc576";
                    }

                    echo "<tr><td>".$index.".</td>
                          <td class='edit_td1' id='".$row['id']."' >
                            <span id='second_".$row['id']."' class='text'>".$row['category']."</span>
                            <input type='text' value='".$row['category']."' class='editbox1' id='second_input_".$row['id']."' >
                          </td>
                          <td><button onclick='changeExpenseCategoryStatus(".$row['id'].")' class='btn btn-xs' style='background:".$bckColor.";color:#ffffff;'> ".$status."</button></td><tr>";
                    $index++;
                  }
                }
              }else{
                $filter=$_GET['filter-master-expense-categories'];
                $query="";
                if($filter=='all'){
                  $query.="Select id,category,status from  categories order by category ASC";
                }else if($filter=='0'){
                  $query.="Select id,category,status from  categories where status='0' order by category ASC";
                }
                            
                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                if ($result->num_rows > 0) {
                  $index=1;
                  while ($row = $result->fetch_array()){
                    $status= $row['status'];
                    if(empty($status)){
                      $status="Inactive";
                      $bckColor="#ec585d";
                    }else{
                      $status="Active";
                      $bckColor="#7cc576";
                    }
                    echo "<tr><td align='left'>".$index.".</td>
                          <td align='left'>".$row['category']."</a></td>
                          <td><button onclick='changeExpenseCategoryStatus(".$row['id'].")' class='btn btn-xs' style='background:".$bckColor.";color:#ffffff;'> ".$status."</button></td><tr>";
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
    
<script type="text/javascript">
var files,uploadProjectId;
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

      $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeExpenseMgmtTabs', $(e.target).attr('href'));
        });
        var activeExpenseMgmtTabs = localStorage.getItem('activeExpenseMgmtTabs');
        if(activeExpenseMgmtTabs){
            $('#adminExpenseManagementTabs a[href="' + activeExpenseMgmtTabs + '"]').tab('show');
        }

        if(localStorage.getItem('filter-projects')){
            $('#filter-projects').val(localStorage.getItem('filter-projects'));
        }

        $('#filter-projects').change(function(){
            localStorage.setItem('filter-projects',$('#filter-projects').val() );
            window.location.href="adminExpenseManagement.php?filter-projects="+$('#filter-projects').val();
        });

        if(localStorage.getItem('filter-employees')){
            $('#filter-employees').val(localStorage.getItem('filter-employees'));
        }

        $('#filter-employees').change(function(){
            localStorage.setItem('filter-employees',$('#filter-employees').val() );
            window.location.href="adminExpenseManagement.php?filter-employees="+$('#filter-employees').val();
        });

        if(localStorage.getItem('filter-master-projects')){
            $('#filter-master-projects').val(localStorage.getItem('filter-master-projects'));
        }

        $('#filter-master-projects').change(function(){
            localStorage.setItem('filter-master-projects',$('#filter-master-projects').val() );
            window.location.href="adminExpenseManagement.php?filter-master-projects="+$('#filter-master-projects').val();
        });

        if(localStorage.getItem('filter-master-expense-categories')){
            $('#filter-master-expense-categories').val(localStorage.getItem('filter-master-expense-categories'));
        }

        $('#filter-master-expense-categories').change(function(){
            localStorage.setItem('filter-master-expense-categories',$('#filter-master-expense-categories').val() );
            window.location.href="adminExpenseManagement.php?filter-master-expense-categories="+$('#filter-master-expense-categories').val();
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

$(".editbox").mouseup(function() 
{
return false
});

$(document).mouseup(function()
{
$(".editbox").css("display","none")
$(".text").css("display","block")
});


$(".edit_td1").click(function()
{
    var ID=$(this).attr('id');
    $("#second_"+ID).css("display","none")
    $("#second_input_"+ID).css("display","block")
}).change(function()
{
    var ID=$(this).attr('id');
    var second=$("#second_input_"+ID).val();
    //var dataString = 'id='+ ID +'&first='+first;
    alert(second);

    if(second.length>0)
    {
        window.location.href= "adminExpenseManagement.php?id="+ID+"&newCatName="+second+"&renameCat=rename";
    }
    else
    {
        alert('Enter something.');
    }

});

// Edit input box click action
$(".editbox1").mouseup(function() 
{
return false
});

$(document).mouseup(function()
{
$(".editbox1").css("display","none")
$(".text").css("display","block")
});



$("#cancelModal").click(function(e){
            e.preventDefault();
                $('#walletForm')[0].reset(); 
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

      localStorage.removeItem('filter-master-employees');
      localStorage.removeItem('filter-master-assets');

});

function prepareUpload(event){
    files = event.target.files;
    var data = new FormData();
        $.each(files, function(key, value)
        {
            data.append('file', value);
        })

        data.append('project_id',uploadProjectId);
        data.append('importSubmit','import')

        $.ajax({
            url: 'api/importProjectwiseCSV.php', 
            type: 'POST',
            data: data,
            cache: false,
            //dataType: 'json',
            processData: false, // Don't process the files
            contentType: false,
           
            //async: false,
            success: function(data){
                console.log(data);
                alert(data);
             //   window.location.reload();
                
            },
            error: function(xhr,status,error){
                console.log(xhr+status+error);
            }
        });


}

function changeProjectState(projId){   
  $.ajax({
    url: "api/adminExpenseManagementAPI.php",
    type: "POST",
    data: "ACTION=changeProjectState&projId="+projId,
    success: function(data){
      if(data=="1"){
        alert("State Changed");
        window.location.reload();
      }else if(data=="0"){
        alert("Can't change state!");
      }
    }
  })                 
}

function changeExpenseCategoryStatus(projId){
  $.ajax({
    url: "api/adminExpenseManagementAPI.php",
    type: "POST",
    data: "ACTION=changeExpenseCategoryStatus&catId="+projId,
    success: function(data){
      if(data=="1"){
        alert("State Changed");
        window.location.reload();
      }else if(data=="0"){
        alert("Can't change state!");
      }
    }
  })                 
}

function uploadExpenseCSV( project_id){
  uploadProjectId=project_id;
  $("#file").click();
  $('input[type=file]').on('change',prepareUpload);   
}

function modalFunction2(){
  $("#exampleModal2").on("show.bs.modal", function (event){
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var modal = $(this);
    modal.find('.modal-title').text('Add in wallet');
    $('#exampleModal2').find('input#id').val($(event.relatedTarget).data('id'));
  });         
}
</script>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel2">Wallet </h4>
      </div>
      <div class="modal-body">
        <form method='POST' action='api/adminExpenseManagementAPI.php' id="walletForm">
          <div class='form-group'>
            <label for='date' class='control-label'>Date:</label>
            <input type='text' class='form-control datepicker' id='date' name='date'>
          </div>
          <div class='form-group'>
            <label for='remarks' class='control-label'>Remarks:</label>
            <input type='text' class='form-control' id='remarks' name='remarks'>
          </div>
          <div class='form-group'>
            <label for='advance' class='control-label'>Advance:</label>
            <input type='number' class='form-control' id='advance' name='advance'>
          </div>
          <div class='form-group'>
            <input type='hidden' name='id' id='id' >
          </div>
          <div class='form-group'>
            <input type='hidden' name='ACTION' id='ACTION' value="addToWallet">
          </div>
          <button type='button-inline' id='submit' class='btn btn-primary' name='submit' value='submit'>Add in Wallet</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelModal">Cancel</button>
      </div>
    </div>
  </div>
</div> 

</body>
</html>