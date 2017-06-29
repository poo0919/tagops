<?php
include_once('database.php');
require_once('email.php');
include_once('commonUtilities.php');
include 'empSession.php';
include 'config.php';
$conn = getDB();

$hrDetails = [];
$hrDetails = getHRDetails($conn);
$hrName = $hrDetails['name'];
$hrEmail = $hrDetails['email'];

if($_POST['ACTION']=="newCompOff"){
    if(!empty($_POST['againstDate']) && !empty($_POST['reason'])) {
        $againstDate=$_POST['againstDate'];
        $reason=mysqli_real_escape_string($conn,$_POST['reason']);
        $userId=$_POST['userId'];
        $rpId=$_POST['rpId'];

        $comp_off="";
        $q1="select comp_off from leaves where user_id='$rpId'";  //getting number of comp_off available from leaves table in db
        $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
        if ($re1->num_rows > 0) {
            while($ro1 = $re1->fetch_array()){
                $comp_off=$ro1['comp_off'];
            }
        }

        //getting reportee details 
        $particularUserDetails = [];
        $particularUserDetails = getParticularUserDetails($conn,$rpId);
        $reporteeName = $particularUserDetails['name'];
        $reporteeMail = $particularUserDetails['email'];
              
        $expiryDate=date('Y-m-d', strtotime("+3 months", strtotime($againstDate))); // calculating expiry date for comp off entry
                   
        $sql = "INSERT INTO leave_data (user_id,type_id,against_date,expiry_date,compoff_reason,status) VALUES ('$rpId','2','$againstDate','$expiryDate','$reason','3')";
        if ($result=mysqli_query($conn,$sql)) {
            $comp_off+=1; //incrementing comp off on new comp off entry
            $q2="update leaves set comp_off='$comp_off' where user_id='$rpId'"; // updating comp off value in leaves table 
            $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
            if ($re2 === TRUE) {
                $to = $reporteeMail;
                $cc="";
                $subject = "New CompOff Given";
                $body = "Hi $reporteeName,<br><br>You are assigned a new Comp Off <b>Against date:</b> $againstDate<br><br>Thanks,<br>TagOps.";
                $send_mail_value = send_email( $to,$cc,$subject,$body );
                header( 'Content-Type: application/json' );
                echo json_encode( $send_mail_value );
            }
        }else {                                                                   
            echo "0";
        }      
    }else {
        echo "2";
    }
}

if($_POST["ACTION"]=="delete"){
    if(isset($_POST['applyLeaveId'])){
        $applyLeaveId=$_POST['applyLeaveId'];
        $userId=$_POST['userId'];

        $comp_off="";
        $q1="select comp_off from leaves where user_id='$userId'";
        $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
        if ($re1->num_rows > 0) {
            while($ro1 = $re1->fetch_array()){
                $comp_off=$ro1['comp_off'];
            }
        }

        $comp_off-=1;
        $q2="update leaves set comp_off='$comp_off' where user_id='$userId'";
        $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
        if ($re2 === TRUE) {
            $query="DELETE FROM leave_data WHERE id='$applyLeaveId' ";
            $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
            echo "1";
        }else{
            echo "0";
        }
    }
}

