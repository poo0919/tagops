<?php 
  //add new inventory to db and  check if it is assigned to someone or not
include 'connection.php';
include 'session.php';

   if($_POST['ACTION']=='changeDetails'){
   		// fetching details
         $assetId=$_POST['assetId'];
         $chgDescription=$_POST['chgDescription'];  
         $ownerName=$_POST['ownerName'];
         $newStatus=$_POST['newStatus']; 
         $rentName=$_POST['rentName'];
         $newAssignedEmail=$_POST['newAssignedEmail'];
         $chgInvId=$_POST['chgInvId'];
         $chgPrice=$_POST['chgPrice'];

         if($newAssignedEmail!='0'){ //if inventory is assigned to someone

	        $sql="select id from user where email='$newAssignedEmail'"; // fetch user_id with the help of email
	        $result = mysqli_query($conn, $sql)or die(mysqli_error($conn));
	        $row = $result->fetch_array();
	        $row_cnt = mysqli_num_rows($result); 
	        if ($row_cnt==1) {

	         	$assigned_user_id=$row['id'];
	            $query = "UPDATE  inventory SET type='$assetId',description='$chgDescription',price='$chgPrice',owner='$ownerName',rental_company='$rentName',status='$newStatus',assigned_to='$assigned_user_id' WHERE id='$chgInvId'";
	            $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	            if ($result === TRUE) {
	                echo "1";
	            }else {
	                echo "0";
	            }

			}else{
				echo "2";
				exit();
			}

		}else{ // if inventory is not assigned to anyone

				$query = "UPDATE  inventory SET type='$assetId',description='$chgDescription',price='$chgPrice',owner='$ownerName',rental_company='$rentName',status='$newStatus',assigned_to='$newAssignedEmail' WHERE id='$chgInvId'";
	            $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
	            if ($result === TRUE) {
	                echo "1";
	            }else {
	                echo "0";
	            }

		}
       exit();
   }
   
?>