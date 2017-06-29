<?php
include_once('database.php');
require_once('email.php');
include_once('commonUtilities.php');
include 'session.php';
include 'config.php';
$conn = getDB();

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

if($_POST["ACTION"]=="updateAsset"){
	if(isset($_POST['id']) && isset($_POST['assetName'])){
	    $invId=$_POST['id'];
	    $assetName=$_POST['assetName'];
	    $sql="UPDATE asset_type SET asset_name='$assetName' WHERE id='$invId' ";
	    if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
	        echo 1;  
	    }else {
	        echo "Error: " . $sql . "<br>" . $conn->error;
	    }
	}else{
		echo 0;
	}
}

if($_POST["ACTION"]=="updateRentalCompany"){
	if(isset($_POST['id']) && isset($_POST['companyname'])){
	    $rentId=$_POST['id'];
	    $rentCompany=$_POST['companyname'];
	    $sql="UPDATE rental_companies SET rental_company_name='$rentCompany' WHERE id='$rentId' ";
	    if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
	        echo "1";  
	    }else {
	        echo "Error: " . $sql . "<br>" . $conn->error;
	    }
	}else{
		echo "0";
	}
}

if($_POST["ACTION"]=="deleteRentalCompany"){
	if(isset($_POST['rentId'])){
	    $rentId=$_POST['rentId'];
	    $query="DELETE FROM rental_companies WHERE id='$rentId' ";
	    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	    echo 1;
	}
}

if($_POST["ACTION"]=="addInventory"){
	$assetType=$_POST['TYPE'];
    $description=mysqli_real_escape_string($conn,$_POST['DESCRIPTION']);  
    $owner=$_POST['OWNER'];
    $rentCompany=$_POST['RENTCOMPANY'];
    $price=$_POST['PRICE'];

	$query = "INSERT INTO inventory (type,description,price,owner,rental_company,status,assigned_to) VALUES ('$assetType','$description','$price','$owner','$rentCompany','1','0')";
	$result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	if ($result === TRUE) {
	    echo "1";
	}else {
	    echo "0";
	}
    exit();
}

if($_POST["ACTION"]=="assignAsset"){
	if(!empty($_POST['assignTo']) && !empty($_POST['id'])){
	    $invId=$_POST['id'];
	    $email=$_POST['assignTo'];

	    $sql = "SELECT * FROM inventory where id='$invId'"; //fetching inventory details
        $invResult=mysqli_query($conn,$sql)or die(mysqli_error($conn));
        $type_id=""; $description="";
        if ($invResult->num_rows > 0) {
            while($rowInvResult = $invResult->fetch_array()){
              	$type_id=$rowInvResult['type'];
                $description=$rowInvResult['description'];
            }
        }

        $asset_name="";
        $q1="select id,asset_name from asset_type where id='$type_id'";
		$rs1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
		$r1=$rs1->fetch_array();
		$asset_name=$r1['asset_name'];
	     
	    $sql="select id,name from user where email='$email' And status='1'";
	    $result = mysqli_query($conn, $sql)or die(mysqli_error($conn));
	    $row = $result->fetch_array();
	    $row_cnt = mysqli_num_rows($result);        
	    if ($row_cnt==1){		
	     	$userName=$row['name'];
	        $user_id=$row['id'];
	   	    $query="update inventory set status='2',assigned_to='$user_id' where id='$invId'";
	   	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	        if ($result === TRUE) {
	   	        $to = $email; $cc = $systemAdminEmail;
                $subject = "Asset Given";
                $body = "Hi $userName,<br><br>$systemAdminName has given you the following inventory:<br><b>Asset Name:</b> $asset_name &nbsp;&nbsp; <b>Description:</b> $description<br><br>Thanks,<br>TagOps.";
                $send_mail_value = send_email( $to,$cc,$subject,$body );
                header( 'Content-Type: application/json' );
                echo json_encode( $send_mail_value );
	     	}else{
	            echo "3";
	  	    }
	  	}else{
	      	echo "2";
	    }
    }else {
    	echo "0";
	}
}

if($_POST['ACTION']=='changeInventoryDetails'){
    $assetId=$_POST['assetId'];
    $chgDescription=mysqli_real_escape_string($conn,$_POST['chgDescription']);  
    $ownerName=$_POST['ownerName'];
    $rentName=$_POST['rentName'];
    $chgInvId=$_POST['chgInvId'];
    $chgPrice=$_POST['chgPrice'];

	$query = "UPDATE  inventory SET type='$assetId',description='$chgDescription',price='$chgPrice',owner='$ownerName',rental_company='$rentName' WHERE id='$chgInvId'";
	$result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	if ($result === TRUE) {
	    echo "1";
	}else {
	    echo "0";
	}
    exit();
}

