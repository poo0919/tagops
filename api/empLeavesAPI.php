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
	$rm_id = $particularUserDetails['rm_id'];

	$rmDetails = [];
	$rmDetails = getRMDetails($conn,$rm_id);
	$rmName = $rmDetails['name'];
	$rmEmail = $rmDetails['email'];

	if($leaveTypeId=="2"){
	    $status="3"; $comp_off+=1;

	    $q2="update leaves set comp_off='$comp_off' where user_id='$userId'";
	        
	    $query="update leave_data set status='$status' where id='$applyLeaveId'";
	    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
	    if ($result === TRUE) {
	        $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
	        if ($re2 === TRUE) {
	            $subject = "Leave Cancelled";
	            $body = "Hi $rmName,<br><br>$userName has himself/herself cancelled leaves <b>For Date:</b> $userDate .<br><br>Thanks,<br>TagOps.";
	            $to = $rmEmail; $cc = $hrEmail;
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
	            $body = "Hi $rmName,<br><br>$userName has himself/herself cancelled leave <b>For Date:</b> $userDate .<br><br>Thanks,<br>TagOps.";
	            $to = $rmEmail; $cc = $hrEmail;
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
	            $body = "Hi $rmName,<br><br>$userName has himself/herself cancelled leave <b>For Date:</b> $userDate .<br><br>Thanks,<br>TagOps.";
	            $to = $rmEmail; $cc = $hrEmail;
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
	        $body = "Hi $rmName,<br><br>$userName has himself/herself cancelled leave  <b>For Date:</b> $userDate .<br><br>Thanks,<br>TagOps.";
	        $to = $rmEmail; $cc = $hrEmail;
	        $send_mail_value = send_email( $to,$cc,$subject,$body );
	        header( 'Content-Type: application/json' );
	        echo json_encode( $send_mail_value );
	    }else {
	        echo "0";
	    }
	}    

}

