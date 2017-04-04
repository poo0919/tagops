<?php
//api for checking if comp off's are expired or not
include 'connection.php';
	
	$today=date("Y-m-d");
    $query="select * from leave_data where type_id='2' AND status NOT LIKE '5'";
    $result = mysqli_query($conn,$query)or die(mysqli_error($conn));
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()){    
        	$expiryDate=$row['expiry_date'];
        	$id=$row['id'];
        	if($today>=$expiryDate){
        		$q2="update leave_data set status='5' where id='$id'";
        		$re2 = mysqli_query($conn,$q2)or die(mysqli_error($conn));
        	}
        }
    }                              
                                                          
?>