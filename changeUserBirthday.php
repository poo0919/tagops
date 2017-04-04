
<?php

include "connection.php" ;
include "empSession.php";
//updating personal email of user from user panel

if($_POST['userId'])
{
	if(!empty($_POST['birthday']))
	{	
		$userId=mysql_escape_String($_POST['userId']);
		$userBirthday=mysql_escape_String($_POST['birthday']);
		$sql = "update user set birthday='$userBirthday' where id='$userId'";
		$result=mysqli_query($conn,$sql)or die(mysqli_error($conn));
		if($result === TRUE) {
			echo 1;
		}
		else {
		   	echo 0;
		}
	}else echo 2;



}
?>