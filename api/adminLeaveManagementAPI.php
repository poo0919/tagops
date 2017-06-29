<?php
include_once('database.php');
require_once('email.php');
include_once('commonUtilities.php');
include 'session.php';
include 'config.php';
$conn = getDB();

if($_POST["ACTION"]=="deleteGH"){
	if(isset($_POST['ghId'])){
	    $ghId=$_POST['ghId'];
	    $query="DELETE FROM general_holidays WHERE id='$ghId' ";
	    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	    echo 1;
	}
}

if($_POST["ACTION"]=="deleteRH"){
	if(isset($_POST['rhId'])){
	    $rhId=$_POST['rhId'];
	    $query="DELETE FROM restricted_holidays WHERE id='$rhId' ";
	    $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	    echo 1;
	}
}

if($_POST["ACTION"]=="updateLeaves"){
	$id=$_POST['leaveid'];
	$clplml=$_POST['clplml'];
	$rh1=$_POST['rh1'];
	$sql = "update leaves set pl_cl_ml='$clplml',rh='$rh1' where id='$id'";
	$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
	if($result === TRUE){
		echo "<script>alert('Leaves updated!');window.location.href='../adminLeaveManagement.php';</script>";
	}else{
   		echo "<script>alert('error!');window.location.href='../adminLeaveManagement.php';</script>";
   	}
}

if($_POST["ACTION"]=="updateRH"){
	if( !isset($_POST['occasion']) && !isset($_POST['date1'])){
	echo "<script type='text/javascript'>window.location.href='../adminLeaveManagement.php';alert('Field is empty!');</script>";
	}else{
		if(!isset($_POST['id'])){
			echo "<script type='text/javascript'>window.location.href='../adminLeaveManagement.php';alert('Field is empty!');</script>";
		}else{
	    	$rhId=$_POST['id'];
	        $occasion=$_POST['occasion'];
	        $date1=$_POST['date1'];
	        $sql="UPDATE restricted_holidays SET occasion='$occasion',date='$date1' WHERE id='$rhId' ";
	        if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
	            echo "<script type='text/javascript'>alert('RH Updated!');window.location.href='../adminLeaveManagement.php';</script>";  
	        }else {
	            echo "Error: " . $sql . "<br>" . $conn->error;
	        }
	    }
	}  
}

if($_POST["ACTION"]=="updateGH"){
	if( !isset($_POST['ghoccasion1']) && !isset($_POST['ghdate1'])){
		echo "<script type='text/javascript'>window.location.href='../adminLeaveManagement.php';alert('Field is empty!');</script>";
	}else{
		if(!isset($_POST['ghid'])){
			echo "<script type='text/javascript'>window.location.href='../adminLeaveManagement.php';alert('Field is empty!');</script>";
		}else{
	    	$ghId=$_POST['ghid'];
	        $occasion=$_POST['ghoccasion1'];
	        $date1=$_POST['ghdate1'];
	        $sql="UPDATE general_holidays SET occasion='$occasion',date='$date1' WHERE id='$ghId' ";
	        if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
	            echo "<script type='text/javascript'>alert('GH Updated!');window.location.href='../adminLeaveManagement.php';</script>";  
	        }else {
	            echo "Error: " . $sql . "<br>" . $conn->error;
	        }
	    }
	}
}
?>