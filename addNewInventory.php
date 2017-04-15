<?php 
  //add new inventory to db and  check if it is assigned to someone or not
include 'connection.php';
include 'session.php';

   if($_POST['ACTION']=='addInventory'){
   		// fetching details
         $assetType=$_POST['TYPE'];
         $description=$_POST['DESCRIPTION'];  
         $owner=$_POST['OWNER'];
         $status=$_POST['STATUS']; 
         $assignedTo=$_POST['ASSIGNEDTO'];
         $rentCompany=$_POST['RENTCOMPANY'];
         $price=$_POST['PRICE'];

         if($assignedTo!='0'){ //if inventory is assigned to someone

	        $sql="select id from user where email='$assignedTo'"; // fetch user_id with the help of email
	        $result = mysqli_query($conn, $sql)or die(mysqli_error($conn));
	        $row = $result->fetch_array();
	        $row_cnt = mysqli_num_rows($result); 
	        if ($row_cnt==1) {

	         	$assigned_user_id=$row['id'];
	            $query = "INSERT INTO inventory (type,description,price,owner,rental_company,status,assigned_to) VALUES ('$assetType','$description','$price','$owner','$rentCompany','$status','$assigned_user_id')";
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

			$query = "INSERT INTO inventory (type,description,price,owner,rental_company,status,assigned_to) VALUES ('$assetType','$description','$price','$owner','$rentCompany','$status','$assignedTo')";
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