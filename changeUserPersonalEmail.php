<?php

include "connection.php" ;
include "empSession.php";
//updating personal email of user from user panel

if($_POST['userId'])
{
	$userId=mysql_escape_String($_POST['userId']);
	$personalEmail=mysql_escape_String($_POST['personalEmail']);
	$sql = "update user set personal_email='$personalEmail' where id='$userId'";
	$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
	if($result === TRUE) {
		echo 1;
	}
   	else {
   		echo 0;
   	}



}
?>