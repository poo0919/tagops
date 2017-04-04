<?php
//api for deleting a comp off entry

include 'connection.php';
include 'empSession.php';

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
                                
?>