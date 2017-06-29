<?php
	// Include database file
	include_once('database.php');
    include_once('commonUtilities.php');
    require_once('email.php');
	$conn = getDB();
    $today=date("Y-m-d");

    $query="SELECT * FROM leave_data WHERE type_id='2' AND status='3'";
    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()){    
          $expiryDate=$row['expiry_date'];
        	$id=$row['id'];
        	if($today>=$expiryDate){
        		$q2="UPDATE leave_data SET status='5' WHERE id='$id'";
        		$re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
        	}
        }
    }  

    $user_id=""; $compoff_count="";
    $q1="SELECT id FROM user";
    $re2=mysqli_query($conn,$q1)or die(mysqli_error($conn));
    if ($re2->num_rows > 0) {
        while($ro2 = $re2->fetch_array()){
            $user_id=$ro2['id'];
            $q1="SELECT COUNT(*) AS compoff_count FROM leave_data WHERE (user_id='$user_id' AND status='3' AND type_id='2')";
            $re1=mysqli_query($conn,$q1)or die(mysqli_error($conn));
            if ($re1->num_rows > 0) {
                while($ro1 = $re1->fetch_array()){
                    $compoff_count=$ro1['compoff_count'];                    
                }
            }

            $q2="UPDATE leaves SET comp_off='$compoff_count' WHERE user_id='$user_id'";
            $result = mysqli_query($conn,$q2)or die(mysqli_error($conn));
            if ($result === TRUE) {
                //echo "yoyo \n";
            }
        }
    }  

    $flag=0; $birthdayPersons="";
    $query="SELECT * FROM user WHERE status='1'";
    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()){ 
            $bdayDate = date('Y-m',strtotime($row['birthday']));
            $todayDate = date('Y-m',strtotime($today));
            if($todayDate==$bdayDate){
                $flag=1;
                $birthdayPersons.=$row['name'].",";
            }
        }
    }      

    $HRDetails = [];
    $HRDetails = getHRDetails($conn);
    if($flag==1){
            $to = $HRDetails['email'];
            $cc = "";
            $subject = "Birthdays Today";
            $body = "Hi ".$HRDetails['name'].",<br><br>Following employees have their birthday today:<br>$birthdayPersons<br><br>Thanks,<br>TagOps.";
            $send_mail_value = send_email( $to,$cc,$subject,$body );
            echo var_dump($send_mail_value);
    }
                    
?>