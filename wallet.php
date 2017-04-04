<?php
//api for adding balance to wallet for employees

if(isset($_POST['submit'])){
	include 'connection.php';
	$advance=$_POST['advance'];
	$remarks=$_POST['remarks'];
	$user_id=$_POST['id'];
	$date=$_POST['date'];

	if($advance== '' || $remarks=='' || $date==''){
		echo "<script type='text/javascript'>alert('Please fill all the fields!');window.location.replace('adminPanelUpdateEmp.php');</script>";

	}else{

		$query = "INSERT INTO wallet (user_id,date,transactions,remarks) VALUES ('$user_id','$date','$advance','$remarks')";
           $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
           
           if ($result === TRUE) {
                echo "<script type='text/javascript'>alert('Balance added to Wallet!');window.location.replace('adminPanelUpdateEmp.php');</script>";
           }else {
               echo "<script type='text/javascript'>alert('Unable to add Balance to Wallet!');window.location.replace('adminPanelUpdateEmp.php');</script>";
           }
	}

	

}
?>