if($_POST['ACTION']=="CLPLML"){
	$user_id=$_POST['clplml_user_id'];
    $fromDate=$_POST['fromDate']; $toDate=$_POST['toDate']; $halfFull=$_POST['halfFull']; 
    $clplmlreason=mysqli_real_escape_string($conn,$_POST['clplmlreason']); //againstdate contains id

    if(empty($halfFull)){
        echo "0"; exit();
    }

    if($halfFull=="Half"){//half day leaves shuold have same from and to date
        if(empty($fromDate) || empty($clplmlreason)){
            echo "0"; exit();
        }
    }else{
        if(empty($fromDate) || empty($toDate) || empty($clplmlreason)){
            echo "0"; exit();
        }
        if (($fromDate > $toDate)){
            echo "2"; exit();
        }
    }

    $clplml_count=""; 
    $q1="select pl_cl_ml,comp_off from leaves where user_id='$user_id'";
    $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
    if ($re1->num_rows > 0) {
        while($ro1 = $re1->fetch_array()){
            $clplml_count.=$ro1['pl_cl_ml'];
        }
    }
                
    $particularUserDetails = [];
	$particularUserDetails = getParticularUserDetails($conn,$user_id);
	$userName = $particularUserDetails['name'];
	$userMail = $particularUserDetails['email'];
	$rm_id = $particularUserDetails['rm_id'];

	$rmDetails = [];
	$rmDetails = getRMDetails($conn,$rm_id);
	$rmName = $rmDetails['name'];
	$rmEmail = $rmDetails['email'];
    
    $message=""; $leaveDays="";
    if($halfFull=="Full"){
        $sql="SELECT * from leave_data where (status='1' || status='2' || status='4' || status='5') AND user_id='$user_id'";
        $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
        if ($result->num_rows > 0) {
            while($row = $result->fetch_array()){
                $leaveDate1=$row['for_date'];  $leaveDate2=$row['to_date'];
                if ((($fromDate == $leaveDate1) || ($fromDate == $leaveDate2)) || (($toDate == $leaveDate1) || ($toDate == $leaveDate2)) || (($fromDate > $leaveDate1) && ($fromDate < $leaveDate2)) ||(($toDate > $leaveDate1) && ($toDate < $leaveDate2)))
                {
                    echo "3"; exit();
                }
            }
        }

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
    }else{
        $sql="SELECT for_date,to_date,half_full from leave_data where (status='1' || status='2' || status='4' || status='5') AND user_id='$user_id'";
        $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
        if ($result->num_rows > 0) {
            while($row = $result->fetch_array()){
                $leaveDate1=$row['for_date']; $leaveDate2=$row['to_date']; $half_full=$row['half_full'];
                if($half_full=="Full"){
                    if (($fromDate >= $leaveDate1) && ($fromDate <= $leaveDate2))
                    {
                        echo "3"; exit();
                    }
                }else if($half_full=="Half"){
                    if (($fromDate == $leaveDate1)){
                        echo "3"; exit();
                    }
                }else if(empty($half_full)){
                    if (($fromDate == $leaveDate1)){
                        echo "3"; exit();
                    }
                }
            }
        }
        $toDate="0000-00-00"; $leaveDays=0.5;
    }
            
if($leaveDays==0){
    echo "5";
    exit();
}

$q1="INSERT INTO leave_data (user_id,type_id,half_full,leave_count,for_date,to_date,reason,status) VALUES ('$user_id','1','$halfFull',$leaveDays,'$fromDate','$toDate','$clplmlreason','1')";
$re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
    if ($re1===TRUE) {
        if($halfFull=="Full")
            $clplml_count-=$leaveDays;
        else if($halfFull=="Half")
            $clplml_count-=0.5;

        $q2="update leaves set pl_cl_ml='$clplml_count' where user_id='$user_id'";
        $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
        if ($re2 === TRUE) {
            if($halfFull=="Full"){
                $dateCreated1=date_create($fromDate);
                $formattedfromDate1=date_format($dateCreated1, 'd-m-Y');
                $dateCreated2=date_create($toDate);
                $formattedtoDate1=date_format($dateCreated2, 'd-m-Y');
                $message.="<b>Leave Type:</b>PL+CL+ML&nbsp;&nbsp;&nbsp;&nbsp;<b>Half/Full:</b>".$halfFull."&nbsp;&nbsp;&nbsp;&nbsp;<b>Leave Dates:</b> from ( ".$formattedfromDate1." ) -> to ( ".$formattedtoDate1." )&nbsp;&nbsp;&nbsp;&nbsp;<b>Leave Reason:</b> ".$clplmlreason."<br>";
            }else{
                $dateCreated1=date_create($fromDate);
                $formattedfromDate1=date_format($dateCreated1, 'd-m-Y');
                $message.="<b>Leave Type:</b> PL+CL+ML&nbsp;&nbsp;&nbsp;&nbsp;<b>Half/Full:</b> ".$halfFull."&nbsp;&nbsp;&nbsp;&nbsp;<b>Leave Date:</b> ".$formattedfromDate1."&nbsp;&nbsp;&nbsp;&nbsp;<b>Leave Reason:</b> ".$clplmlreason."<br>";
            }
            
            $message = str_replace('\r\n' , ',&nbsp;&nbsp;', $message);
            $message = stripslashes($message);
            $to = $rmEmail;
            $cc = $hrEmail;
            $subject = "Leave request - $userName";
            $body = "Hi $rmName,<br><br>$userName has applied for following leaves:<br>$message<a href='$url/redirecting.php' target='_blank'>Click here to view!</a><br><br>Thanks,<br>TagOps.";
            $send_mail_value = send_email( $to,$cc,$subject,$body );
            header( 'Content-Type: application/json' );
            echo json_encode( $send_mail_value );
        }
    }  
}

