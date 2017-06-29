<?php
include_once('database.php');
include_once('commonUtilities.php');
include 'session.php';
include 'config.php';
$conn = getDB();

if($_POST["ACTION"]=="changeExpenseCategoryStatus"){
	if(isset($_POST['catId'])){
	    $catId=$_POST['catId'];

	    $q1="SELECT status FROM categories WHERE id='$catId'";
	    $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
	    $ro1 = $re1->fetch_array();
	    $status=$ro1['status'];

	    if ($status=='1') {
	    	$status='0';
	    }else if($status=='0'){
	    	$status='1';
	    }

	    $sql="UPDATE  categories SET status='$status' WHERE id='$catId' ";
	    if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
	    	echo 1;
	    }else {
	        echo 0;
	    }                      
	}
}

if($_POST["ACTION"]=="changeProjectState"){
	if(isset($_POST['projId'])){
	    $projId=$_POST['projId'];

	    $q1="SELECT state FROM projects WHERE id='$projId'";
	    $re1 = mysqli_query($conn, $q1)or die(mysqli_error($conn));
	    $ro1 = $re1->fetch_array();
	    $state=$ro1['state'];

	    if ($state=='1') {
	    	$state='0';
	    }else if($state=='0'){
	    	$state='1';
	    }

	    $sql="UPDATE  projects SET state='$state' WHERE id='$projId' ";
	    if ($result=mysqli_query($conn,$sql)or die(mysqli_error($conn))) {
	    	echo 1;
	    }else {
	        echo 0;
	    }                      
	}
}

if($_POST["ACTION"]=="addToWallet"){
	if(isset($_POST['submit'])){
		$advance=$_POST['advance'];
		$remarks=$_POST['remarks'];
		$user_id=$_POST['id'];
		$date=$_POST['date'];
		if($advance== '' || $remarks=='' || $date==''){
			echo "<script type='text/javascript'>alert('Please fill all the fields!'); window.location.replace('../adminExpenseManagement.php');</script>";
		}else{
			$query = "INSERT INTO wallet (user_id,date,transactions,remarks) VALUES ('$user_id','$date','$advance','$remarks')";
	        $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	        if ($result === TRUE) {
	            echo "<script type='text/javascript'>alert('Balance added to Wallet!'); window.location.replace('../adminExpenseManagement.php');</script>";
	        }else {
	            echo "<script type='text/javascript'>alert('Unable to add Balance to Wallet!'); window.location.replace('../adminExpenseManagement.php');</script>";
	        }
		}
	}
}

if($_POST["ACTION"]=="changeReimbursementStatus"){
    $dataId=$_POST['id'];
    $query="select amount,reimbursed,details,user_id,project_id from data where id='$dataId'";
    $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result1->num_rows > 0) {
        while($row1 = $result1->fetch_array()){
            $details=$row1['details'];
            $projId=$row1['project_id'];
            $reim=$row1['reimbursed'];
            $amount=$row1['amount'];
            $user_id=$row1['user_id'];
            $today=date('Y-m-d');

            $sql="SELECT name FROM projects WHERE id='$projId'";
            $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
            $projName="";
            if ($result->num_rows > 0) {
                while($row = $result->fetch_array()){
                    $projName=$row['name'];
                }
            }

            if($reim=="0"){
                $remarks=$projName." -> ".$details;
                $q1="select SUM(transactions) as sumBalance from wallet where user_id='$user_id'";
                $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
                if ($re1->num_rows > 0) {
                    while($ro1 = $re1->fetch_array()){
                        $amount=(-1)*$amount;
                        $q2="INSERT into wallet (transactions,date,user_id,remarks) VALUES ('$amount','$today','$user_id','$remarks') ";
                        $re2=mysqli_query($conn,$q2)or die(mysqli_error($conn));
                        if ($re2 === TRUE){
                        
                        }else{
                            echo "2";
                        }

                        $change="1";
                        $q3="UPDATE data SET reimbursed='$change' WHERE id='$dataId' ";
                        $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));
                        if ($re3 === TRUE) {
                        
                        }else {
                            echo "3";
                        }
                        echo "1"; 
                    }
                }else{
                    echo "4";
                }
            }else{
                echo "5"; 
            }

        }
    }
}

if($_POST["ACTION"]=="rejectEntry"){
    $dataId=$_POST['id'];
    $query="select reimbursed from data where id='$dataId'";
    $result1=mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result1->num_rows > 0) {
        while($row1 = $result1->fetch_array()){
            $reim=$row1['reimbursed'];
            if($reim=="0"){
                $change="2";
                $q3="UPDATE data SET reimbursed='$change' WHERE id='$dataId' ";
                $re3=mysqli_query($conn,$q3)or die(mysqli_error($conn));   
                if ($re3 === TRUE){
                    echo "1";                  
               	}else{
                    echo "2";
                }
            }else if($reim=="1"){
                echo "3";
            }else if($reim=="2"){
                echo "4";
            }  
        }
    }                        
}
?>