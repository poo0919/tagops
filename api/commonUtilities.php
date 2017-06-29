<?php

function getAllUserDetails($conn){
	$query = "SELECT * FROM user WHERE status='1'";
	$result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	$rows = [];
	while($row = mysqli_fetch_array($result))
	{
	    $rows[] = $row;
	}
	return $rows;
}

function getHRDetails($conn){
	$hrName=""; $hrEmail="";
    $sql="SELECT name,email FROM user WHERE hr='1'";
    $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
    if ($result->num_rows > 0) {
        $row = $result->fetch_array();
        $hrName= $row['name'];
        $hrEmail= $row['email'];
    }
    $returnData = array('name' => $hrName , 'email' => $hrEmail );
    return $returnData;
}

function getSystemAdminDetails($conn){
    $systemAdminName=""; $systemAdminEmail="";
    $sql="SELECT name,email FROM user WHERE system_admin='1'";
    $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
    if ($result->num_rows > 0) {
        $row = $result->fetch_array();
        $systemAdminName= $row['name'];
        $systemAdminEmail= $row['email'];
    }
    $returnData = array('name' => $systemAdminName , 'email' => $systemAdminEmail );
    return $returnData;
}

function getParticularUserDetails($conn,$user_id){
	$sql1 = "SELECT name,email,rm_id FROM user where id='$user_id'"; //fetching user details
    $userResult=mysqli_query($conn,$sql1)or die(mysqli_error($conn));
    $userName=""; $userEmail=""; $rm_id="";
    if ($userResult->num_rows > 0) {
        while($rowResult1 = $userResult->fetch_array()){
            $userName=$rowResult1['name'];
            $userEmail=$rowResult1['email'];
            $rm_id=$rowResult1['rm_id'];
        }
    }
    $returnData = array('name' => $userName , 'email' => $userEmail , 'rm_id' => $rm_id );
    return $returnData;
}

function getRMDetails($conn,$rm_id){
	$sql = "SELECT name,email FROM user WHERE id='$rm_id'";  //fetching RM details
    $mgrResult=mysqli_query($conn,$sql)or die(mysqli_error($conn));
    $mgrName=""; $mgrEmail="";
    if ($mgrResult->num_rows > 0) {
        while($rowResult = $mgrResult->fetch_array()){
            $mgrName=$rowResult['name'];
            $mgrEmail=$rowResult['email'];
        }
    }
    $returnData = array('name' => $mgrName , 'email' => $mgrEmail );
    return $returnData;
}

?>