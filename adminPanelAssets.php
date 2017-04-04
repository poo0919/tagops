<?php
    include 'connection.php';
    include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
  
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Admin Panel</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <!--   <link rel="stylesheet" href="/resources/demos/style.css">  -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <!--   <link href="css/bootstrap.min.css" rel="stylesheet">  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script>
  $( function() {
    $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
  <link rel="stylesheet" type="text/css" href="adminPanel.css">
<link rel="stylesheet" href="sidebar.css">
</head>

<body style="background-image: url(back12.jpg);">

<?php 
include 'adminBars.php';
?>
    
<div class="container" id="midNav" "> 
    <div class="spacer"></div>
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
            ?>

                <?php if(!empty($statusMsg)){
                    echo '<div id="alert_message" class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
                } ?>
            
        <div id="tab_assets" class=" well" >
           <section>

           
          <ul class="nav navbar-nav navbar-right">
            <!-- filter1 on basis of company/rent -->
            <li style="padding-top: 5px;padding-right: 10px;"> 
            <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form-filter1-assets" >
                <div class="form-group" >
                    <select name="filter1-assets" class="form-control" id="filter1-assets" >
                        <option value="all" selected="">All</option>
                        <option value="company" >Company</option>
                        <option value="rent">Rent</option>
                    </select>
                    <button type="submit" class="btn btn-primary" ><b>Filter 1</b></button>              
                </div>
              </form></li><br>

              <!-- filter2 on basis of status free/given/assigned/returned  -->
              <li style="padding-top: 5px;padding-bottom: 10px;">
                <form class="form-inline" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form-filter2-assets" >
                    <div class="form-group" >
                        <select name="filter2-assets" class="form-control" id="filter2-assets" >
                            <option value="all" selected="">All</option>
                            <option value="1">Free</option>
                            <option value="2">Given</option>
                            <option value="3">Assigned</option>
                            <option value="4">Returned</option>
                        </select>
                        <button type="submit" class="btn btn-primary" ><b>Filter 2</b></button>              
                    </div>
                </form>
            </li><br>  
          </ul>


                <div style="text-align: center">  <h1>Assets</h1></div>
                    <?php

                    if((!isset($_GET['filter1-assets']) && !isset($_GET['filter2-assets']))){ //if no filter is set

                        echo "<table class='table table-striped table-bordered table-hover table-condensed' id='tableItems' >
                        <thead>
                        <tr>
                          <th>S.no</th>
                          <th>Type</th>
                          <th>Description</th>
                          <th>Owner</th>
                          <th>Rental Company</th>
                          <th>Status</th>
                          <th>Assigned To</th>
                          <th>Action</th>
                          <th>Update</th>
                        </tr>
                        </thead>
                        <tbody>";

                                $query = "Select * from inventory";
                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    while ($row = $result->fetch_array()){
                                                
                                        $type_id=$row['type'];
                                        $q1="select asset_name from asset_type where id='$type_id'";
                                        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $r1=$rs1->fetch_array();

                                        if($row['owner']=="Rent")
                                        {
                                            $rent_id=$row['rental_company'];
                                            $q2="select rental_company_name from rental_companies where id='$rent_id'";
                                            $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            $r2=$rs2->fetch_array();
                                            $rentCompany=$r2['rental_company_name'];                                    
                                        }else{
                                            $rentCompany="NA";
                                        }

                                        $user_id=$row['assigned_to'];
                                        $q3="select name from user where id=$user_id";
                                        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                        $r3=$rs3->fetch_array();
                                        $name=$r3['name'];
                                                
                                        $status=$row['status'];
                                        if($status=="1"){
                                            $status="Free";
                                            $name="No one.";
                                        }else if($status=="2"){
                                            $status="Given";
                                        }else if($status=="3"){
                                            $status="Assigned";
                                        }else if($status=="4"){
                                            $status="Returned";
                                        }

                                        echo "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  echo  "No Action";
                                              }else if($status=="Free"){
                                                  echo   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  echo  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                        echo  "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button> 
                                    </td><tr>";
                                        $index++;
                                    }

                                } else{
                                    echo "<h4> No entry in this table ! <h4>";
                                }

                      } else if(isset($_GET['filter1-assets'])){  //if filter1 is set

                            if(($_GET['filter1-assets']=="all")){

                              echo "<table class='table table-striped table-bordered table-hover table-condensed' id='tableItems' >
                              <thead>
                              <tr>
                                <th>S.no</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Owner</th>
                                <th>Rental Company</th>
                                <th>Status</th>
                                <th>Assigned To</th>
                                <th>Action</th>
                                <th>Update</th>
                              </tr>
                              </thead>
                              <tbody>";


                                $query = "Select * from inventory";
                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    while ($row = $result->fetch_array()){
                                                
                                        $type_id=$row['type'];
                                        $q1="select asset_name from asset_type where id='$type_id'";
                                        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $r1=$rs1->fetch_array();

                                        if($row['owner']=="Rent")
                                        {
                                            $rent_id=$row['rental_company'];
                                            $q2="select rental_company_name from rental_companies where id='$rent_id'";
                                            $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            $r2=$rs2->fetch_array();
                                            $rentCompany=$r2['rental_company_name'];                                    
                                        }else{
                                            $rentCompany="NA";
                                        }

                                        $user_id=$row['assigned_to'];
                                        $q3="select name from user where id=$user_id";
                                        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                        $r3=$rs3->fetch_array();
                                        $name=$r3['name'];
                                                
                                        $status=$row['status'];
                                        if($status=="1"){
                                            $status="Free";
                                            $name="No one.";
                                        }else if($status=="2"){
                                            $status="Given";
                                        }else if($status=="3"){
                                            $status="Assigned";
                                        }else if($status=="4"){
                                            $status="Returned";
                                        }

                                        echo "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  echo  "No Action";
                                              }else if($status=="Free"){
                                                  echo   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  echo  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                        echo  "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";

                                        $index++;
                                    }

                                } else{
                                    echo "<h4> No entry in this table ! <h4>";
                                }

                        } else if(($_GET['filter1-assets']=="company")){

                          echo "<table class='table table-striped table-bordered table-hover table-condensed' id='tableItems' >
                          <thead>
                          <tr>
                            <th>S.no</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Owner</th>
                            <th>Rental Company</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                            <th>Update</th>
                          </tr>
                          </thead>
                          <tbody>";
                            $filter=$_GET['filter1-assets'];
                            if($filter=="rent")
                                $query = "Select * from inventory where owner='$filter'";
                            else
                                $query = "Select * from inventory where owner NOT LIKE 'Rent'";
                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    while ($row = $result->fetch_array()){
                                                
                                        $type_id=$row['type'];
                                        $q1="select asset_name from asset_type where id='$type_id'";
                                        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $r1=$rs1->fetch_array();

                                        if($row['owner']=="Rent")
                                        {
                                            $rent_id=$row['rental_company'];
                                            $q2="select rental_company_name from rental_companies where id='$rent_id'";
                                            $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            $r2=$rs2->fetch_array();
                                            $rentCompany=$r2['rental_company_name'];                                    
                                        }else{
                                            $rentCompany="NA";
                                        }

                                        $user_id=$row['assigned_to'];
                                        $q3="select name from user where id=$user_id";
                                        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                        $r3=$rs3->fetch_array();
                                        $name=$r3['name'];

                                                
                                        $status=$row['status'];
                                        if($status=="1"){
                                            $status="Free";
                                            $name="No one.";
                                        }else if($status=="2"){
                                            $status="Given";
                                        }else if($status=="3"){
                                            $status="Assigned";
                                        }else if($status=="4"){
                                            $status="Returned";
                                        }

                                        echo "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  echo  "No Action";
                                              }else if($status=="Free"){
                                                  echo  "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  echo  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                        echo  "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";
                                        $index++;
                                    }

                                } else{
                                    echo "<h4> No entry in this table ! <h4>";
                                }

                        }else{

                            echo "<table class='table table-striped table-bordered table-hover table-condensed' id='tableItems' >
                            <thead>
                            <tr>
                              <th>S.no</th>
                              <th>Type</th>
                              <th>Description</th>
                              <th>Owner</th>
                              <th>Rental Company</th>
                              <th>Status</th>
                              <th>Assigned To</th>
                              <th>Action</th>
                              <th>Update</th>
                            </tr>
                            </thead>
                            <tbody>";

                            $filter=$_GET['filter1-assets'];
                            if($filter=="rent")
                                $query = "Select * from inventory where owner='$filter'";
                            else
                                $query = "Select * from inventory where owner NOT LIKE 'Rent'";

                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    while ($row = $result->fetch_array()){
                                                
                                        $type_id=$row['type'];
                                        $q1="select asset_name from asset_type where id='$type_id'";
                                        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $r1=$rs1->fetch_array();

                                        if($row['owner']=="Rent")
                                        {
                                            $rent_id=$row['rental_company'];
                                            $q2="select rental_company_name from rental_companies where id='$rent_id'";
                                            $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            $r2=$rs2->fetch_array();
                                            $rentCompany=$r2['rental_company_name'];                                    
                                        }else{
                                            $rentCompany="NA";
                                        }

                                        $user_id=$row['assigned_to'];
                                        $q3="select name from user where id=$user_id";
                                        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                        $r3=$rs3->fetch_array();
                                        $name=$r3['name'];

                                                
                                        $status=$row['status'];
                                        if($status=="1"){
                                            $status="Free";
                                            $name="No one.";
                                        }else if($status=="2"){
                                            $status="Given";
                                        }else if($status=="3"){
                                            $status="Assigned";
                                        }else if($status=="4"){
                                            $status="Returned";
                                        }

                                        echo "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  echo  "No Action";
                                              }else if($status=="Free"){
                                                  echo  "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  echo  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                        echo  "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";
                                        $index++;
                                    }

                                } else{
                                    echo "<h4> No entry in this table ! <h4>";
                                }
                        }
                      
                    }else if(isset($_GET['filter2-assets'])){ //if filter2 is set

                      if(($_GET['filter2-assets']=="all")){

                        echo "<table class='table table-striped table-bordered table-hover table-condensed' id='tableItems' >
                        <thead>
                        <tr>
                          <th>S.no</th>
                          <th>Type</th>
                          <th>Description</th>
                          <th>Owner</th>
                          <th>Rental Company</th>
                          <th>Status</th>
                          <th>Assigned To</th>
                          <th>Action</th>
                          <th>Update</th>
                        </tr>
                        </thead>
                        <tbody>";


                                $query = "Select * from inventory";
                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    while ($row = $result->fetch_array()){
                                                
                                        $type_id=$row['type'];
                                        $q1="select asset_name from asset_type where id='$type_id'";
                                        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $r1=$rs1->fetch_array();

                                        if($row['owner']=="Rent")
                                        {
                                            $rent_id=$row['rental_company'];
                                            $q2="select rental_company_name from rental_companies where id='$rent_id'";
                                            $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            $r2=$rs2->fetch_array();
                                            $rentCompany=$r2['rental_company_name'];                                    
                                        }else{
                                            $rentCompany="NA";
                                        }

                                        $user_id=$row['assigned_to'];
                                        $q3="select name from user where id=$user_id";
                                        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                        $r3=$rs3->fetch_array();
                                        if(!empty($row['assigned_to']))
                                        $name=$r3['name'];
                                        else $name="No one.";
                                                
                                        $status=$row['status'];
                                        if($status=="1"){
                                            $status="Free";
                                            $name="No one.";
                                        }else if($status=="2"){
                                            $status="Given";
                                        }else if($status=="3"){
                                            $status="Assigned";
                                        }else if($status=="4"){
                                            $status="Returned";
                                        }

                                        echo "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  echo  "No Action";
                                              }else if($status=="Free"){
                                                  echo  "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  echo  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                        echo  "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";
                                        $index++;
                                    }

                                } else{
                                    echo "<h4> No entry in this table ! <h4>";
                                }

                        }else{
                          $filter=$_GET['filter2-assets'];
                     
                            $query = "Select * from inventory where status='$filter'";
                                $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                                if ($result->num_rows > 0) {
                                    $index=1;
                                    while ($row = $result->fetch_array()){
                                                
                                        $type_id=$row['type'];
                                        $q1="select asset_name from asset_type where id='$type_id'";
                                        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                                        $r1=$rs1->fetch_array();

                                        if($row['owner']=="Rent")
                                        {
                                            $rent_id=$row['rental_company'];
                                            $q2="select rental_company_name from rental_companies where id='$rent_id'";
                                            $rs2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                                            $r2=$rs2->fetch_array();
                                            $rentCompany=$r2['rental_company_name'];                                    
                                        }else{
                                            $rentCompany="NA";
                                        }
     
                                        $user_id=$row['assigned_to'];
                                        $q3="select name from user where id=$user_id";
                                        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                                        $r3=$rs3->fetch_array();
                                        $name=$r3['name'];

                                                
                                        $status=$row['status'];
                                        if($status=="1"){
                                            $status="Free";
                                            $name="No one.";
                                        }else if($status=="2"){
                                            $status="Given";
                                        }else if($status=="3"){
                                            $status="Assigned";
                                        }else if($status=="4"){
                                            $status="Returned";
                                        }
                                        
                                        if($status=="Given"){
                                            if($index==1) //checking for index 1 to laod the table-headers
                                            {
                                              echo "<table class='table table-striped table-bordered table-hover table-condensed' id='tableItems' >
                                                    <thead>
                                                      <tr>
                                                          <th>S.no</th>
                                                          <th>Type</th>
                                                          <th>Description</th>
                                                          <th>Owner</th>
                                                          <th>Rental Company</th>
                                                          <th>Status</th>
                                                          <th>Given To</th>
                                                          <th>Action</th>
                                                          <th>Update</th>
                                                      </tr>
                                                    </thead>
                                                <tbody>";
                                            }

                                              echo "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  echo  "No Action";
                                              }else if($status=="Free"){
                                                  echo   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  echo  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                              echo    "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button> 
                                    </td></td><tr>";

                                        }else if($status=="Assigned" ){
                                              if($index==1)   //checking for index 1 to laod the table-headers
                                                {
                                                  echo "<table class='table table-striped table-bordered table-hover table-condensed' id='tableItems' >
                                                        <thead>
                                                          <tr>
                                                              <th>S.no</th>
                                                              <th>Type</th>
                                                              <th>Description</th>
                                                              <th>Owner</th>
                                                              <th>Rental Company</th>
                                                              <th>Status</th>
                                                              <th>Assigned To</th>
                                                              <th>Action</th>
                                                              <th>Update</th>
                                                          </tr>
                                                        </thead>
                                                  <tbody>";
                                                }

                                          echo "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  echo  "No Action";
                                              }else if($status=="Free"){
                                                  echo   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  echo  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                      echo    "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button> 
                                    </td></td><tr>";

                                        }else if($status=="Returned"){
                                              if($index==1){  //checking for index 1 to laod the table-headers
                                                echo "<table class='table table-striped table-bordered table-hover table-condensed' id='tableItems' >
                                                      <thead>
                                                      <tr>
                                                          <th>S.no</th>
                                                          <th>Type</th>
                                                          <th>Description</th>
                                                          <th>Owner</th>
                                                          <th>Rental Company</th>
                                                          <th>Status</th>
                                                          <th>Returned By</th>
                                                          <th>Action</th>
                                                          <th>Update</th>
                                                      </tr>
                                                      </thead>
                                                    <tbody>";                                          
                                              }


                                          echo "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td>
                                              <td align='left'>".$name."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  echo  "No Action";
                                              }else if($status=="Free"){
                                                  echo   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  echo  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                          echo    "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";

                                  }else if ($status=="Free") {
                                              if($index==1)   //checking for index 1 to laod the table-headers
                                                {
                                                  echo "<table class='table table-striped table-bordered table-hover table-condensed' id='tableItems' >
                                                        <thead>
                                                          <tr>
                                                            <th>S.no</th>
                                                            <th>Type</th>
                                                            <th>Description</th>
                                                            <th>Owner</th>
                                                            <th>Rental Company</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                            <th>Update</th>
                                                          </tr>
                                                        </thead>
                                                  <tbody>";
                                                }

                                          echo "<tr><td>".$index."</td>
                                              <td align='left'>".$r1['asset_name']."</td>
                                              <td align='left'>".$row['description']."</td>
                                              <td align='left'>".$row['owner']."</td>
                                              <td align='left'>".$rentCompany."</td>
                                              <td align='left'>".$status."</td><td>";

                                              if($status=="Given" || $status=="Assigned"){
                                                  echo  "No Action";
                                              }else if($status=="Free"){
                                                  echo   "<button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' ><span class='glyphicon glyphicon-edit'></span> Assign</button>";
                                              }else if($status=="Returned"){
                                                  echo  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-success btn-xs' >Accept</button>";
                                              }

                                      echo    "</td><td><button id='editbtn".$index."' type='button' class='btn btn-info btn-xs' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$r1['asset_name']."' data-description='".$row['description']."' data-owner='".$row['owner']."' data-rent_company='".$rentCompany."' data-name='".$name."' data-status='".$status."' data-id='".$row['id']."' ><span class='glyphicon glyphicon-pencil'></span> Edit</button><button onclick=deleteAssetRow(".$row['id'].") class='btn btn-warning btn-xs' id='delete".$index."'><span class='glyphicon glyphicon-remove-sign'></span> Delete</button></td><tr>";
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
            </section><br>

            <!-- Button for adding new inventory manually -->
            <div> 
       <center>   <button id='addbtn".$index."' type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#exampleModal2'><span class='glyphicon glyphicon-plus'></span> Add New Inventory</button> </center>
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel2">Add New Inventory </h4>
                            </div>
                            <div class="modal-body">
                            <!-- form for adding new inventory manually -->
                                    <form class="form-horizontal" method="POST" action="addNewInventory.php" id="inventory_form">
                                      <div class="form-group">
                                        <label for="assetType" class="col-sm-2 control-label">Asset Type</label>
                                        <div class="col-sm-10">
                                          <select class="form-control" id="assetType" name="assetType">
                                            <option value="0">--select--</option>
                                                <?php
                                                    include 'connection.php';
                                                    $query = "SELECT * FROM asset_type order by asset_name";
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
                                                    include 'connection.php';
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
                                        <label for="status" class="col-sm-2 control-label">Status</label>
                                        <div class="col-sm-10">
                                          <select class="form-control" id="status" name="status">
                                            <option value="0" >--select--</option>
                                            <option value="1" >Free</option>
                                            <option value="2" >Given</option>
                                            <option value="3" >Assigned</option>
                                            <option value="4" >Returned</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group" id="assignToStatus" style="display:none;">
                                        <label for="assignedTo" class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10"> 
                                          <input type="email" class="form-control" id="assignedTo" name="assignedTo" placeholder="email id" value="0">
                                        </div>
                                      </div>
                                      
                                      <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                          <button id="cancel" name="cancel" type="button-inline" class="btn btn-default">Cancel</button>
                                          <button id="add" name="add" type="button-inline" class="btn btn-primary">Add</button>
                                        </div>
                                      </div>
                                    </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelModal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

   
            
            </div>

             <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="exampleModalLabel1">New </h4>
                            </div>
                            <div class="modal-body">
                                <form method="GET" action="assignAsset.php">
                                    <div class="form-group ">
                                        <label for="assignTo" class="control-label"> Assign To:</label>
                                        <input type="email" class="form-control" id="assignTo" name="assignTo" >
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="id">
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
                                <div class="row">
                                      <div class="form-group col-sm-6">
                                        <label for="assetId" class="col-sm-4 control-label">Asset Name</label>
                                        <div class="col-sm-8">
                                          <input  class="form-control" type="text" name="assetName" id="assetName" readonly>
                                        </div>
                                      </div>
                                      <div class="form-group col-sm-6">
                                        <label for="assetId" class="col-sm-4 control-label">->    Change To</label>
                                        <div class="col-sm-8">
                                          <select class="form-control" id="assetId" name="assetId">
                                            <option value="0">--select--</option>
                                                <?php
                                                    include 'connection.php';
                                                    $query = "SELECT * FROM asset_type order by asset_name";
                                                    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                                    while ($rows = mysqli_fetch_array($result)) {
                                                        echo "<option value=" .$rows['id']. ">" .$rows['asset_name']. "</option>";
                                                    }
                                                ?>     
                                            </select>
                                        </div>
                                      </div>
                                      </div>

                                      


                                      <div class="row">
                                      <div class="form-group col-sm-6">
                                        <label for="owner" class="col-sm-4 control-label">Owner</label>
                                        <div class="col-sm-8">
                                          <input  class="form-control" type="text" name="owner" id="owner" readonly>
                                        </div>
                                      </div>
                                      <div class="form-group col-sm-6">
                                        <label for="ownerName" class="col-sm-4 control-label">->    Change To</label>
                                        <div class="col-sm-8">
                                          <select class="form-control" id="ownerName" name="ownerName">
                                            <option value="0" >--select--</option>
                                            <option value="Tagbin" >Tagbin</option>
                                            <option value="Rent" >Rent</option> 
                                          </select>
                                        </div>
                                      </div>
                                      </div>

                                      <div class="row">
                                      <div class="form-group col-sm-6">
                                        <label for="rent" class="col-sm-4 control-label">Rent</label>
                                        <div class="col-sm-8">
                                          <input  class="form-control" type="text" name="rent" id="rent" readonly>
                                        </div>
                                      </div>
                                      <div class="form-group col-sm-6">
                                        <label for="rentName" class="col-sm-4 control-label">->    Change To</label>
                                        <div class="col-sm-8">
                                          <select class="form-control" id="rentName" name="rentName">
                                            <option value="0">--select--</option>
                                                <?php
                                                    include 'connection.php';
                                                    $query = "SELECT * FROM rental_companies order by rental_company_name";
                                                    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
                                                    while ($rows = mysqli_fetch_array($result)) {
                                                        echo "<option value=" .$rows['id']. ">" .$rows['rental_company_name']. "</option>";
                                                    }
                                                ?>      
                                            </select>
                                        </div>
                                      </div>
                                      </div>

                                      <div class="row">
                                      <div class="form-group col-sm-6">
                                        <label for="currentStatus" class="col-sm-4 control-label">Current Status</label>
                                        <div class="col-sm-8">
                                          <input  class="form-control" type="text" name="currentStatus" id="currentStatus" readonly>
                                        </div>
                                      </div>
                                      <div class="form-group col-sm-6">
                                        <label for="newStatus" class="col-sm-4 control-label">->    Change To</label>
                                        <div class="col-sm-8">
                                          <select class="form-control" id="newStatus" name="newStatus">
                                            <option value="0" >--select--</option>
                                            <option value="1" >Free</option>
                                            <option value="2" >Given</option>
                                            <option value="3" >Assigned</option>
                                            <option value="4" >Returned</option>
                                          </select>
                                        </div>
                                      </div>
                                      </div>

                                      <div class="row">
                                      <div class="form-group col-sm-6">
                                        <label for="assignedName" class="col-sm-4 control-label">Assigned To</label>
                                        <div class="col-sm-8">
                                          <input  class="form-control" type="text" name="assignedName" id="assignedName" readonly>
                                        </div>
                                      </div>
                                      <div class="form-group col-sm-6">
                                        <label for="newAssignedEmail" class="col-sm-4 control-label">->    Change To</label>
                                        <div class="col-sm-8">
                                          <input type="email" class="form-control" id="newAssignedEmail" name="newAssignedEmail" placeholder="0/email id" >
                                        </div>
                                      </div>
                                      </div>
                                      
                                      
                                      <div class="form-group" >
                                        <label for="chgDescription" class="col-sm-3 control-label">Description</label>
                                        <div class="col-sm-7">
                                          <input type="text" class="form-control" id="chgDescription" name="chgDescription" placeholder="Description" >
                                        </div>
                                      </div>
                                      
                                      <div class="form-group">
                                      <input type="hidden" name="chgInvId" id="chgInvId">
                                      </div>
                                      
                                      <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                  <!--        <button id="reset" name="reset" type="button-inline" class="btn btn-default">Reset</button>  -->
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
        </div>

<section>
                
              
              <!-- Pnael for adding inventory data with csv -->
          <div class="panel panel-default">
                    <div class="panel-heading" style="float: right">
                       Download Sample CSV format: <a href="writeToAssetCSV.php" download >Sample</a>
                    </div>
                    <div class="panel-body" style="padding-left: 80px;">
                        <form action="import_asset_csv.php" method="post" enctype="multipart/form-data" id="importFrm" class="form-inline">
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
    

 

    <script type="text/javascript">

    $(document).ready(function(){

            if(localStorage.getItem('filter1-assets')){
                      $('#filter1-assets').val(localStorage.getItem('filter1-assets'));
                  }

                  $('#filter1-assets').change(function(){
                    localStorage.removeItem('filter2-assets');
                      localStorage.setItem('filter1-assets',$('#filter1-assets').val() );
                    
                  });

                  if(localStorage.getItem('filter2-assets')){
                      $('#filter2-assets').val(localStorage.getItem('filter2-assets'));
                  }

                  $('#filter2-assets').change(function(){
                        localStorage.removeItem('filter1-assets');
                      localStorage.setItem('filter2-assets',$('#filter2-assets').val() );
                    
                  });

                  $(function() {    // Makes sure the code contained doesn't run until
                  //     all the DOM elements have loaded

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


          localStorage.removeItem('filter-projects');
          localStorage.removeItem('filter-employees');
          localStorage.removeItem('sort');
          localStorage.removeItem('filter1-employees');
          localStorage.removeItem('filter2-employees');
          localStorage.removeItem('filter1-projects');


          $("#add").click(function(e) {
                e.preventDefault();
                var assetType = $("#assetType").val();
                var description = $("#description").val();
                var owner = $("#owner").val();
                var status = $("#status").val();
                var assignedTo = $("#assignedTo").val();
                var rentCompany = $("#rentCompany").val();

                if ( description == '' || assetType == '0' || owner=='0' || status=='0' || assignedTo=='') {
                    alert("Please fill the empty fields!");
                }else {

                    $.ajax({
                        url: "addNewInventory.php",
                        type: "POST",
                        data:"ACTION=addInventory&TYPE="+assetType+"&DESCRIPTION="+description+"&OWNER="+owner+"&STATUS="+status+"&ASSIGNEDTO="+assignedTo+"&RENTCOMPANY="+rentCompany,
                        success: function(data){
                            if(data=="1") {
                                alert ("Inventory Added!");
                                window.location.reload();
                            } else if(data=="0"){
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


                //if ( description == '' || assetType == '0' || owner=='0' || status=='0' || assignedTo=='') {
                  //  alert("Please fill the empty fields!");
              //  }else {

                    $.ajax({
                        url: "changeInventoryDetails.php",
                        type: "POST",
                        data:"ACTION=changeDetails&assetId="+assetId+"&chgDescription="+chgDescription+"&ownerName="+ownerName+"&newStatus="+newStatus+"&newAssignedEmail="+newAssignedEmail+"&rentName="+rentName+"&chgInvId="+chgInvId,
                        success: function(data){
                            if(data=="1") {
                                alert ("Inventory Details Changed!");
                                window.location.reload();
                            } else if(data=="0"){
                                alert('Cannot change!');
                            }else if(data=="2"){
                                alert('Wrong email id!');
                            }
                        }
                            
                    })
              //  }
            });
            
     
            
        $("#cancel").click(function(e){
                e.preventDefault();
                $('#inventory_form')[0].reset();                                   
            });

   

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

                          var modal = $(this);
                          modal.find('.modal-title').text(' Update Inventory ');
        
                         $('#exampleModal3').find('input#chgInvId').val($(event.relatedTarget).data('id'));
                         $('#exampleModal3').find('input#assetName').val($(event.relatedTarget).data('type'));
                          $('#exampleModal3').find('input#chgDescription').val($(event.relatedTarget).data('description'));
                           $('#exampleModal3').find('input#rent').val($(event.relatedTarget).data('rent_company'));
                            $('#exampleModal3').find('input#assignedName').val($(event.relatedTarget).data('name'));
                             $('#exampleModal3').find('input#currentStatus').val($(event.relatedTarget).data('status'));
                              $('#exampleModal3').find('input#owner').val($(event.relatedTarget).data('owner'));

               
                     });
                     
        }

        function acceptAdminAsset(invId){
        var r = confirm("Are you sure you want to accept this asset?");
                    if (r == true) {
                        $.ajax({
                                    url: "acceptAdminAsset.php",
                                    type: "POST",
                                    data: "ACTION=accept&invId="+invId,
                                    success: function(data){

                                       if(data=="1"){
                                          alert("Accepted");
                                            window.location.reload();
                                        }else if(data=="0"){
                                            alert("Not Accepted!");
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }
    }

    function deleteAssetRow(rowId){
                    var r = confirm("Are you sure you want delete this entry?");
                    if (r == true) {
                        $.ajax({
                                    url: "deleteAssetRow.php",
                                    type: "POST",
                                    data: "ACTION=delete&rowId="+rowId,
                                    success: function(data){
                                        
                                        if(data=='1'){
                                          alert("Row deleted!");
                                            window.location.href = window.location.href;
                                        }
                                    }
                                })
                    }
                    else {
                        alert("You pressed Cancel!");
                    }
                }
  

    </script>
     
   
   
  </body>
</html>