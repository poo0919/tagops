<?php
//changing cl+pl+ml of a user 

include "connection.php" ;
include "session.php" ;

if($_POST['id'])
{
	$id=mysql_escape_String($_POST['id']);
	$first=mysql_escape_String($_POST['first']);
	$sql = "update leaves set pl_cl_ml='$first' where id='$id'";
	$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
	if($result === TRUE) {
		echo 1;
	}
   	else {
   		echo 0;
   	}



}
?>