if($_POST['ACTION']=="cancelLeave"){
	$applyLeaveId=$_POST['applyLeaveId']; $leaveTypeId=$_POST['leaveTypeId']; $userId=$_POST['userId']; 
	
	if(empty($applyLeaveId) || empty($leaveTypeId) || empty($userId)){
	    echo "1"; exit();
	}

	$userDate=""; $halfFull=""; $fromDate=""; $toDate="";
	$queryDate="SELECT * FROM leave_data where id='$applyLeaveId'";
	$resultDate=mysqli_query($conn,$queryDate)or die(mysqli_error($conn));
	if ($resultDate->num_rows > 0) {
	    while($rowDate = $resultDate->fetch_array()){
	        $userDate=$rowDate['for_date'];
	        $fromDate=$rowDate['for_date'];
	        $toDate=$rowDate['to_date'];
	        $halfFull=$rowDate['half_full'];
	    }
	}

	if($toDate!="0000-00-00"){
	    $userDate="from( ".$fromDate." ) -> to( ".$toDate." ) ";
	}

	$comp_off=""; $pl_cl_ml=""; $rh="";
	$q1="select pl_cl_ml,comp_off,rh from leaves where user_id='$userId'";
	$re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
	if ($re1->num_rows > 0) {
	    while($ro1 = $re1->fetch_array()){
	        $comp_off=$ro1['comp_off'];
	        $pl_cl_ml=$ro1['pl_cl_ml'];
	        $rh=$ro1['rh'];
	    }
	}

	$particularUserDetails = [];
	$particularUserDetails = getParticularUserDetails($conn,$userId);
	$userName = $particularUserDetails['name'];
	$userMail = $particularUserDetails['email'];

	if($leaveTypeId=="2"){
	    $status="3"; $comp_off+=1;

	    $q2="update leaves set comp_off='$comp_off' where user_id='$userId'";
	        
	    $query="update leave_data set status='$status' where id='$applyLeaveId'";
	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	    if ($result === TRUE) {
	        $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
	        if ($re2 === TRUE) {
	            $subject = "Leave Cancelled";
	            $body = "Hi $userName,<br><br>Your Leave Request <b>For Date:</b> $userDate has been cancelled.<br><br>Thanks,<br>TagOps.";
	            $to = $userMail; $cc = $hrEmail;
	            $send_mail_value = send_email( $to,$cc,$subject,$body );
	            header( 'Content-Type: application/json' );
	            echo json_encode( $send_mail_value );
	        }
	    }else {
	        echo "0";
	    }
	}else if($leaveTypeId=="1"){
	    $status="6";

	    if($halfFull=="Full"){
	        $start_ts = strtotime($fromDate); // start time stamp
	        $end_ts = strtotime($toDate); // end time stamp
	        $day_sec = 86400;
	        $interval =1+ ($end_ts - $start_ts)/$day_sec; // number of days
	        $countSat = 0; $countSun = 0;
	        $working_ts = $start_ts;
	        while ($working_ts <= $end_ts) { // loop through each day to find saturdays
	            $day = date('w', $working_ts);
	            if ($day == 6) { // this is a saturday
	                $countSat++;
	            }else if($day == 0){ // this is a sunday
	                $countSun++;
	            }
	            $working_ts = $working_ts + $day_sec;
	        }

	        $leaveDays=$interval-($countSun+$countSat);
	        
	        $sql="SELECT date from general_holidays ";
	        $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
	        if ($result->num_rows > 0) {
	            while($row = $result->fetch_array()){
	                $ghDate=$row['date'];
	                if (($ghDate >= $fromDate) && ($ghDate <= $toDate)){
	                    $leaveDays--;
	                }
	            }
	        }
	        $pl_cl_ml+=$leaveDays;
	    }
	    
	    else if($halfFull=="Half")
	        $pl_cl_ml+=0.5;
	        
	    $q2="update leaves set pl_cl_ml='$pl_cl_ml' where user_id='$userId'";

	    $query="DELETE from leave_data where id='$applyLeaveId'";
	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));

	    if ($result === TRUE) {

	        $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
	        if ($re2 === TRUE) {
	            $subject = "Leave Cancelled";
	            $body = "Hi $userName,<br><br>Your Leave Request <b>For Date:</b> $userDate has been cancelled.<br><br>Thanks,<br>TagOps.";
	            $to = $userMail; $cc = $hrEmail;
	            $send_mail_value = send_email( $to,$cc,$subject,$body );
	            header( 'Content-Type: application/json' );
	            echo json_encode( $send_mail_value );
	        }
	    }else {
	        echo "0";
	    }
	}else if($leaveTypeId=="3"){
	    $status="6"; $rh+=1;
	    
	    $q2="update leaves set rh='$rh' where user_id='$userId'";
	        
	    $query="DELETE from leave_data where id='$applyLeaveId'";
	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	    if ($result === TRUE) {
	        $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
	        if ($re2 === TRUE) {
	            $subject = "Leave Cancelled";
	            $body = "Hi $userName,<br><br>Your Leave Request <b>For Date:</b> $userDate has been cancelled.<br><br>Thanks,<br>TagOps.";
	            $to = $userMail; $cc = $hrEmail;
	            $send_mail_value = send_email( $to,$cc,$subject,$body );
	            header( 'Content-Type: application/json' );
	            echo json_encode( $send_mail_value );
	        }
	    }else {
	        echo "0";
	    }
	}else if($leaveTypeId=="4"){
	    $query="DELETE from leave_data where id='$applyLeaveId'";
	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	    if ($result === TRUE) {
	        $subject = "Leave Cancelled";
	        $body = "Hi $userName,<br><br>Your Leave Request <b>For Date:</b> $userDate has been cancelled.<br><br>Thanks,<br>TagOps.";
	        $to = $userMail; $cc = $hrEmail;
	        $send_mail_value = send_email( $to,$cc,$subject,$body );
	        header( 'Content-Type: application/json' );
	        echo json_encode( $send_mail_value );
	    }else {
	        echo "0";
	    }
	}    

}