if($_POST["ACTION"]=="acceptAsset"){
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

	    $query="update inventory set status='1',assigned_to='0' where id='$invId'";
	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	    if ($result === TRUE) {
	       	$to = $userEmail; $cc = $systemAdminEmail;
	        $subject = "Asset Accepted";
	        $body = "Hi $userName,<br><br>$systemAdminName has accepted the following inventory returned by you:<br><b>Asset Name:</b> $asset_name &nbsp;&nbsp; <b>Description:</b> $description<br><br>Thanks,<br>TagOps.";
	        $send_mail_value = send_email( $to,$cc,$subject,$body );
	        header( 'Content-Type: application/json' );
	        echo json_encode( $send_mail_value );
	    }else {
	        echo "0";
	    }     
	}    
}

if($_POST["ACTION"]=="rejectAsset"){
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

	    $query="update inventory set status='3',assigned_to='$user_id' where id='$invId'";
	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	    if ($result === TRUE) {
	        $to = $userEmail; $cc = $systemAdminEmail;
	        $subject = "Asset Rejected";
	        $body = "Hi $userName,<br><br>$systemAdminName has rejected the following inventory returned by you:<br><b>Asset Name:</b> $asset_name &nbsp;&nbsp; <b>Description:</b> $description<br><br>Thanks,<br>TagOps.";
	        $send_mail_value = send_email( $to,$cc,$subject,$body );
	        header( 'Content-Type: application/json' );
	    	echo json_encode( $send_mail_value );
	    }else {
	        echo "0";
	    }     
	}
}

if($_POST["ACTION"]=="deleteAssetRow"){
	if(isset($_POST['rowId'])){
	    $rowId=$_POST['rowId'];
	    $query="DELETE FROM inventory WHERE id='$rowId' "; 
	    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	    echo 1;
	}
}

if($_POST["ACTION"]=="changeAssetRowStatus"){
	if(isset($_POST['rowId'])){
	    $rowId=$_POST['rowId'];

	    $q1="SELECT status FROM asset_type WHERE id='$rowId'";
	    $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
	    $ro1 = $re1->fetch_array();
	    $status=$ro1['status'];

	    if ($status=='1') {
	    	$status='0';
	    }else if($status=='0'){
	    	$status='1';
	    }

	    $sql="UPDATE  asset_type SET status='$status' WHERE id='$rowId' ";
	    if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
	    	echo 1;
	    }else {
	        echo 0;
	    }                      
	}
}