if($_POST["ACTION"]=="CompOff"){
	$user_id=$_POST['compoff_user_id'];
    $for_compoff_date=$_POST['for_compoff_date']; $againstDate=$_POST['againstDate']; $compoff_reason=mysqli_real_escape_string($conn,$_POST['compoff_reason']); 
    $compOffReason=mysqli_real_escape_string($conn,$_POST['compOffReason']); //againstdate contains id
    if(empty($for_compoff_date) || empty($againstDate) || empty($compoff_reason) || empty($compOffReason)){
        echo "0"; exit();
    }

    $comp_off_count=""; 
    $q1="select pl_cl_ml,comp_off from leaves where user_id='$user_id'";
    $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
    if ($re1->num_rows > 0) {
        while($ro1 = $re1->fetch_array()){
            $comp_off_count=$ro1['comp_off'];
        }
    }
                
	$sql="SELECT for_date,to_date,half_full from leave_data where (status='1' || status='2' || status='4' || status='5') AND user_id='$user_id'";
    $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
    if ($result->num_rows > 0) {
        while($row = $result->fetch_array()){
            $leaveDate1=$row['for_date']; $leaveDate2=$row['to_date']; $half_full=$row['half_full'];
            if($half_full=="Full"){
              	if (($for_compoff_date >= $leaveDate1) && ($for_compoff_date <= $leaveDate2)){
                    echo "3"; exit();
                }
            }else if($half_full=="Half"){
                if (($for_compoff_date == $leaveDate1)){
                    echo "3"; exit();
                }
            }else if(empty($half_full)){
                if (($for_compoff_date == $leaveDate1)){
                   	echo "3"; exit();
                }
            }
        }
    }

    $message="";
	$sql="update leave_data set status='1',for_date='$for_compoff_date',half_full='Full', reason='$compoff_reason' where id='$againstDate'";
    $re = mysqli_query($conn,$sql)or die(mysqli_error($conn));
    if ($re === TRUE) {
        $comp_off_count-=1;
        $q2="update leaves set comp_off='$comp_off_count' where user_id='$user_id'";
        $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
        if ($re2 === TRUE) {
            $sql3 = "SELECT against_date,compoff_reason FROM leave_data where id='$againstDate'";
            $againstDateResult=mysqli_query($conn,$sql3)or die(mysqli_error($conn));
            $DateAgainst=""; $compOffReason="";
            if ($againstDateResult->num_rows > 0) {
                while($rowAgainstDateResult = $againstDateResult->fetch_array()){
                    $DateAgainst=$rowAgainstDateResult['against_date'];
                    $compOffReason=$rowAgainstDateResult['compoff_reason'];
                }
            }
            
            $message.="<b>Leave Type:</b> Comp Off&nbsp;&nbsp;&nbsp;&nbsp;<b>For Date:</b> ".$for_compoff_date."&nbsp;&nbsp;&nbsp;&nbsp;<b>Against Date:</b> ".$DateAgainst."&nbsp;&nbsp;&nbsp;&nbsp;<b>CompOff Reason:</b> ".$compOffReason."&nbsp;&nbsp;&nbsp;&nbsp;<b>Leave Reason:</b> ".$compoff_reason."<br>";
        }
    }
                
    $particularUserDetails = [];
	$particularUserDetails = getParticularUserDetails($conn,$user_id);
	$userName = $particularUserDetails['name'];
	$userMail = $particularUserDetails['email'];
	$rm_id = $particularUserDetails['rm_id'];

	$rmDetails = [];
	$rmDetails = getRMDetails($conn,$rm_id);
	$rmName = $rmDetails['name'];
	$rmEmail = $rmDetails['email'];            
                

    $to = $rmEmail; $cc = $hrEmail;
    $subject = "Leave Request - $userName";
    $body = "Hi $rmName,<br><br>$userName has applied for following leaves:<br>$message<a href='$url/redirecting.php' target='_blank'>Click here to view!</a><br><br>Thanks,<br>TagOps.";
    $send_mail_value = send_email( $to,$cc,$subject,$body );
    header( 'Content-Type: application/json' );
    echo json_encode( $send_mail_value );
}

