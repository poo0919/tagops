<?php

include "connection.php" ;
include "empSession.php";
//changing phone number of user from user panel

if($_POST['userId'])
{
	$userId=mysql_escape_String($_POST['userId']);
	$phoneNumber=$_POST['phoneNumber'];
	$sql = "update user set phone_number='$phoneNumber' where id='$userId'";
	$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
	if($result === TRUE) {
		echo 1;
	}
   	else {
   		echo 0;
   	}



}
?>