if($_POST['ACTION']=="approve"){
    if(isset($_POST['applyLeaveId'])){
        $applyLeaveId=$_POST['applyLeaveId'];
        $leaveTypeId=$_POST['leaveTypeId'];
        $userId=$_POST['userId'];

        $particularUserDetails = [];
        $particularUserDetails = getParticularUserDetails($conn,$userId);
        $userName = $particularUserDetails['name'];
        $userMail = $particularUserDetails['email'];
      
        $userDate=""; $fromDate=""; $toDate="";
        $queryDate="SELECT * FROM leave_data where id='$applyLeaveId'";
        $resultDate=mysqli_query($conn,$queryDate)or die(mysqli_error($conn));
        if ($resultDate->num_rows > 0) {
            while($rowDate = $resultDate->fetch_array()){
                $userDate=$rowDate['for_date'];
                $fromDate=$rowDate['for_date'];
                $toDate=$rowDate['to_date'];
            }
        }

        if(empty($toDate)){
            $userDate=$fromDate;
        }else if($toDate!="0000-00-00"){
            $userDate="from( ".$fromDate." ) -> to( ".$toDate." ) ";
        }

        if($leaveTypeId=="2"){
            $status="4";
        }else if($leaveTypeId=="1"){
            $status="2";
        }else if($leaveTypeId=="3"){
            $status="2";
        }else if($leaveTypeId=="4"){
            $status="2";
        }

        if($leaveTypeId=="3"){
            $rh="";
            $q1="select rh from leaves where user_id='$userId'";
            $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
            if ($re1->num_rows > 0) {
                while($ro1 = $re1->fetch_array()){
                    $rh=$ro1['rh'];
                }
            }

            if($rh>0){
                $query="update leave_data set status='$status' where id='$applyLeaveId'";
                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));

                if ($result === TRUE) {
                    $to = $userMail; $cc = $hrEmail;
                    $subject = "Leave Request - Approved";
                    $body = "Hi $userName,<br><br>Your Leave Request <b>For Date:</b> $userDate has been approved.<br><br>Thanks,<br>TagOps.";
                    $send_mail_value = send_email( $to,$cc,$subject,$body );
                    header( 'Content-Type: application/json' );
                    echo json_encode( $send_mail_value );
                }else {
                    echo "0";
                }
            }else{
                echo "2";
            }            
        }else if($leaveTypeId=="4"){
            $query="update leave_data set status='$status' where id='$applyLeaveId'";
            $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
            if ($result === TRUE) {
                $to = $userMail; $cc = $hrEmail;
                $subject = "Leave Request - Approved";
                $body = "Hi $userName,<br><br>Your Leave Request <b>For Date:</b> $userDate has been approved.<br><br>Thanks,<br>TagOps.";
                $send_mail_value = send_email( $to,$cc,$subject,$body );
                header( 'Content-Type: application/json' );
                echo json_encode( $send_mail_value );
            }else {
                echo "0";
            }
        }else{
            $query="update leave_data set status='$status' where id='$applyLeaveId'";
            $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
            if ($result === TRUE) {
                $to = $userMail; $cc = $hrEmail;
                $subject = "Leave Request - Approved";
                $body = "Hi $userName,<br><br>Your Leave Request <b>For Date:</b> $userDate has been approved.<br><br>Thanks,<br>TagOps.";
                $send_mail_value = send_email( $to,$cc,$subject,$body );
                header( 'Content-Type: application/json' );
                echo json_encode( $send_mail_value );
            }else {
              echo "0";
            }
        }
    }                    
}

