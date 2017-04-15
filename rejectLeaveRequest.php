<?php
//api for rejecting the leave request and updating db

include 'connection.php';
include 'empSession.php';
if(isset($_POST['applyLeaveId'])){
    $applyLeaveId=$_POST['applyLeaveId'];
    $leaveTypeId=$_POST['leaveTypeId'];
    $userId=$_POST['userId'];


    $userMail="";
        $queryMail="SELECT * FROM user where id='$userId'";
        $resultMail=mysqli_query($conn,$queryMail)or die(mysqli_error($conn));
                if ($resultMail->num_rows > 0) {
                    while($rowMail = $resultMail->fetch_array()){
                        $userMail=$rowMail['email'];
                    }
                }

        $userDate=""; $halfFull="";
        $queryDate="SELECT * FROM leave_data where id='$applyLeaveId'";
        $resultDate=mysqli_query($conn,$queryDate)or die(mysqli_error($conn));
                if ($resultDate->num_rows > 0) {
                    while($rowDate = $resultDate->fetch_array()){
                        $userDate=$rowDate['for_date'];
                        $halfFull=$rowDate['half_full'];
                    }
                }


    $comp_off="";
    $pl_cl_ml="";
    $rh="";
    $q1="select pl_cl_ml,comp_off,rh from leaves where user_id='$userId'";
    $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
    if ($re1->num_rows > 0) {
      	while($ro1 = $re1->fetch_array()){
			$comp_off=$ro1['comp_off'];
			$pl_cl_ml=$ro1['pl_cl_ml'];
            $rh=$ro1['rh'];
        }
    }

    if($leaveTypeId=="2"){
    	$status="3";
    	$comp_off+=1;
    	$q2="update leaves set comp_off='$comp_off' where user_id='$userId'";
    }else if($leaveTypeId=="1"){
    	$status="6";
        if($halfFull=="Full")
            $pl_cl_ml+=1;
        else if($halfFull=="Half")
            $pl_cl_ml+=0.5;
        
    	$q2="update leaves set pl_cl_ml='$pl_cl_ml' where user_id='$userId'";
    }else if($leaveTypeId=="3"){
        $status="6";
        $q2="update leaves set rh='$rh' where user_id='$userId'";
    }

    $query="update leave_data set status='$status' where id='$applyLeaveId'";
	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));

        if ($result === TRUE) {

		    $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
		    if ($re2 === TRUE) {
            	//echo "1";
                $dataArray =array( 
                                "userMail" => $userMail,
                                "forDate" => $userDate,

                           );
                                            
                            echo json_encode($dataArray);
		    }

        }else {
            echo "0";
        }    
   }                               
                                
?>