if($_POST["ACTION"]=="RH"){
	$user_id=$_POST['rh_user_id'];
    $occasion=$_POST['occasion']; $rh_date=$_POST['rh_date']; $rh_reason=mysqli_real_escape_string($conn,$_POST['rh_reason']);
	
	if(empty($occasion) || empty($rh_date) || empty($rh_reason) ){
        echo "0"; exit();
    }

    $rh_count=""; 
    $q1="select rh from leaves where user_id='$user_id'";
    $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
    if ($re1->num_rows > 0) {
        while($ro1 = $re1->fetch_array()){
            $rh_count=$ro1['rh'];
        }
    }

    $sql="SELECT for_date from leave_data where (status='1' || status='2' || status='4' || status='5') AND user_id='$user_id'";
    $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
    if ($result->num_rows > 0) {
        while($row = $result->fetch_array()){
            $leaveDate1=$row['for_date'];        
            if (($rh_date == $leaveDate1)){
                echo "3"; exit();
            }
        }
    }
    
    $message="";
    if($rh_count>0){
        if($occasion=="Birthday"){
            $q1="INSERT INTO leave_data (user_id,type_id,half_full,for_date,reason,compoff_reason,status) VALUES ('$user_id','3','Full','$rh_date','$rh_reason','$occasion','1')";
            $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
            if ($re1===TRUE) {
                $rh_count-=1;
                $q2="update leaves set rh='$rh_count' where user_id='$user_id'";
                $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                if ($re2 === TRUE) {

                }   
            }
                    
            $message.="<b>Leave Type:</b> RH&nbsp;&nbsp;&nbsp;&nbsp;<b>RH Date:</b> ".$rh_date."&nbsp;&nbsp;&nbsp;&nbsp;<b>Occasion:</b> ".$occasion."&nbsp;&nbsp;&nbsp;&nbsp;<b>Leave Reason:</b> ".$rh_reason."<br>";
        }else{
            $q2="SELECT date,occasion FROM restricted_holidays where id='$occasion'";
            $re2=mysqli_query($conn,$q2) or die(mysqli_error($conn));
            $DateRH=""; $rh_occasion="";
            if ($re2->num_rows > 0) {
                while($ro2 = $re2->fetch_array()){
                    $DateRH=$ro2['date'];
                    $rh_occasion=$ro2['occasion'];
                }
            }
                    
            $q1="INSERT INTO leave_data (user_id,type_id,half_full,for_date,reason,compoff_reason,status) VALUES ('$user_id','3','Full','$DateRH','$rh_reason','$rh_occasion','1')";
            $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
            if ($re1===TRUE) {
                $rh_count-=1;
                $q2="update leaves set rh='$rh_count' where user_id='$user_id'";
                $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                if ($re2 === TRUE) {

                }
            }
                    
            $message.="<b>Leave Type:</b> RH&nbsp;&nbsp;&nbsp;&nbsp;<b>RH Date:</b> ".$DateRH."&nbsp;&nbsp;&nbsp;&nbsp;<b>Occasion:</b> ".$rh_occasion."&nbsp;&nbsp;&nbsp;&nbsp;<b>Leave Reason:</b> ".$rh_reason."<br>";
        }

        $particularUserDetails = [];
		$particularUserDetails = getParticularUserDetails($conn,$user_id);
		$userName = $particularUserDetails['name'];
		$userMail = $particularUserDetails['email'];
		$rm_id = $particularUserDetails['rm_id'];

		$rmDetails = [];
		$rmDetails = getRMDetails($conn,$rm_id);
		$rmName = $rmDetails['name'];
		$rmEmail = $rmDetails['email'];

        $to = $rmEmail; $cc = $hrEmail;
        $subject = "Leave Request - $userName";
        $body = "Hi $rmName,<br><br>$userName has applied for following leaves:<br>$message<a href='$url/redirecting.php' target='_blank'>Click here to view!</a><br><br>Thanks,<br>TagOps.";
        $send_mail_value = send_email( $to,$cc,$subject,$body );
        header( 'Content-Type: application/json' );
        echo json_encode( $send_mail_value );
    }else{
        echo "1";
    }
}