if($_POST["ACTION"]=="getAdminFilteredData"){
	$echoData=""; $filter=""; $filterType=""; $where=""; $query1=""; $query2=""; $query3=""; $query4=""; $user_id=""; $assetName=array(); $rentalCompanyName=array(); $userName=array();

	if(isset($_POST['filter1-assets']) && $_POST['filter1-assets']!="all"){
	  $filter=$_POST['filter1-assets']; $filterType=1;
	  if($filter=="Rent"){
	     $where="AND owner='$filter'";
	  }else{
	    $where="AND owner NOT LIKE 'Rent'";
	  }
	}else if(isset($_POST['filter2-assets']) && $_POST['filter2-assets']!="all" && $_POST['filter2-assets']!="1"){
	  $filter=$_POST['filter2-assets']; $filterType=2;
	  $where="AND status='$filter'";
	}else if(isset($_POST['filter3-assets']) && $_POST['filter3-assets']!="all"){
	  $filter=$_POST['filter3-assets']; $filterType=3;
	  $where="AND type='$filter'";
	}else if( $_POST['filter1-assets']=="all" && $_POST['filter2-assets']=="all" && $_POST['filter3-assets']=="all"){
	  $filter=""; $filterType="all"; $where="";
	}

	$q1="SELECT * FROM asset_type";
	$re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
	if ($re1->num_rows > 0) {
	  while ($row1 = $re1->fetch_array()){
	    $assetName[$row1['id']]=$row1['asset_name'];
	  }
	}

	$q2="SELECT * FROM rental_companies";
	$re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
	if ($re2->num_rows > 0) {
	  while ($row2 = $re2->fetch_array()){
	    $rentalCompanyName[$row2['id']]=$row2['rental_company_name'];
	  }
	}

	$index=1;

	function getFreeData($conn,$assetName,$rentalCompanyName,$index,$filterVal,$where){
	  $freeData="";
	  $query="SELECT * FROM inventory WHERE assigned_to='0' $where";
	  $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	  if ($result->num_rows > 0) {
	    
	    while ($row = $result->fetch_array()){
	      if($row['owner']=="Rent"){
	        $rent_id=$row['rental_company'];
	        $rentCompany=$rentalCompanyName[$rent_id];                                    
	      }else{
	        $rentCompany="NA";
	        $rent_id="0";
	      }

	      $asset=$assetName[$row['type']];
	      $status="Free";
	      $freeData.= "<tr><td>".$index.".</td> <td >".$asset."</td> <td >".$row['description']."</td> <td >".$row['price']."</td> <td >".$row['owner']."</td> <td >".$rentCompany."</td> <td >".$status."</td>";
	        if($filterVal!=1){
	          $freeData.= "<td >NA</td>";
	        }
	      $freeData.= "<td><button id='editbtn".$index."' type='button' class='btn btn-xs' data-toggle='modal' data-target='#exampleModal1' onclick=modalFunction1()  data-id='".$row['id']."' style='color:#ffffff;background:#71D3f4;'>Assign</button></td> <td><span class='glyphicon glyphicon-pencil' id='editbtn".$index."' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$row['type']."' data-description='".$row['description']."' data-price='".$row['price']."' data-owner='".$row['owner']."' data-rent_company='".$rent_id."'  data-status='".$row['status']."' data-id='".$row['id']."'  style='color:#2a409f;cursor:pointer;'>Edit</span>&nbsp;&nbsp;<span class='glyphicon glyphicon-trash' onclick='deleteAssetRow(".$row['id'].")' id='delete".$index."' style='cursor:pointer;'></span></td><tr>";
	      $index++;
	    } 
	  }

	  return $return=array( "returnData" => $freeData, "index" => $index );
	  
	}

	if($_POST['filter2-assets']=="1"){

	  $returnData="";
	  $echoData.= "<thead> <tr><th>S.no</th> <th>Type</th> <th>Description</th> <th>Price</th> <th>Owner</th> <th>Rental Company</th> <th>Status</th> <th>Action</th> <th>Update</th> </tr></thead><tbody>";

	  $returnData=getFreeData($conn,$assetName,$rentalCompanyName,$index,$filterVal="1","");

	  echo $echoData.$returnData['returnData']; exit();
	  
	}else{

	  $returnData="";
	  $echoData.= "<thead> <tr><th>S.no</th> <th>Type</th> <th>Description</th> <th>Price</th> <th>Owner</th> <th>Rental Company</th> <th>Status</th> <th>Assigned To</th> <th>Action</th> <th>Update</th> </tr></thead><tbody>";
	  if($filterType!=2){
	    $returnData=getFreeData($conn,$assetName,$rentalCompanyName,$index,"0",$where);
	    $echoData.=$returnData['returnData'];
	    $index=$returnData['index'];
	  }
	  
	  $q3="SELECT * FROM user ORDER BY name";
	  $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
	  if ($re3->num_rows > 0) {
	    while ($row3 = $re3->fetch_array()){
	      $userName[$row3['id']]=$row3['name'];
	      $user_id=$row3['id'];

	      $query="SELECT * FROM inventory WHERE assigned_to='$user_id' $where";
	      $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	      if ($result->num_rows > 0) {

	        while ($row = $result->fetch_array()){

	          if($row['owner']=="Rent"){
	            $rent_id=$row['rental_company'];
	            $rentCompany=$rentalCompanyName[$rent_id];                                    
	          }else{
	            $rentCompany="NA";
	            $rent_id="0";
	          }

	          $status=$row['status'];
	          if($status=="2"){
	            $status="Given";
	          }else if($status=="3"){
	            $status="Assigned";
	          }else if($status=="4"){
	            $status="Returned";
	          }

	          $asset=$assetName[$row['type']];
	          $echoData.= "<tr><td>".$index.".</td> <td >".$asset."</td> <td >".$row['description']."</td> <td >".$row['price']."</td> <td >".$row['owner']."</td> <td >".$rentCompany."</td> <td >".$status."</td> <td >".$row3['name']."</td><td>";
	            if($status=="Given" || $status=="Assigned"){
	              $echoData.=  "No Action";
	            }else if($status=="Returned"){
	              $echoData.=  "<button id='changebtn".$index."' onclick='acceptAdminAsset(".$row['id'].")' class='btn btn-xs' style='color:#ffffff;background:#7cc576;' >Accept</button>
	              <button id='rejectbtn".$index."' onclick='rejectAdminAsset(".$row['id'].")' class='btn btn-xs' style='background: #fea862; color:'#ffffff';>Reject</button>";
	            }
	            
	            $echoData.="</td><td><span class='glyphicon glyphicon-pencil' id='editbtn".$index."' data-toggle='modal' data-target='#exampleModal3' onclick=modalFunction3() data-type='".$row['type']."' data-description='".$row['description']."' data-price='".$row['price']."' data-owner='".$row['owner']."' data-rent_company='".$rent_id."' data-id='".$row['id']."'  style='color:#2a409f;cursor:pointer;'>Edit</span>&nbsp;&nbsp;<span class='glyphicon glyphicon-trash' onclick='deleteAssetRow(".$row['id'].")' id='delete".$index."' style='cursor:pointer;'></span></td><tr>";

	            $index++;
	        } 
	      }
	    }
	  }

	echo $echoData; exit();

	}
}
?>