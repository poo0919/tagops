<?php
include_once('database.php');
require_once('email.php');
include_once('commonUtilities.php');
include 'empSession.php';
include 'config.php';
$conn = getDB();

if($_POST['ACTION']=="accept"){
	if(isset($_POST['invId'])){
	    $invId=$_POST['invId'];
	    $userId=$_POST['userId'];

	    $sql = "SELECT * FROM inventory where id='$invId'"; //fetching inventory details
	    $invResult=mysqli_query($conn,$sql)or die(mysqli_error($conn));
	    $user_id=""; $type_id=""; $description="";
	    if ($invResult->num_rows > 0) {
	        while($rowInvResult = $invResult->fetch_array()){
	            $user_id=$rowInvResult['assigned_to'];
	            $type_id=$rowInvResult['type'];
	            $description=$rowInvResult['description'];
	        }
	    }

	    $asset_name="";
	    $q1="select id,asset_name from asset_type where id='$type_id'";
	    $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
	    $r1=$rs1->fetch_array();
	    $asset_name=$r1['asset_name'];

	    $particularUserDetails = [];
      $particularUserDetails = getParticularUserDetails($conn,$user_id);
      $userName = $particularUserDetails['name'];
      $userMail = $particularUserDetails['email'];

	    $systemAdminName=""; $systemAdminEmail="";
	    $sql="select name,email from user where system_admin='1'";
	    $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
	    if ($result->num_rows > 0) {
	        $row = $result->fetch_array();
	        $systemAdminName= $row['name'];
	        $systemAdminEmail= $row['email'];
	    }else{
	        echo "5";
	        exit();
	    }

	    $query="update inventory set status='3' where id='$invId'";
	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	    if ($result === TRUE) {
	        $to = $systemAdminEmail; $cc = $userEmail;
	        $subject = "Asset Accepted";
	        $body = "Hi $systemAdminName,<br><br>$userName has accepted the following inventory assigned to him/her:<br><b>Asset Name:</b> $asset_name &nbsp;&nbsp; <b>Description:</b> $description<br><br>Thanks,<br>TagOps.";
	        $send_mail_value = send_email( $to,$cc,$subject,$body );
	        header( 'Content-Type: application/json' );
	        echo json_encode( $send_mail_value );
	    }else {
	        echo "0";
	    }                                  
	}   
}

if($_POST['ACTION']=="reject"){
	if(isset($_POST['invId'])){
	    $invId=$_POST['invId'];
	    $userId=$_POST['userId'];

	    $sql = "SELECT * FROM inventory where id='$invId'"; //fetching inventory details
	    $invResult=mysqli_query($conn,$sql)or die(mysqli_error($conn));
	    $user_id=""; $type_id=""; $description="";
	    if ($invResult->num_rows > 0) {
	        while($rowInvResult = $invResult->fetch_array()){
	            $user_id=$rowInvResult['assigned_to'];
	            $type_id=$rowInvResult['type'];
	            $description=$rowInvResult['description'];
	        }
	    }

	    $asset_name="";
	    $q1="select id,asset_name from asset_type where id='$type_id'";
  		$rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
  		$r1=$rs1->fetch_array();
  		$asset_name=$r1['asset_name'];

	    $sql1 = "SELECT name,email FROM user where id='$user_id'"; //fetching user details
	    $userResult=mysqli_query($conn,$sql1)or die(mysqli_error($conn));
	    $userName=""; $userEmail="";
	    if ($userResult->num_rows > 0) {
	        while($rowResult1 = $userResult->fetch_array()){
	            $userName=$rowResult1['name'];
	            $userEmail=$rowResult1['email'];
	        }
	    }

	    $systemAdminName=""; $systemAdminEmail="";
	    $sql="select name,email from user where system_admin='1'";
	    $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
	    if ($result->num_rows > 0) {
	        $row = $result->fetch_array();
	        $systemAdminName= $row['name'];
	        $systemAdminEmail= $row['email'];
	    }else{
	        echo "5";
	        exit();
	    }

	    $query="update inventory set status='1',assigned_to='0' where id='$invId'";
	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	    if ($result === TRUE) {
	       	$to = "$systemAdminEmail"; $cc = "$userEmail";
	        $subject = "Asset Rejected";
	        $body = "Hi $systemAdminName,<br><br>$userName has rejeted the following inventory assigned to him/her:<br><b>Asset Name:</b> $asset_name &nbsp;&nbsp; <b>Description:</b> $description<br><br>Thanks,<br>TagOps.";
	        $send_mail_value = send_email( $to,$cc,$subject,$body );
	        header( 'Content-Type: application/json' );
	        echo json_encode( $send_mail_value );
	    }else {
	        echo "0";
	    }                                  
	}
}

