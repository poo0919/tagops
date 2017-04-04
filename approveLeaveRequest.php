<?php
//approving leave request in reportees tab
include 'connection.php';
include 'empSession.php';

if(isset($_POST['applyLeaveId'])){
    $applyLeaveId=$_POST['applyLeaveId'];
    $leaveTypeId=$_POST['leaveTypeId'];
    $userId=$_POST['userId'];

    if($leaveTypeId=="2"){
    	$status="4";
    }else if($leaveTypeId=="1"){
    	$status="2";
    }else if($leaveTypeId=="3"){
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
                        $rh-=1;
                        $q2="update leaves set rh='$rh' where user_id='$userId'";
                        $re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
                        if ($re2 === TRUE) {
                             echo "1";
                        }
                         
                    }else {
                        echo "0";
                    }
                }else{
                    echo "2";
                }
                
            }else{
                $query="update leave_data set status='$status' where id='$applyLeaveId'";
                $result = mysqli_query($conn,$query)or die(mysqli_error($conn));

                if ($result === TRUE) {
                     echo "1";
                }else {
                    echo "0";
                }
            }


	        



}                               
                                
?>