if($_POST['ACTION']=="WFH"){
	$user_id=$_POST['wfh_user_id'];
    $wfhfromDate=$_POST['wfhfromDate']; $wfhtoDate=$_POST['wfhtoDate']; $wfhhalfFull=$_POST['wfhhalfFull']; 
    $wfhreason=mysqli_real_escape_string($conn,$_POST['wfhreason']); //againstdate contains id

    if(empty($wfhhalfFull)){
        echo "0"; exit();
    }

    if($wfhhalfFull=="Half"){//half day leaves shuold have same from and to date
        if(empty($wfhfromDate) || empty($wfhreason)){
            echo "0"; exit();
        }     
    }else{
		if(empty($wfhfromDate) || empty($wfhtoDate) || empty($wfhreason)){
            echo "0"; exit();
        }
        if (($wfhfromDate > $wfhtoDate)){
            echo "2"; exit();
        }
    }
                
    $message=""; $leaveDays="";
    
    if($wfhhalfFull=="Full"){
        $sql="SELECT * from leave_data where (status='1' || status='2' || status='4' || status='5') AND user_id='$user_id'";
        $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
        if ($result->num_rows > 0) {
            while($row = $result->fetch_array()){
                $leaveDate1=$row['for_date'];  $leaveDate2=$row['to_date'];
                if ((($wfhfromDate == $leaveDate1) || ($wfhfromDate == $leaveDate2)) || (($wfhtoDate == $leaveDate1) || ($wfhtoDate == $leaveDate2)) || (($wfhfromDate > $leaveDate1) && ($wfhfromDate < $leaveDate2)) ||(($wfhtoDate > $leaveDate1) && ($wfhtoDate < $leaveDate2)))
                {
                    echo "3"; exit();
                }
            }
        }

        $start_ts = strtotime($wfhfromDate); // start time stamp
        $end_ts = strtotime($wfhtoDate); // end time stamp
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
                if (($ghDate >= $wfhfromDate) && ($ghDate <= $wfhtoDate)){
                    $leaveDays--;
                }
            }
        }
    }else{
        $sql="SELECT for_date,to_date,half_full from leave_data where (status='1' || status='2' || status='4' || status='5') AND user_id='$user_id'";
        $result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
        if ($result->num_rows > 0) {
            while($row = $result->fetch_array()){
                $leaveDate1=$row['for_date']; $leaveDate2=$row['to_date']; $wfhhalf_full=$row['half_full'];
                if($wfhhalf_full=="Full"){
                    if (($wfhfromDate >= $leaveDate1) && ($wfhfromDate <= $leaveDate2)){
                        echo "3"; exit();
                    }
                }else if($wfhhalf_full=="Half"){
                    if (($wfhfromDate == $leaveDate1)){
                        echo "3"; exit();
                	}
            	}else if(empty($wfhhalf_full)){
                	if (($wfhfromDate == $leaveDate1)){
                    	echo "3"; exit();
                	}
            	}	
        	}
    	}
        
        $wfhtoDate="0000-00-00";
        $leaveDays=0.5;
    }
           
    $q1="INSERT INTO leave_data (user_id,type_id,half_full,leave_count,for_date,to_date,reason,status) VALUES ('$user_id','4','$wfhhalfFull',$leaveDays,'$wfhfromDate','$wfhtoDate','$wfhreason','1')";
    $re1=mysqli_query($conn,$q1) or die(mysqli_error($conn));
    if ($re1===TRUE) {
        if($wfhhalfFull=="Full"){
            $dateCreated1=date_create($wfhfromDate);
            $formattedfromDate1=date_format($dateCreated1, 'd-m-Y');
            $dateCreated2=date_create($wfhtoDate);
            $formattedtoDate1=date_format($dateCreated2, 'd-m-Y');
            $message.="<b>Leave Type:</b> Work from Home&nbsp;&nbsp;&nbsp;&nbsp;<b>Half/Full:</b> ".$wfhhalfFull."&nbsp;&nbsp;&nbsp;&nbsp;<b>Leave Dates:</b> from ( ".$formattedfromDate1." ) -> to ( ".$formattedtoDate1." )&nbsp;&nbsp;&nbsp;&nbsp;<b>Leave Reason:</b> ".$wfhreason."<br>";
        }else{
            $dateCreated1=date_create($wfhfromDate);
            $formattedfromDate1=date_format($dateCreated1, 'd-m-Y');
                                                 
            $message.="<b>Leave Type:</b> Work from Home    <b>Half/Full:</b> ".$wfhhalfFull."    <b>Leave Date:</b> ".$formattedfromDate1."    <b>Leave Reason:</b> ".$wfhreason."<br>";
        }
                   
        $particularUserDetails = [];
		$particularUserDetails = getParticularUserDetails($conn,$user_id);
		$userName = $particularUserDetails['name'];
		$userMail = $particularUserDetails['email'];
		$rm_id = $particularUserDetails['rm_id'];

		$rmDetails = [];
		$rmDetails = getRMDetails($conn,$rm_id);
		$rmName = $rmDetails['name'];
		$rmEmail = $rmDetails['email'];

        $to = $rmEmail; $cc = $hrEmail;
        $subject = "Leave Request - $userName";
        $body = "Hi $rmName,<br><br>$userName has applied for following leaves:<br>$message<a href='$url/redirecting.php' target='_blank'>Click here to view!</a><br><br>Thanks,<br>TagOps.";
        $send_mail_value = send_email( $to,$cc,$subject,$body );
        header( 'Content-Type: application/json' );
        echo json_encode( $send_mail_value );
    }                             
}

?>