if($_POST['ACTION']=="return"){
	if(isset($_POST['invId'])){
    	$invId=$_POST['invId'];

    	$sql = "SELECT * FROM inventory where id='$invId'"; //fetching inventory details
        $invResult=mysqli_query($conn,$sql)or die(mysqli_error($conn));
        $user_id=""; $type_id=""; $description="";
        if ($invResult->num_rows > 0) {
            while($rowInvResult = $invResult->fetch_array()){
                $user_id=$rowInvResult['assigned_to'];
                $type_id=$rowInvResult['type'];
                $description=$rowInvResult['description'];
            }
        }

        $asset_name="";
        $q1="select id,asset_name from asset_type where id='$type_id'";
    		$rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
    		$r1=$rs1->fetch_array();
    		$asset_name=$r1['asset_name'];

    	  $sql1 = "SELECT name,email FROM user where id='$user_id'"; //fetching user details
        $userResult=mysqli_query($conn,$sql1)or die(mysqli_error($conn));
        $userName=""; $userEmail="";
        if ($userResult->num_rows > 0) {
            while($rowResult1 = $userResult->fetch_array()){
                $userName=$rowResult1['name'];
                $userEmail=$rowResult1['email'];
            }
        }

        $systemAdminName=""; $systemAdminEmail="";
        $sql="select name,email from user where system_admin='1'";
        $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            $systemAdminName= $row['name'];
            $systemAdminEmail= $row['email'];
        }else{
            echo "5";
            exit();
        }

        $query="update inventory set status='4' where id='$invId'";
        $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
        if ($result === TRUE) {

       		$to = $systemAdminEmail; $cc = $userEmail;
            $subject = "Asset Returned";
            $body = "Hi $systemAdminName,<br><br>$userName has returned following inventory:<br><b>Asset Name:</b> $asset_name &nbsp;&nbsp; <b>Description:</b> $description<br><br>Thanks,<br>TagOps.";
            $send_mail_value = send_email( $to,$cc,$subject,$body );
            header( 'Content-Type: application/json' );
            echo json_encode( $send_mail_value );
        }else {
            echo "0";
        }                                                           
	}     
}

if($_POST['ACTION']=="getFilteredData"){
	$echoData="";                          
  if(!isset($_POST['filter-assets']) || $_POST['filter-assets']=="0"){
    $user_id=$_SESSION['userid']; 
    $query = "Select * from inventory where assigned_to='$user_id' AND status NOT LIKE '1'";
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result->num_rows > 0) {
      $index=1;
      $echoData.="<thead> <tr> <th>S.No.</th> <th>Type</th> <th>Description</th> <th>Status</th> <th>Action</th> </tr> </thead> <tbody>";
      while ($row = $result->fetch_array()){
        $type_id=$row['type'];
        $q1="select asset_name from asset_type where id='$type_id' ";
        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
        $r1=$rs1->fetch_array();
        $user_id=$row['assigned_to'];
                                          
        $q3="select name from user where id=$user_id";
        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
        $r3=$rs3->fetch_array();
        $status=$row['status'];
        if($status=="1"){
          $status="Free";
        }else if($status=="2"){
          $status="Given";
        }else if($status=="3"){
          $status="Assigned";
        }else if($status=="4"){
          $status="Returned";
        }
        
        $echoData.= "<tr><td>".$index.".</td> <td >".$r1['asset_name']."</td> <td >".$row['description']."</td> <td >".$status."</td>";

        if($status=="Given"){
          $echoData.=  "<td ><button id='changebtn".$index."' onclick='acceptUserAsset(".$row['id'].")' class='btn btn-xs' style='background-color: #7cc576; color:'#ffffff'>Accept</button>
          <button id='rejectbtn".$index."' onclick='rejectUserAsset(".$row['id'].")' class='btn btn-xs' style='background-color: #fea862; color:'#ffffff'>Reject</button></td>";
        }else if($status=="Assigned"){
          $echoData.= "<td ><button id='changebtn".$index."' onclick='returnAsset(".$row['id'].")' class='btn btn-xs' style='background-color: #ec585d;color='#ffffff'>Return</button></td>";
        }else if($status=="Returned"){
          $echoData.= " <td >No Action</td>";
        }

        $echoData.=    "</tr>";

        $index++;
      }
      echo $echoData;
      exit();
    } else{
      echo " No entry in this table !";
    }
  }else if(isset($_POST['filter-assets'])){
    $filter=$_POST['filter-assets'];
    $user_id=$_SESSION['userid'];
    $query = "Select * from inventory where assigned_to='$user_id' AND status='$filter'";
    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result->num_rows > 0) {
      $index=1;
      $echoData.="<thead> <tr> <th>S.No.</th> <th>Type</th> <th>Description</th> <th>Status</th> <th>Action</th> </tr> </thead> <tbody>";
      while ($row = $result->fetch_array()){
        $type_id=$row['type'];
        $q1="select asset_name from asset_type where id='$type_id'";
        $rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
        $r1=$rs1->fetch_array();
        $user_id=$row['assigned_to'];
                                          
        $q3="select name from user where id=$user_id";
        $rs3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
        $r3=$rs3->fetch_array();
        $status=$row['status'];
        if($status=="1"){
          $status="Free";
        }else if($status=="2"){
          $status="Given";
        }else if($status=="3"){
          $status="Assigned";
        }else if($status=="4"){
          $status="Returned";
        }
        
        $echoData.= "<tr><td>".$index.".</td> <td >".$r1['asset_name']."</td> <td >".$row['description']."</td> <td >".$status."</td>";

        if($status=="Given"){
          $echoData.=  "<td ><button id='changebtn".$index."' onclick='acceptUserAsset(".$row['id'].")' class='btn btn-xs' style='background-color: #7cc576; color='#ffffff'>Accept</button>
          <button id='rejectbtn".$index."' onclick='rejectUserAsset(".$row['id'].")' class='btn btn-xs' style='background-color: #7cc576; color:'#ffffff'>Reject</button></td>";
        }else if($status=="Assigned"){
          $echoData.=  "<td ><button id='changebtn".$index."' onclick='returnAsset(".$row['id'].")' class='btn btn-xs' style='background-color: #ec585d;color='#ffffff'>Return</button></td>";
        }else if($status=="Returned"){
          $echoData.= " <td >No Action</td>";
        }
        
        $echoData.=   "</tr>";
        
        $index++;
      }
      
      echo $echoData;
      exit();
    } else{
      echo "<h4> No entry in this table ! <h4>";
    }                            
  }
}

?>