if($_POST['ACTION']=="reject"){
    if(isset($_POST['applyLeaveId'])){
        $applyLeaveId=$_POST['applyLeaveId'];
        $leaveTypeId=$_POST['leaveTypeId'];
        $userId=$_POST['userId'];

        $particularUserDetails = [];
        $particularUserDetails = getParticularUserDetails($conn,$userId);
        $userName = $particularUserDetails['name'];
        $userMail = $particularUserDetails['email'];

        $userDate=""; $halfFull=""; $fromDate=""; $toDate="";
        $queryDate="SELECT * FROM leave_data where id='$applyLeaveId'";
        $resultDate=mysqli_query($conn,$queryDate)or die(mysqli_error($conn));
        if ($resultDate->num_rows > 0) {
            while($rowDate = $resultDate->fetch_array()){
                $userDate=$rowDate['for_date'];
                $fromDate=$rowDate['for_date'];
                $toDate=$rowDate['to_date'];
                $halfFull=$rowDate['half_full'];
            }
        }

        if($toDate!="0000-00-00"){
            $userDate="from( ".$fromDate." ) -> to( ".$toDate." ) ";
        }

        $comp_off=""; $pl_cl_ml=""; $rh=""; $q2="";
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
            if($halfFull=="Full"){
                $start_ts = strtotime($fromDate); // start time stamp
                $end_ts = strtotime($toDate); // end time stamp
                $day_sec = 86400;
                $interval =1+ ($end_ts - $start_ts)/$day_sec; // number of days
                $countSat = 0; $countSun = 0;
                $working_ts = $start_ts;
                while ($working_ts <= $end_ts) { // loop through each day to find saturdays
                    $day = date('w', $working_ts);
                    if ($day == 6) { // this is a saturday
                        $countSat++;
                    }else if($day == 0){
                        $countSun++;
                    }
                    $working_ts = $working_ts + $day_sec;
                }

                $leaveDays=$interval-($countSun+$countSat);

                $sql="SELECT date from general_holidays ";
                $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_array()){
                        $ghDate=$row['date'];
                        if (($ghDate >= $fromDate) && ($ghDate <= $toDate)){
                            $leaveDays--;
                        }
                    }
                }
                     
                $pl_cl_ml+=$leaveDays;
            }
            else if($halfFull=="Half")
                $pl_cl_ml+=0.5;
            
            $q2="update leaves set pl_cl_ml='$pl_cl_ml' where user_id='$userId'";
        }else if($leaveTypeId=="3"){
            $status="6";
            $rh+=1;
            $q2="update leaves set rh='$rh' where user_id='$userId'";
        }else if($leaveTypeId=="4"){
            $status="6";
            $query="update leave_data set status='$status' where id='$applyLeaveId'";
            $result = mysqli_query($conn,$query)or die(mysqli_error($conn));

            if ($result === TRUE) {
                $to = $userMail; $cc = $hrEmail;
                $subject = "Leave Request - Rejected";
                $body = "Hi $userName,<br><br>Your Leave Request <b>For Date:</b> $userDate has been rejected.<br><br>Thanks,<br>TagOps.";
                $send_mail_value = send_email( $to,$cc,$subject,$body );
                header( 'Content-Type: application/json' );
                echo json_encode( $send_mail_value ); exit();
            }else {
                echo "0"; exit();
            }    

        }

        $query="update leave_data set status='$status' where id='$applyLeaveId'";
        $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
        if ($result === TRUE) {
            $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
            if ($re2 === TRUE) {
                $to = $userMail; $cc = $hrEmail;
                $subject = "Leave Request - Rejected";
                $body = "Hi $userName,<br><br>Your Leave Request <b>For Date:</b> $userDate has been rejected.<br><br>Thanks,<br>TagOps.";
                $send_mail_value = send_email( $to,$cc,$subject,$body );
                header( 'Content-Type: application/json' );
                echo json_encode( $send_mail_value );
            }
        }else {
            echo "0";
        }    
    }               
}

?>