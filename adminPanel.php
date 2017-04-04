<?php
    include 'connection.php';
    include 'session.php';
    
    if(isset($_GET['addNewProj'])){
    if(!empty($_GET['addNewProjName']))
    {   
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        } else{
            $name=$_GET['addNewProjName'];
            
            $sql = "INSERT INTO projects (name) VALUES ('$name')";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('New project added to database!');window.location.replace('adminPanel.php');</script>";
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }else{
        echo "<script type='text/javascript'>alert('Field is not set!');window.location.replace('adminPanel.php');</script>";
    }
    }
    
    if(isset($_GET['renameProj'])){
    if((!empty($_GET['oldProjName'])) && (!empty($_GET['newProjName'])))
    {
        if(!isset($_SESSION['login_email'])){
            header("location:adminLogin.php");
        }else{
            $oldname=$_GET['oldProjName'];
            $newname=$_GET['newProjName'];
            $sql="UPDATE projects SET name='$newname' WHERE name='$oldname' ";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('Project renamed!');window.location.replace('adminPanel.php');</script>";  
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    else {
        echo "<script type='text/javascript'>alert('Field is empty!');window.location.replace('adminPanel.php');</script>";
    }
    }
    
    if(isset($_GET['addNewCat'])){
    if(!empty($_GET['NewCat']))
    {
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        }else{
            $category=$_GET['NewCat'];
            $sql = "INSERT INTO categories (category) VALUES ('$category')";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('New Category added to database!');window.location.replace('adminPanel.php');</script>";
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }else{
        echo "<script type='text/javascript'>alert('Field is not set!');window.location.replace('adminPanel.php');</script>";
    }
    }
    
    if(isset($_GET['renameCat'])){
    if((!empty($_GET['oldCatName'])) && (!empty($_GET['newCatName'])))
    {
        if(!isset($_SESSION['login_email'])){
            header("location:index.php");
        }else{
            $oldname=$_GET['oldCatName'];
            $newname=$_GET['newCatName'];
            $sql="UPDATE categories SET category='$newname' WHERE category='$oldname' ";
            if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
                echo "<script type='text/javascript'>alert('Category renamed!');window.location.replace('adminPanel.php');</script>";  
            }else {
               echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    else{
        echo "<script type='text/javascript'>alert('Field is empty!');window.location.replace('adminPanel.php');</script>";
    }
    }
    
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
  
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Admin Panel</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

   
<style type="text/css">
    #myTab {
        background: rgb(205, 226, 247 );
    }
    #tab_categories,#tab_projects,#tab_employees,#update_project,#update_employee,#new_user,#new_admin{
        background: rgb(239, 250, 250   );
    }
    th{
        background: rgb(226, 237, 235    );
    }
</style>
<script>
  $( function() {
    $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>

</head>

<body style="background-image: url(back.png);">


<nav class="navbar navbar-default" style="background: rgb(19, 18, 121);">
    <div class="container-fluid">
        <div class="navbar-header">
        <a href="adminPanel.php">
             <img src="logo.png" style="width:155px;height:33px;">
        </a> 
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li ><label style="color: rgb(300,300,300);"><?php
                include 'connection.php';
                
                      $mail= $_SESSION['login_email'];
                      $query="select name from user where email='$mail'";
                      $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_array()){ 
                                echo $row['name']."   ";              
                            }
                        }                                                   
                ?></label></li>
            <li ><a href="logout.php" type="button" id="logout-button" class="btn btn-danger" style="color: rgb(300,300,300);"><span class="glyphicon glyphicon-log-out" ></span> LOGOUT</a></li>    
        </ul>
    </div>
</nav>


<div class="container">
  <div id="bs-example">
    <ul class="nav nav-pills well-sm" id="myTab">
        <li class="active"><a href="#tab_projects"  data-toggle="tab">Projects</a></li>
        <li ><a href="#tab_employees" data-toggle="tab">Employees</a></li> 
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Update
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li ><a href="#update_project" data-toggle="tab">Projects</a></li>
                <li><a href="#update_employee" data-toggle="tab">Employee</a></li> 
                <li ><a href="#tab_categories" data-toggle="tab">Categories</a></li>
                <li><a href="#new_user" data-toggle="tab">Permissions</a></li>
            </ul>
        </li> 
    </ul> 
       
       

    
    <div class="tab-content" id="myContent">
        <div id="tab_projects" class="tab-pane in active well" >
              <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form-filter-proj" >
                <div class="form-group" style="float: right;">
                    <select name="filter-projects" class="form-control" id="filter-projects" >
                        <option value="due">Due</option>
                        <option value="all" >All</option>
                        <option value="clear">Clear</option>
                    </select>
                    <button type="submit" class="btn btn-info" style="float: right;"><b>Filter</b></button>              
                </div>
              </form>
              
                <section>
                    <div style="text-align: center">  <h1>Projects</h1></div>
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tableItems" >
                        <thead>
                        <tr>
                          <th>S.no</th>
                          <th>Project</th>
                    <!--      <th>Due Amount</th> -->
                          
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        include 'connection.php';
           
                        if(!isset($_SESSION['login_email'])){
                            header("location:index.php");
                        }else{
                          
                          if(!isset($_GET['filter-projects']) || $_GET['filter-projects']=='due'){
                          //    echo "<script>alert('you here');</script>";
                                

                                $sql="select d.project_id,SUM(d.amount) as total,pr.id as id,pr.name as name from data d join (select id,name from projects) as pr on d.project_id=pr.id where d.reimbursed='0' group by pr.name order by pr.name";
                                    $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                     if ($result->num_rows > 0) {
                                        $index=1;
                                        while($row = $result->fetch_array()){
                                            echo "<tr><td align='left'>".$index."</td><td align='left'><a href=project.php?id=".$row['id'].">".$row['name']."</a></td><tr>";
                                                $index++;
                                              //  <td align='left'>".$row['total']."</td>
                                        }
                                     }
                              
                          }else{

                            $filter=$_GET['filter-projects'];
                              if($filter=='all'){
                                    $query="Select id,name from projects order by name";
                                     $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                              
                                  if ($result1->num_rows > 0) {
                                            $index=1;
                                      while($row1 = $result1->fetch_array()){
                                            
                                            // Code to get total due amount of particular employee
                                            $project_id=$row1['id'];
                                            $query="select id,project_id,SUM(amount) as total from data where project_id='$project_id' group by project_id";
                                            $result2=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                            $row2 = $result2->fetch_array();
                                            
                                            if(empty($row2['total']))
                                                $row2['total']="0";

                                            echo "<tr><td align='left'>".$index."</td><td align='left'><a href=project.php?id=".$row1['id'].">".$row1['name']."</a></td><tr>";
                                            $index++;
                                            //<td align='left'>".$row2['total']."</td>
                                      }
                                  }
                                  
                              }else{
                                    $q1="select id,name from projects order by name";
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
                                                      $flag="1";
                                                      break;
                                                    }
                                                  } 
                                              }

                                              if($flag=="0"){
                                                            
                                                  $due="0";
                                                  echo "<tr><td align='left'>".$index."</td><td align='left'><a href=project.php?id=".$ro1['id'].">".$ro1['name']."</a></td><tr>";
                                                  $index++;
                                                  //<td align='left'>".$due."</td>
                                                            
                                              }
                                          } if($flag=="1"){
                                            echo "no entry";
                                          }
                                    }
                                  
                              }
                              
                          }
                        }
      
                        $conn->close();
                        ?>
                        </tbody>
                    </table>
                </section>
                
            <section>
                
                <?php
            //load the database configuration file
            include 'connection.php';

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
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Add data from CSV file: 
                        <a href="javascript:void(0);" onclick="$('#importFrm').slideToggle();">Import File</a>
                       <p style="float: right">Download Sample CSV format: <a href="Sample.csv" download="Sample.csv" >Sample</a></p> 
                    </div>
                    <div class="panel-body">
                        <form action="import_csv.php" method="post" enctype="multipart/form-data" id="importFrm" class="form-inline">
                            <div class="form-group" >
                                <label>Select Project: </label>
                                <select class="form-control" id="project" name="project_id">
                                    <option value="0">--select--</option>
                                        <?php
                                            include 'connection.php';
                                            $query = "SELECT * FROM projects order by name";
                                            $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                            while ($rows = mysqli_fetch_array($result)) {
                                                echo "<option value=" .$rows['id']. ">" .$rows['name']. "</option>";
                                            }
                                        ?>     
                                </select>
                            </div>
                            <div class="form-group" >
                                <input type="file" name="file" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
                            </div>
                        </form>
                    </div>
                </div>
                <script type="text/javascript">
                    window.setTimeout(function() {
              $("#alert_message").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
              });
            }, 3000);
                </script>

            </section>
            


        </div>
   
        <div id="tab_employees" class="tab-pane fade well " >
            <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form-filter-emp" >
                <div class="form-group" style="float: right;">
                    <select name="filter-employees" class="form-control" id="filter-employees" >
                        <option value="due">Due</option>
                        <option value="all" >All</option>
                        <option value="clear">Clear</option>
                    </select>
                    <button type="submit" class="btn btn-info" style="float: right;"><b>Filter</b></button>              
                </div>
            </form>
        
            <section>
                <div style="text-align: center"><h1>Employees</h1></div>
                <table class="table table-striped table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Name</th>
            <!--          <th>Due Amount</th>  -->
                      <th>Wallet Balance</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    include 'connection.php';
       
                    if(!isset($_SESSION['login_email'])){
                        header("location:index.php");
                    }else{
                      
                      if(!isset($_GET['filter-employees']) || ($_GET['filter-employees']=='due')){

                            $sql="select user_id,SUM(transactions) as sumBalance from wallet group by user_id";
                            $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    while($row = $result->fetch_array()){
                                        $user_id=$row['user_id'];
                                        $walletBalance=$row['sumBalance'];

                                        if($walletBalance<0){
                                            $q1="select id, name from user where id='$user_id'";
                                            $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                            if ($re1->num_rows > 0) {
                                                $ro1 = $re1->fetch_array();
                                                $name=$ro1['name'];
                                                echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$user_id.">".$name."</a></td><td>".$walletBalance."</td><tr>";
                                            $index++;
                                        
                                            }
                                        }
                                }
                            }else echo "no entry in wallet table";







               /*       //    echo "<script>alert('you here');</script>";
                            $sql="select d.user_id,SUM(d.amount) as total,us.id as id,us.name as name from data d join (select id,name from user) as us on d.user_id=us.id where d.reimbursed='0' group by us.name order by us.name";
                                $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                 if ($result->num_rows > 0) {
                                    $index=1;
                                    while($row = $result->fetch_array()){
                                        $user_id=$row['id'];
                                        $walletBalance="";
                                        $q1="select SUM(transactions) as sumBalance from wallet where user_id='$user_id'";
                                        $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        if ($re1->num_rows > 0) {
                                            $ro1 = $re1->fetch_array();
                                                $walletBalance=$ro1['sumBalance'];
                                                
                                            
                                        }
                                                


                                        echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$row['id'].">".$row['name']."</a></td><td align='left'>".$row['total']."</td><td>".$walletBalance."</td><tr>";
                                            $index++;
                                    }
                                 }*/


                      }else{
                          $filter=$_GET['filter-employees'];
                          if($filter=='all'){


                            $sql="select user_id,SUM(transactions) as sumBalance from wallet group by user_id";
                            $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    while($row = $result->fetch_array()){
                                        $user_id=$row['user_id'];
                                        $walletBalance=$row['sumBalance'];

                                        
                                            $q1="select id, name from user where id='$user_id'";
                                            $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                            if ($re1->num_rows > 0) {
                                                $ro1 = $re1->fetch_array();
                                                $name=$ro1['name'];
                                                echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$user_id.">".$name."</a></td><td>".$walletBalance."</td><tr>";
                                            $index++;
                                        
                                            }
                                        
                                }
                            }else echo "no entry in wallet table";





                                 /*   $query="select id,name,email from user order by name";
                                  $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                  
                                  if ($result1->num_rows > 0) {
                                            $index=1;
                                      while($row1 = $result1->fetch_array()){
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                            // Code to get total due amount of particular employee

                                            $user_id=$row1['id'];




                                         //   $user_id=$row['id'];
                                        $walletBalance="";
                                        $q1="select SUM(transactions) as sumBalance from wallet where user_id='$user_id'";
                                        $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        if ($re1->num_rows > 0) {
                                            $ro1 = $re1->fetch_array();
                                                $walletBalance=$ro1['sumBalance'];
                                                
                                            
                                        }
                                            $query="Select user_id,SUM(amount) as total from data where user_id='$user_id' AND reimbursed='0' group by user_id ";
                                            $result2=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                            $row2 = $result2->fetch_array();
                                            if(empty($row2['total']))
                                                $row2['total']="0";

                                            echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$row1['id'].">".$row1['name']."</a><td>".$walletBalance."</td><tr>";
                                            $index++;
                                      }
                                  }*/

                          }else{

                            $sql="select user_id,SUM(transactions) as sumBalance from wallet group by user_id";
                            $result = mysqli_query($conn,$sql)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    while($row = $result->fetch_array()){
                                        $user_id=$row['user_id'];
                                        $walletBalance=$row['sumBalance'];

                                        if($walletBalance>=0){
                                            $q1="select id, name from user where id='$user_id'";
                                            $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                            if ($re1->num_rows > 0) {
                                                $ro1 = $re1->fetch_array();
                                                $name=$ro1['name'];
                                                echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$user_id.">".$name."</a></td><td>".$walletBalance."</td><tr>";
                                            $index++;
                                        
                                            }
                                        }
                                }
                            }else echo "no entry in wallet table";
                              



                              /*  $q1="select id,name from user order by name";
                                    $re1 = mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                    if ($re1->num_rows > 0) {
                                        $index=1;
                                          while($ro1= $re1->fetch_array()){
                                            $flag="0";
                                            $user_id=$ro1['id'];
                                            $q2="select * from data where user_id='$ro1[id]'";
                                            $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));

                                              if ($re2->num_rows > 0) {                                        
                                                  while($ro2= $re2->fetch_array()){
                                                    if($ro2['reimbursed']=="0"){
                                                      $flag="1";
                                                      break;
                                                    }
                                                  } 
                                              }

                                              if($flag=="0"){

                                        $walletBalance="";
                                        $q7="select SUM(transactions) as sumBalance from wallet where user_id='$user_id'";
                                        $re7=mysqli_query($conn,$q7)or die(mysqli_error($conn));
                                        if ($re7->num_rows > 0) {
                                            $ro7 = $re7->fetch_array();
                                                $walletBalance=$ro7['sumBalance'];
                                                
                                            
                                        }
                                                            
                                                  $due="0";
                                                  echo "<tr><td align='left'>".$index."</td><td align='left'><a href=employee.php?id=".$ro1['id'].">".$ro1['name']."</a></td><td align='left'>".$due."</td><td>".$walletBalance."</td><tr>";
                                                  $index++;
                                                            
                                              }
                                          }
                                    }*/
                          }
                          
                      }
                    }
  
                    $conn->close();
                    ?>
                    </tbody>
                </table>
                
                
                
        
            </section>
          <!-- <div class="container">
             
          
               <?php
            /*    include 'connection.php';
                if(!isset($_SESSION['login_email'])){
                     header("location:index.php");
                }else{
                    if(!isset($_GET['filter-employees']) || $_GET['filter-employees']=='due'){

                        $query="Select id from user";
                              $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                              $totalDue = 0;
                              if ($result1->num_rows > 0) {
                                  
                                  while($row1 = $result1->fetch_array()){
                                        
                                        // Code to get total due amount of particular employee and add all amount
                                        $user_id=$row1['id'];
                                        $query="select SUM(amount) AS total FROM data where user_id='$user_id' AND reimbursed='0'";
                                        $result2=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                        $row2 = $result2->fetch_array();
                                        $totalDue+=$row2['total'];
                                  }
                                  echo "<h3>Total amount DUE of Employees: <span class='label label-default'>".$totalDue."</span></h3>";  
                              }
                      
                    }else{
                          $filter=$_GET['filter-employees'];
                          if($filter=='all'){
                                $query="Select id from user";
                                  $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                  $totalDue = 0;
                                  if ($result1->num_rows > 0) {
                                      
                                      while($row1 = $result1->fetch_array()){
                                            
                                            // Code to get total due amount of particular employee and add all amount
                                            $user_id=$row1['id'];
                                            $query="select SUM(amount) AS total FROM data where user_id='$user_id' AND reimbursed='0'";
                                            $result2=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                            $row2 = $result2->fetch_array();
                                            $totalDue+=$row2['total'];
                                      }
                                      echo "<h3>Total amount due of ALL Employees: <span class='label label-default'>".$totalDue."</span></h3>";  
                                  }
                      
                          }else{
                              
                              $query="Select id from user";
                              $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                              $totalDue = 0;
                              if ($result1->num_rows > 0) {
                                  
                                  while($row1 = $result1->fetch_array()){
                                        
                                        // Code to get total due amount of particular employee and add all amount
                                        $user_id=$row1['id'];
                                        $query="select SUM(amount) AS total FROM data where user_id='$user_id' AND (reimbursed='1' OR reimbursed='2')";
                                        $result2=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                        $row2 = $result2->fetch_array();
                                        $totalDue+=$row2['total'];
                                  }
                                  echo "<h3>Amount CLEARED of Employees: <span class='label label-default'>".$totalDue."</span></h3>";  
                              }
                         
                          }
                    }
                }
                  $conn->close();*/
                ?>
             
          </div>   <br>-->
        </div>

        <div id="update_project" class="tab-pane fade well " >
            
            <section>
                <div style="text-align: center">  <h1>Projects</h1></div>
                <table class="table table-striped table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Project</th>
                      
                      
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include 'connection.php';
       
                    if(!isset($_SESSION['login_email'])){
                        header("location:index.php");
                    }else{
                      
                      
                          $query="Select id,name from projects order by name";
                          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                               
                                   
                                    echo "<tr><td align='left'>".$index."</td><td align='left'>".$row1['name']."</td><tr>";
                                    $index++;
                              }
                          }
                      }
                   
  
                    $conn->close();
                    ?>
                    </tbody>
                </table>
                </section>

            <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
                <div class="form-group">
                    <label for="addNewProjName">Add New Project: </label><br>
                    <input class="form-control" id="addNewProjName" type="text" name="addNewProjName" placeholder="Enter Project Name">
                    <button type="submit" class="btn btn-success" id="addNewProj" name="addNewProj" value="submit">Add Project</button>            
                </div>
    
                </form><br>
                <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form2">
                    <div class="form-group">
                        <label >Rename Project: </label><br>
                        <label for="oldProjName"> from </label>
                        <select class="form-control" id="oldProjName" name="oldProjName">
                        <option value="">--select--</option>
                             <?php
                                $servername = "localhost";
                                $username = "root";
                                $password = "123456";
                                $dbname = "tagbin";               
                                        
                                //Create connection
                                $conn = mysqli_connect($servername, $username, $password, $dbname);
                                //Check connection
                                if (mysqli_connect_errno()) {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                $query = "SELECT * FROM projects order by name";
                                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                while ($rows = mysqli_fetch_array($result)) {
                                    echo "<option >" .$rows['name']. "</option>";
                                }
                             ?> 
                        </select>                        <label for="newProjName"> to </label>
                        <input class="form-control" id="newProjName" type="text" name="newProjName" placeholder="Enter New Name">
                        <button type="submit" class="btn btn-info" id="renameProj" name="renameProj" value="submit">Rename</button>            
                    </div>
                </form>
        </div>

        <div id="update_employee" class="tab-pane fade well " >
            
        
            <section>
                <div style="text-align: center"><h1>Employees</h1></div>
                <table class="table table-bordered table-hover table-condensed" id="tableItems" >
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Name</th>
                      <th>Update</th>
                      <th>Wallet</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include 'connection.php';
       
                    if(!isset($_SESSION['login_email'])){
                        header("location:index.php");
                    }else{
                      
                  
                          $query="Select id,name from user order by name";
                          $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
                          
                          if ($result1->num_rows > 0) {
                                    $index=1;
                              while($row1 = $result1->fetch_array()){
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                    echo "<tr><td align='left'>".$index."</td>
                                    <td align='left'>".$row1['name']."</td>
                                    <td><button onclick=removeUser(".$row1['id'].") class='btn btn-warning btn-xs' id='remove'><span class='glyphicon glyphicon-remove-sign'></span> Remove</button> 
                                    <button type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1() data-name=".$row1['name']." data-id=".$row1['id']."><span class='glyphicon glyphicon-edit'></span> Edit</button></td>
                                    <td>
                                      <button type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal2' onclick=modalFunction2()  data-id=".$row1['id']."><span class='glyphicon glyphicon-plus'></span> Add</button>  
                                    </td></tr>";
                                    $index++;
                              }
                          }
                      
                  }
  
                    $conn->close();
                    ?>
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
                                <form method="GET" action="renameUser.php">
                                    <div class="form-group">
                                        <label for="oldName" class="control-label">Old Name:</label>
                                        <input type="text" class="form-control" id="oldName" name="oldName" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="newName" class="control-label">New Name:</label>
                                        <input type="text" class="form-control" id="newName" name="newName">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="id">
                                    </div>
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
                                <h4 class="modal-title" id="exampleModalLabel2">Wallet </h4>
                            </div>
                            <div class="modal-body">
                                <form method='POST' action='wallet.php' id="walletForm">
                                    <div class='form-group'>
                                        <label for='date' class='control-label'>Date:</label>
                                        <input type='text' class='form-control datepicker' id='date' name='date'>
                                    <div>
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
                                        <button type='button-inline' id='submit' class='btn btn-default' name='submit' value='submit'>Add in Wallet</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelModal">Cancel</button>
                            </div><
                        </div>
                    </div>
                </div>
                
                <script>
                function removeUser(id){


                    var r = confirm("Are you sure you want remove user?");
                    if (r == true) {
                        $.ajax({
                                    url: "removeUser.php",
                                    type: "GET",
                                    data: "ACTION=remove&id="+id,
                                    success: function(data){
                                        
                                        if(data=='1'){
                                            alert("user removed");
                                            document.getElementById("remove").disabled = true;
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }
                }
                function modalFunction1(){
                     $("#exampleModal1").on("show.bs.modal", function (event){
                          var button = $(event.relatedTarget);
                          var name = button.data('name');
                          var id = button.data('id');

                          var modal = $(this);
                          modal.find('.modal-title').text('Update data of User ' + name);
                          //modal.find('.modal-body input#oldName').val(recipient);
                        //  $('#oldName').val(recipient);
                        
                        $('#exampleModal1').find('input#id').val($(event.relatedTarget).data('id'));

                     
                        $('#exampleModal1').find('input#oldName').val($(event.relatedTarget).data('name'));
                      
                         
                     });
                     
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
                
        
            </section>
        </div>
            
        <div id="tab_categories" class="tab-pane fade well" >
            <section>
                    <div style="text-align: center">  <h1>All Categories</h1></div>
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tableItems" >
                        <thead>
                        <tr>
                          <th>S.no</th>
                          <th>Category</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        include 'connection.php';
                        if(!isset($_SESSION['login_email'])){
                             header("location:index.php");
                        }else{
                            $query="Select category from categories order by category ASC";
           
                            $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                            if ($result->num_rows > 0) {
                                $index=1;
                                while ($row = $result->fetch_array()){
                                    echo "<tr><td align='left'>".$index."</td><td align='left'>".$row['category']."</a></td><tr>";
                                    $index++;
                                }
                            }
                        }
                        $conn->close();
                        ?>
                        </tbody>
                    </table>
            </section>
           <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form1">
                    <div class="form-group">
                        <label for="NewCat">Add New Category: </label><br>
                        <input class="form-control" id="NewCat" type="text" name="NewCat" placeholder="Enter Category Name">
                        <button type="submit" class="btn btn-success" id="addNewCat" name="addNewCat" value="submit">Add Category</button>            
                    </div>
        
                </form><br>
           <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form2">
                    <div class="form-group">
                        <label >Rename Category: </label><br>
                        <label for="oldCatName"> from </label>
                        <select class="form-control" id="oldCatName" name="oldCatName">
                        <option value="">--select--</option>
                             <?php
                                $servername = "localhost";
                                $username = "root";
                                $password = "123456";
                                $dbname = "tagbin";               
                                        
                                //Create connection
                                $conn = mysqli_connect($servername, $username, $password, $dbname);
                                //Check connection
                                if (mysqli_connect_errno()) {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                $query = "SELECT * FROM categories order by category";
                                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                while ($rows = mysqli_fetch_array($result)) {
                                    echo "<option >" .$rows['category']. "</option>";
                                }
                             ?> 
                        </select>                    
                        <label for="newCatName"> to </label>
                        <input class="form-control" id="newCatName" type="text" name="newCatName" placeholder="Enter New Name">
                        <button type="submit" class="btn btn-info" id="renameCat" name="renameCat" value="submit">Rename</button>            
                    </div>
            </form>
        </div>

        <div id="new_user" class="tab-pane fade well " >
            <h4>Add New User</h4>
            <form class="form-inline" id="authForm">
                <div class="form-group ">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="userEmail" >
                    </div>
                    <div class="form-group">
                        <label for="auth-code" class="form-label">Auth Code</label>
                        <input type="text" class="form-control" id="auth-code" name="auth-code" readonly>
                    </div>
                    <div class="form-group" >
                        <button type="button-inline" id="generate-code" class="btn btn-info" >Generate Code</button>
                        <button type="button-inline" id="new-auth-user" class="btn btn-primary" disabled="true">Add user</button>
                    </div>
            </form>
            <br>
            <h4>Add New Admin</h4>
            <form class="form-inline" method="POST" action="newPermissions.php" id="admnForm">
                <div class="form-group ">
                        <label for="admnEmail" class="form-label">Email</label>
                        <select class="form-control" id="admnEmail">
                        <option value="0">--select--</option>
                            <?php
                                $servername = "localhost";
                                $username = "root";
                                $password = "123456";
                                $dbname = "tagbin";               
                                          
                                //Create connection
                                $conn = mysqli_connect($servername, $username, $password, $dbname);
                                //Check connection
                                if (mysqli_connect_errno()) {
                                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                                }
                                $query = "SELECT * FROM authorised order by email";
                                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                while ($rows = mysqli_fetch_array($result)) {
                                    echo "<option value=" .$rows['id']. ">" .$rows['email']. "</option>";
                                }
                            ?>     
                        </select>
                    </div>
                    
                        <button type="button-inline" id="new-admn-user" class="btn btn-primary">Add as Admin</button>
            </form>
         

        </div>


    </div>
    
  </div>
</div>
 

    <script type="text/javascript">

    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }

        if(localStorage.getItem('filter-projects')){
            $('#filter-projects').val(localStorage.getItem('filter-projects'));
        }

        $('#filter-projects').change(function(){
            localStorage.setItem('filter-projects',$('#filter-projects').val() );
           
        });

        if(localStorage.getItem('filter-employees')){
            $('#filter-employees').val(localStorage.getItem('filter-employees'));
        }

        $('#filter-employees').change(function(){
            localStorage.setItem('filter-employees',$('#filter-employees').val() );
          
        });

       $("#generate-code").click(function(e){
        e.preventDefault();
                var x=Math.floor(Math.random() * 1000000);
        $('#authForm').find('input#auth-code').val(x);
                document.getElementById("new-auth-user").disabled = false;

        });

        $("#new-auth-user").click(function(e) {
                                 e.preventDefault();               
                            var email = $("#userEmail").val();              
                            var authCode = $("#auth-code").val();

                            if ( email == '' || authCode == '' ) {
                                alert("Please fill all fields...!!!!!!");
                            }else {
                                $.ajax({
                                        url: "newPermissions.php",
                                        type: "POST",
                                        data: "ACTION=addAuth&EMAIL="+email+"&AUTHCODE="+authCode,
                                        success: function(data){
                                            console.log(data);
                                            if(data=='1'){
                                                $('#authForm')[0].reset();
                                                alert("user added with authcode "+authCode);
                                                window.location.reload();

                                            }else if (data=='0'){
                                                      alert("not added");
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
                                        url: "newPermissions.php",
                                        type: "POST",
                                        data: "ACTION=addAdmn&id="+email,
                                        //+"&ADMNCODE="+admnCode,
                                        success: function(data){
                                            console.log(data);
                                            if(data=='1'){
                                                $('#admnForm')[0].reset();
                                                alert("admin added");

                                            }else if (data=='0'){
                                                      alert("not added");
                                            }
                                        }
                                })
                            }                 

                        }); 
        $("#logout-button").click(function(e){
                 localStorage.removeItem('filter-projects');
                 localStorage.removeItem('filter-employees');
                 localStorage.removeItem('activeTab');
        });

        $("#cancelModal").click(function(e){
            e.preventDefault();
                $('#walletForm')[0].reset(); 
        });

    });
    </script>
     
   
   
  </body>
</html>